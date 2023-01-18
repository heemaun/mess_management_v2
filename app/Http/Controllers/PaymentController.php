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

class PaymentController extends Controller
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
                $status = ['pending','active','deleted','inactive'];
            }
            else{
                $status = [$request->status];
            }

            if(is_numeric($request->search)){
                $payments = Payment::join('members_months','payments.member_month_id','=','members_months.id')
                                    ->join('members','members_months.member_id','=','members.id')
                                    ->where('members.phone',$request->search)
                                    ->whereIn('payments.status',$status)
                                    ->whereBetween('payments.created_at',[$request->from,$request->to])
                                    ->select('payments.*')
                                    ->orderBy('members.floor','ASC')
                                    ->orderBy('payments.created_at','DESC')
                                    ->orderBy('members.name','ASC')
                                    ->get();
            }
            else if(Str::contains($request->search, '@')){
                $payments = Payment::join('members_months','payments.member_month_id','=','members_months.id')
                                    ->join('members','members_months.member_id','=','members.id')
                                    ->where('members.email',$request->search)
                                    ->whereIn('payments.status',$status)
                                    ->whereBetween('payments.created_at',[$request->from,$request->to])
                                    ->select('payments.*')
                                    ->orderBy('members.floor','ASC')
                                    ->orderBy('payments.created_at','DESC')
                                    ->orderBy('members.name','ASC')
                                    ->get();
            }
            else{
                $payments = Payment::join('members_months','payments.member_month_id','=','members_months.id')
                                    ->join('members','members_months.member_id','=','members.id')
                                    ->where('members.name','LIKE','%'.$request->search.'%')
                                    ->whereIn('payments.status',$status)
                                    ->whereBetween('payments.created_at',[$request->from,$request->to])
                                    ->select('payments.*')
                                    ->orderBy('members.floor','ASC')
                                    ->orderBy('payments.created_at','DESC')
                                    ->orderBy('members.name','ASC')
                                    ->get();
            }
            return response(view('payment.search',compact('payments')));
        }
        $payments = Payment::where('status','active')
                            // ->orderBy('floor','ASC')
                            ->orderBy('created_at','DESC')
                            ->get();
        return response(view('payment.index',compact('payments')));
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
        return response(view('payment.create',compact('members')));
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

            $payment = Payment::create([
                'user_id'           => getUser()->id,
                'member_month_id'   => MemberMonth::where('month_id',$month->id)->where('member_id',$data['member_id'])->first()->id,
                'amount'            => $data['amount'],
                'status'            => $data['status'],
                'note'              => $data['note'],
            ]);

            if(strcmp('active',$payment->status)==0){
                $payment->memberMonth->due -= $payment->amount;
                $payment->memberMonth->save();

                $payment->memberMonth->member->current_balance -= $payment->amount;
                $payment->memberMonth->member->save();
            }

            DB::commit();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Payment added successfully',
                'url'       => route('payments.show',$payment->id),
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
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        return response(view('payment.show',compact('payment')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment,Request $request)
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
                $member = $payment->memberMonth->member;
                $month = $payment->memberMonth->month;
                $amount = $payment->amount;

                $payment->delete();

                $member->current_balance += $amount;
                $member->save();



                $months = Month::where('status','active')
                                ->where('name','>=',$month->name)
                                ->orderBy('name','DESC')
                                ->get();

                foreach($months as $m){
                    $memberMonth = MemberMonth::where('member_id',$member->id)
                                                ->where('month_id',$m->id)
                                                ->first();

                    $memberMonth->due += $amount;
                    $memberMonth->save();
                }

                DB::commit();

                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Payment deleted successfully',
                    'url'       => route('payments.index'),
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
