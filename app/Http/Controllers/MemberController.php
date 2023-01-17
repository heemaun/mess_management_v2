<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Month;
use App\Models\Member;
use App\Models\Payment;
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
        if(array_key_exists('search',$request->all())){ // checking if request is made for search result
            if(strcmp('all',$request->status)===0){ //all status except deleted
                $status = ['pending','active','inactive','banned','restricted'];
            }
            else{
                $status = [$request->status]; //deleted can only be found here
            }

            if(strcmp('all',$request->floor)===0){
                $floor = ['Ground Floor','1st Floor','2nd Floor'];
            }
            else{
                $floor = [$request->floor];
            }

            if(is_numeric($request->search)){ // search by phone number
                $members = Member::where('phone',$request->search)
                                ->whereIn('status',$status)
                                ->whereIn('floor',$floor)
                                ->orderBy('floor','ASC')
                                ->orderBy('status','DESC')
                                ->orderBy('name','ASC')
                                ->get();
            }
            else if(Str::contains($request->search, '@')){ // search by email
                $members = Member::where('email',$request->search)
                                ->whereIn('status',$status)
                                ->whereIn('floor',$floor)
                                ->orderBy('floor','ASC')
                                ->orderBy('status','DESC')
                                ->orderBy('name','ASC')
                                ->get();
            }
            else{ //search by name
                $members = Member::where('name','LIKE','%'.$request->search.'%')
                                ->whereIn('status',$status)
                                ->whereIn('floor',$floor)
                                ->orderBy('floor','ASC')
                                ->orderBy('status','DESC')
                                ->orderBy('name','ASC')
                                ->get();
            }
            return response(view('member.search',compact('members')));
        }
        $members = Member::where('status','active')
                            ->orderBy('floor','ASC')
                            ->orderBy('status','DESC')
                            ->orderBy('name','ASC')
                            ->get();
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
        //validation check
        $data = Validator::make($request->all(),[
            'name'              => 'required|min:3|max:30',
            'email'             => 'required|email',
            'phone'             => 'required|digits:11',
            'status'            => 'required',
            'floor'             => 'required',
            'initial_balance'   => 'required|numeric',
        ]);

        //returning validation error
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
                'status'            => $data['status'],
                'initial_balance'   => $data['initial_balance'],
                'current_balance'   => $data['initial_balance'],
                'joining_date'      => date('Y-m-d'),
            ]);

            if(array_key_exists('picture',$data)){ // checking if image is uploaded
                $imageName = time().'.'.$data['picture']->extension();

                $data['picture']->move(public_path('images'),$imageName);

                $member->picture = $imageName;
                $member->save();
            }

            if(Month::where('name',date('Y-m'))->where('status','active')->first() != null){ // creating ember-months based on member & month status
                $member->current_balance += (strcmp('Ground Floor',$member->floor)==0) ? 850 : 900;
                $member->save();

                $member->months()->attach(Month::where('name',date('Y-m'))->where('status','active')->first()->id,[
                    'user_id'           => getUser()->id,
                    'rent_this_month'   => ((strcmp('Ground Floor',$member->floor)==0) ? 850 : 900 ),
                    'due'               => $member->current_balance,
                ]);
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
        //generating last 5 payments
        $payments = Payment::join('members_months','payments.member_month_id','=','members_months.id')
                                ->where('members_months.member_id',$member->id)
                                ->where('payments.status','active')
                                ->orderBy('payments.created_at','DESC')
                                ->select('payments.*')
                                ->limit(5)
                                ->get();
        return response(view('member.show',compact('member','payments')));
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
        //validation check
        $data = Validator::make($request->all(),[
            'name'              => 'required|string|min:3|max:30',
            'email'             => 'required|email|unique:members,email,'.$member->id,
            'phone'             => 'required|digits:11|unique:members,phone,'.$member->id,
            'status'            => 'required',
            'floor'             => 'required',
            'initial_balance'   => 'required|numeric',
            'current_balance'   => 'required|numeric',
            'joining_date'      => 'nullable|date',
            'leaving_date'      => 'required_if:status,deleted|date',
        ]);

        //returning validation error
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
            if(strcmp('deleted',$data['status'])==0){
                $member->leaving_date       = $data['leaving_date'];
            }
            $member->user_id            = getUser()->id;

            $member->save();

            $month = Month::where('name',date('Y-m'))->first();

            //checking if member status is activated then create member month
            if(strcmp($tmpStatus,'active') != 0 && strcmp($member->status,'active') == 0 && MemberMonth::where('member_id',$member->id)->where('month_id',$month->id)->first() === null){
                $member->months()->attach([
                    'user_id'           => getUser()->id,
                    'rent_this_month'   => ((strcmp('Ground Floor',$member->floor)==0) ? 850 : 900 ),
                    'due'               => $member->current_balance
                ]);
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
        //validation check
        $data = Validator::make($request->all(),[
            'password' => 'required|min:8|max:20',
        ]);

        //returning validation error
        if($data->fails()){
            return response()->json([
                'status' => 'errors',
                'errors' => $data->errors(),
            ]);
        }

        DB::beginTransaction();

        try{
            $data = $data->validate();

            if(Hash::check($data['password'],getUser()->password)){ // checking user password
                if($request->permanent_delete === 1){ //checking permanent delete
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
