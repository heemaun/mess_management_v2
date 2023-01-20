<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Month;
use App\Models\Member;
use App\Models\MemberMonth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MonthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(array_key_exists('status',$request->all())){
            if(strcmp('all',$request->status)===0){
                $status = ['pending','active','inactive'];
            }
            else{
                $status = [$request->status];
            }

            $months = Month::whereIn('status',$status)
                                ->where('name','LIKE','%'.$request->year.'-'.$request->month.'%')
                                ->orderBy('name','DESC')
                                ->paginate($request->limit);
            return response(view('month.search',compact('months')));
        }
        $months = Month::where('status','active')
                        ->orderBy('name','DESC')
                        ->paginate(10);
        return view('month.index',compact('months'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response(view('month.create'));
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
            'name'      => 'required|unique:months,name',
            'status'    => 'required',
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

            $month = Month::create([
                'user_id'   => getUser()->id,
                'name'      => $data['name'],
                'status'    => $data['status'],
            ]);

            if(strcmp('active',$month->status)==0){
                foreach(Member::where('status','active')->get() as $member){
                    $member->months()->attach($month->id,[
                        'user_id'           => getUser()->id,
                        'rent_this_month'   => ((strcmp('Ground Floor',$member->floor)==0) ? 850 : 900 ),
                        'due'               => $member->current_balance,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Month added successfully',
                'url'       => route('months.show',$month->id),
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
     * @param  \App\Models\Month  $month
     * @return \Illuminate\Http\Response
     */
    public function show(Month $month,Request $request)
    {
        $groundTotalPaid = 0;
        $groundTotalAdjustment = 0;
        $groundTotalRent = 0;
        $groundTotalDue = 0;

        $firstTotalPaid = 0;
        $firstTotalAdjustment = 0;
        $firstTotalRent = 0;
        $firstTotalDue = 0;

        $secondTotalPaid = 0;
        $secondTotalAdjustment = 0;
        $secondTotalRent = 0;
        $secondTotalDue = 0;

        $groundMembersMonths = MemberMonth::join('members','members_months.member_id','=','members.id')
                                ->where('members_months.month_id',$month->id)
                                ->where('members.floor','Ground Floor')
                                ->where('members.status','active')
                                ->select('members_months.*')
                                ->get();

        foreach($groundMembersMonths as $mm){
            foreach($mm->payments->where('status','active') as $p){
                $groundTotalPaid += $p->amount;
            }

            foreach($mm->adjustments->where('status','active') as $a){
                $groundTotalAdjustment += $a->amount;
            }

            $groundTotalRent += $mm->rent_this_month;
            $groundTotalDue += $mm->due;
        }

        $firstMembersMonths = MemberMonth::join('members','members_months.member_id','=','members.id')
                                ->where('members_months.month_id',$month->id)
                                ->where('members.floor','1st Floor')
                                ->where('members.status','active')
                                ->select('members_months.*')
                                ->get();

        foreach($firstMembersMonths as $mm){
            foreach($mm->payments->where('status','active') as $p){
                $firstTotalPaid += $p->amount;
            }

            foreach($mm->adjustments->where('status','active') as $a){
                $firstTotalAdjustment += $a->amount;
            }

            $firstTotalRent += $mm->rent_this_month;
            $firstTotalDue += $mm->due;
        }

        $secondMembersMonths = MemberMonth::join('members','members_months.member_id','=','members.id')
                                ->where('members_months.month_id',$month->id)
                                ->where('members.floor','2nd Floor')
                                ->where('members.status','active')
                                ->select('members_months.*')
                                ->get();

        foreach($secondMembersMonths as $mm){
            foreach($mm->payments->where('status','active') as $p){
                $secondTotalPaid += $p->amount;
            }

            foreach($mm->adjustments->where('status','active') as $a){
                $secondTotalAdjustment += $a->amount;
            }

            $secondTotalRent += $mm->rent_this_month;
            $secondTotalDue += $mm->due;
        }
        if(array_key_exists('from_home',$request->all())){
            return response(view('defult.home-table-loader',compact('groundMembersMonths','firstMembersMonths','secondMembersMonths','groundTotalPaid','groundTotalAdjustment','groundTotalRent','groundTotalDue','firstTotalPaid','firstTotalAdjustment','firstTotalRent','firstTotalDue','secondTotalPaid','secondTotalAdjustment','secondTotalRent','secondTotalDue')));
        }
        return response(view('month.show',compact('month','groundMembersMonths','firstMembersMonths','secondMembersMonths','groundTotalPaid','groundTotalAdjustment','groundTotalRent','groundTotalDue','firstTotalPaid','firstTotalAdjustment','firstTotalRent','firstTotalDue','secondTotalPaid','secondTotalAdjustment','secondTotalRent','secondTotalDue')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Month  $month
     * @return \Illuminate\Http\Response
     */
    public function edit(Month $month)
    {
        return response(view('month.edit',compact('month')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Month  $month
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Month $month)
    {
        $data = Validator::make($request->all(),[
            'activate'  => 'sometimes',
            'name'      => 'required_if:activate,false|unique:months,name,'.$month->id,
            'status'    => 'required',
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

            $tmpStatus = $month->status;

            if(!array_key_exists('activate',$data)){ // month activation of update
                $month->name    = $data['name'];
            }
            $month->status  = $data['status'];
            $month->user_id = getUser()->id;

            $month->save();

            if(strcmp('active',$month->status)==0 && strcmp($tmpStatus,'active')!=0 && count(MemberMonth::where('month_id',$month->id)->get())==0){ // checking previous status whether create new meber-months for this month
                foreach(Member::where('status','active')->get() as $member){
                    $member->months()->attach($month->id,[
                        'user_id'           => getUser()->id,
                        'rent_this_month'   => ((strcmp('Ground Floor',$member->floor)==0) ? 850 : 900 ),
                        'due'               => $member->current_balance,
                    ]);
                }
            }
            // else if(strcmp('active',$month->status) != 0 && strcmp($tmpStatus,'active') != 0 && count(MemberMonth::where('month_id',$month->id)) !=0 ){
            //     foreach(MemberMonth::where('month_id',$month->id) as $mm){
            //         $mm->status = $month->status;
            //         $mm->save();
            //     }
            // }

            DB::commit();

            return response()->json([
                'status'    => 'success',
                'message'   => (!array_key_exists('activate',$data)) ? 'Month updated successfully' : 'Month activated successfully',
                'url'       => route('months.show',$month->id),
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
     * @param  \App\Models\Month  $month
     * @return \Illuminate\Http\Response
     */
    public function destroy(Month $month,Request $request)
    {
        $data = Validator::make($request->all(),[
            'password'          => 'required|min:8|max:20',
            'permanent_delete'  => 'required',
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
                if(strcmp($data['permanent_delete'],'true')==0){
                    $month->delete();
                }
                else{
                    $month->status = 'deleted';
                    $month->save();

                    foreach($month->memberMonths as $mm){
                        foreach($mm->payments as $p){
                            $p->status = 'deleted';
                            $p->save();
                        }

                        foreach($mm->adjustments as $a){
                            $a->status = 'deleted';
                            $a->save();
                        }
                    }
                }

                DB::commit();

                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Month deleted successfully',
                    'url'       => route('months.index'),
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
