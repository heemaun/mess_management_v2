<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberMonth;
use Exception;
use App\Models\Month;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                $payments = Payment::join('members','payments.members_id','=','members.id')
                                    ->where('member.phone',$request->search)
                                    ->whereIn('payments.status',$status)
                                    ->whereBetween('payments.created_at',[$request->from,$request->to])
                                    ->get();
            }
            else if(Str::contains($request->search, '@')){
                $payments = Payment::join('members','payments.members_id','=','members.id')
                                    ->where('member.email',$request->search)
                                    ->whereIn('payments.status',$status)
                                    ->whereBetween('payments.created_at',[$request->from,$request->to])
                                    ->get();
            }
            else{
                $payments = Payment::join('members','payments.members_id','=','members.id')
                                    ->where('member.name','LIKE','%'.$request->search.'%')
                                    ->whereIn('payments.status',$status)
                                    ->whereBetween('payments.created_at',[$request->from,$request->to])
                                    ->get();
            }
            return response(view('payment.search',compact('payments')));
        }
        return response(view('payment.index',compact('payments')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $months = Month::where('status','active')
                        ->orderby('name','DESC')
                        ->get();
        $members = Member::where('status','active')
                            ->orderby('name','DESC')
                            ->get();
        return response(view('payment.create',compact('month','member')));
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
            'member_id' => 'required',
            'amount'    => 'required|numeric',
            'status'    => 'required',
            'note'      => 'nullable|string',
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

            $month = Month::where('name',date('Y-m'))->first();

            if($month === null){
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Please first activate this month',
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
                $payment->borderMonth->due -= $payment->amount;
                $payment->borderMonth->save();

                $payment->member->current_balance += $payment->amount;
                $payment->member->save();
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
        return response(view('payment.edit',compact('payment')));
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
        $data = Validator::make($request->all(),[
            'member_id' => 'required',
            'amount'    => 'required|numeric',
            'status'    => 'required',
            'note'      => 'nullable|string',
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

            $payment->amount = $data['amount'];
            $payment->status = $data['status'];
            $payment->note = $data['note'];
            $payment->user_id = getUser()->id;

            $payment->save();

            DB::commit();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Payment updated successfully',
                'url'       => route('payments.show',$payment->id),
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
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
