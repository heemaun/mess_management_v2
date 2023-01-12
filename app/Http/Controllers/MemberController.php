<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Month;
use App\Models\Member;
use App\Models\MemberMonth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(array_key_exists('search',$request->all())){
            if(strcmp('all',$request->status)===0){
                $status = ['pending','active','deleted','banned','restricted'];
            }
            else{
                $status = [$request->status];
            }

            if(strcmp('all',$request->status)===0){
                $floor = ['Ground Floor','1st Floor','2nd Floor'];
            }
            else{
                $floor = [$request->floor];
            }

            if(is_numeric($request->search)){
                $members = Member::where('phone',$request->search)
                                ->whereIn('status',$status)
                                ->whereIn('floor',$floor)
                                ->get();
            }
            else if(Str::contains($request->search, '@')){
                $members = Member::where('email',$request->search)
                                ->whereIn('status',$status)
                                ->whereIn('floor',$floor)
                                ->get();
            }
            else{
                $members = Member::where('name','LIKE','%'.$request->search.'%')
                                ->whereIn('status',$status)
                                ->whereIn('floor',$floor)
                                ->get();
            }
            return response(view('member.search',compact('members')));
        }
        return response(view('member.index',compact('members')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response(view('member.create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Validator::create($request->all(),[
            'name'              => 'required|min:3|max:30',
            'email'             => 'required|email',
            'phone'             => 'required|numeric',
            'status'            => 'required',
            'floor'             => 'required',
            'initial_balance'   => 'required|numeric',
        ]);

        if($data->fails()){
            return response()->json([
                'status' => 'errors',
                'errors' => $data->errors(),
            ]);
        }

        DB::beginTransaction();

        try{
            $data = $data->validate();

            $member = Member::create([
                'user_id'           => getUser()->id,
                'name'              => $data['name'],
                'email'             => $data['email'],
                'phone'             => $data['phone'],
                'floor'             => $data['floor'],
                'status'            => 'active',
                'initial_balance'   => $data['initial_balance'],
                'current_balance'   => $data['initial_balance'],
                'joining_date'      => date('Y-m-d'),
            ]);

            if(array_key_exists('picture',$data)){
                $imageName = time().'.'.$data['picture']->extension();

                $data['picture']->move(public_path('images'),$imageName);

                $member->picture = $imageName;
                $member->save();
            }

            if(Month::where('name',date('Y-m'))->first() != null){
                $member->months->attach(Month::where('name',date('Y-m'))->first());
            }

            DB::commit();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Member added successfully',
                'url'       => route('members.show',$member->id),
            ]);
        }catch(Exception $e){
            return response()->json([
                'status'    => 'exception',
                'message'   => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        return response(view('member.show',compact('member')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        return response(view('member.edit',compact('member')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $data = Validator::make($request->all(),[
            'name'              => 'required|string|min:3|max:30',
            'email'             => 'required|email|unique:members,email,'.$member->id,
            'phone'             => 'required|numeric|unique:members,phone,'.$member->id,
            'status'            => 'required',
            'floor'             => 'required',
            'initial_balance'   => 'required|numeric',
            'current_balance'   => 'required|numeric',
            'joining_date'      => 'required|date',
            'leaving_date'      => 'nullable|date',
        ]);

        if($data->fails()){
            return response()->json([
                'status' => 'errors',
                'errors' => $data->errors(),
            ]);
        }

        DB::beginTransaction();

        try{
            $data = $data->validate();

            $tmpStatus = $member->status;

            $member->name               = $data['name'];
            $member->email              = $data['email'];
            $member->phone              = $data['phone'];
            $member->status             = $data['status'];
            $member->floor              = $data['floor'];
            $member->initial_balance    = $data['initial_balance'];
            $member->current_balance    = $data['current_balance'];
            $member->joining_date       = $data['joining_date'];
            $member->leaving_date       = $data['leaving_date'];
            $member->user_id            = getUser()->id;

            $member->save();

            $month = Month::where('name',date('Y-m'))->first();

            if(strcmp($tmpStatus,'active') != 0 && strcmp($member->status,'active') == 0 && MemberMonth::where('member_id',$member->id)->where('month_id',$month->id)->first() === null){
                $member->months()->attach($month);
            }
            else if(strcmp($tmpStatus,'active') == 0 && strcmp($member->status,'active') != 0 && MemberMonth::where('member_id',$member->id)->where('month_id',$month->id)->first() !== null){
                $memberMonth = MemberMonth::where('member_id',$member->id)
                                            ->where('month_id',$month->id)
                                            ->first();

                $memberMonth->status = $member->status;
                $memberMonth->save();
            }

            DB::commit();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Member updated successfully',
                'url'       => route('members.show',$member->id),
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status'    => 'exception',
                'message'   => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member,Request $request)
    {
        $data = Validator::make($request->all(),[
            'password' => 'required|min:8|max:20',
        ]);

        if($data->fails()){
            return response()->json([
                'status' => 'errors',
                'errors' => $data->errors(),
            ]);
        }

        DB::beginTransaction();

        try{
            $data = $data->validate();

            if(Hash::check($data['password'],getUser()->password)){
                if($request->permanent_delete === 1){
                    $member->delete();
                }
                else{
                    $member->status = 'deleted';

                    $member->save();
                }

                DB::commit();

                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Member deleted successfully',
                    'url'       => route('members.index'),
                ]);
            }

            DB::rollBack();

            return response()->json([
                'status'    => 'error',
                'message'   => 'Incorrect password',
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status'    => 'exception',
                'message'   => $e->getMessage(),
            ]);
        }
    }
}
