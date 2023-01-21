<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Month;
use App\Models\Member;
use App\Models\Adjustment;
use App\Models\MemberMonth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('login');
    }

    public function index(Request $request)
    {
        if(array_key_exists('search',$request->all())){
            if(strcmp('all',$request->status)===0){
                $status = ['pending','active','inactive'];
            }
            else{
                $status = [$request->status];
            }

            if(strcmp('all',$request->type)===0){
                $type = ['fine','adjustment'];
            }
            else{
                $type = [$request->type];
            }

            if(is_numeric($request->search)){
                $adjustments = Adjustment::join('members_months','adjustments.member_month_id','=','members_months.id')
                                    ->join('members','members_months.member_id','=','members.id')
                                    ->where('members.phone',$request->search)
                                    ->whereIn('adjustments.type',$type)
                                    ->whereIn('adjustments.status',$status)
                                    ->whereBetween('adjustments.created_at',[$request->from,$request->to])
                                    ->select('adjustments.*')
                                    ->orderBy('adjustments.created_at','DESC')
                                    ->orderBy('members.floor','ASC')
                                    ->orderBy('members.name','ASC')
                                    ->paginate($request->limit);
            }
            else if(Str::contains($request->search, '@')){
                $adjustments = Adjustment::join('members_months','adjustments.member_month_id','=','members_months.id')
                                    ->join('members','members_months.member_id','=','members.id')
                                    ->where('members.email',$request->search)
                                    ->whereIn('adjustments.type',$type)
                                    ->whereIn('adjustments.status',$status)
                                    ->whereBetween('adjustments.created_at',[$request->from,$request->to])
                                    ->select('adjustments.*')
                                    ->orderBy('adjustments.created_at','DESC')
                                    ->orderBy('members.floor','ASC')
                                    ->orderBy('members.name','ASC')
                                    ->paginate($request->limit);
            }
            else{
                $adjustments = Adjustment::join('members_months','adjustments.member_month_id','=','members_months.id')
                                    ->join('members','members_months.member_id','=','members.id')
                                    ->where('members.name','LIKE','%'.$request->search.'%')
                                    ->whereIn('adjustments.type',$type)
                                    ->whereIn('adjustments.status',$status)
                                    ->whereBetween('adjustments.created_at',[$request->from,$request->to])
                                    ->select('adjustments.*')
                                    ->orderBy('adjustments.created_at','DESC')
                                    ->orderBy('members.floor','ASC')
                                    ->orderBy('members.name','ASC')
                                    ->paginate($request->limit);
            }
            return response(view('adjustment.search',compact('adjustments')));
        }
        $adjustments = Adjustment::where('status','active')
                            // ->orderBy('floor','ASC')
                            ->orderBy('created_at','DESC')
                            ->paginate(10);
        return response(view('adjustment.index',compact('adjustments')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $members = Member::where('status','active')
                        ->orderBy('floor','ASC')
                        ->orderBy('name','ASC')
                        ->get();
        return response(view('adjustment.create',compact('members')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Validator::make($request->all(),[
            'member_id' => 'required',
            'amount'    => 'required|numeric|min:1',
            'status'    => 'required',
            'type'      => 'required',
            'note'      => 'nullable|string',
        ],$messages =[
            'member_id.required' => 'A member is required',
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

            $month = Month::where('status','active')
                            ->where('name',date('Y-m'))
                            ->first();

            if($month === null){
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Please first activate running month',
                ]);
            }

            $adjustment = Adjustment::create([
                'user_id'           => getUser()->id,
                'member_month_id'   => MemberMonth::where('month_id',$month->id)->where('member_id',$data['member_id'])->first()->id,
                'amount'            => $data['amount'],
                'status'            => $data['status'],
                'type'              => $data['type'],
                'note'              => $data['note'],
            ]);

            if(strcmp('active',$adjustment->status)==0){
                if(strcmp('fine',$adjustment->type)==0){
                    $adjustment->memberMonth->due += $adjustment->amount;
                    $adjustment->memberMonth->member->current_balance += $adjustment->amount;
                }
                else{
                    $adjustment->memberMonth->due -= $adjustment->amount;
                    $adjustment->memberMonth->member->current_balance -= $adjustment->amount;
                }
                $adjustment->memberMonth->save();
                $adjustment->memberMonth->member->save();
            }

            DB::commit();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Adjustment added successfully',
                'url'       => route('adjustments.show',$adjustment->id),
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
     * @param  \App\Models\Adjustment  $adjustment
     * @return \Illuminate\Http\Response
     */
    public function show(Adjustment $adjustment)
    {
        return response(view('adjustment.show',compact('adjustment')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Adjustment  $adjustment
     * @return \Illuminate\Http\Response
     */
    public function edit(Adjustment $adjustment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Adjustment  $adjustment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Adjustment $adjustment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adjustment  $adjustment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Adjustment $adjustment,Request $request)
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
                $member = $adjustment->memberMonth->member;
                $month = $adjustment->memberMonth->month;
                $amount = $adjustment->amount;
                $type = $adjustment->type;

                $adjustment->delete();

                if(strcmp($type,'fine')==0){
                    $member->current_balance -= $amount;
                }
                else{
                    $member->current_balance += $amount;
                }
                $member->save();



                $months = Month::where('status','active')
                                ->where('name','>=',$month->name)
                                ->orderBy('name','DESC')
                                ->get();

                foreach($months as $m){
                    $memberMonth = MemberMonth::where('member_id',$member->id)
                                                ->where('month_id',$m->id)
                                                ->first();

                    if(strcmp($type,'fine')==0){
                        $memberMonth->due -= $amount;
                    }
                    else{
                        $memberMonth->due += $amount;
                    }
                    $memberMonth->save();
                }

                DB::commit();

                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Adjustment deleted successfully',
                    'url'       => route('adjustments.index'),
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
