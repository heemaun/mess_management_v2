<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Month;
use App\Models\Member;
use App\Models\Notice;
use App\Models\Payment;
use App\Models\MemberMonth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Notifications\ForgetPasswordNotification;

class HomeController extends Controller
{
    public function index()
    {
        $month = Month::where('name',date('Y-m'))->first();

        if($month === null){
            $month = Month::create([
                'name'      => date('Y-m'),
                'status'    => 'pending',
                'user_id'   => 1,
            ]);
        }

        $notices = Notice::where('status','active')
                            ->orderBy('created_at','DESC')
                            ->limit(5)
                            ->get();

        return view('defult.index',compact('notices'));
    }

    public function home()
    {
        if(checkLogin()){
            $gm = Member::where('status','active')
                        ->where('floor','Ground Floor')
                        ->orderBy('current_balance','DESC')
                        ->first();
            $fm = Member::where('status','active')
                        ->where('floor','1st Floor')
                        ->orderBy('current_balance','DESC')
                        ->first();
            $sm = Member::where('status','active')
                        ->where('floor','2nd Floor')
                        ->orderBy('current_balance','DESC')
                        ->first();
            return response(view('defult.dashboard',compact('gm','fm','sm')));
        }
        $months = Month::where('status','active')
                        ->orderBy('name','DESC')
                        ->get();

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

        $groundMembersMonths = array();
        $firstMembersMonths = array();
        $secondMembersMonths = array();

        if(count($months) === 0){
            return response(view('defult.home',compact('months','groundMembersMonths','firstMembersMonths','secondMembersMonths','groundTotalPaid','groundTotalAdjustment','groundTotalRent','groundTotalDue','firstTotalPaid','firstTotalAdjustment','firstTotalRent','firstTotalDue','secondTotalPaid','secondTotalAdjustment','secondTotalRent','secondTotalDue')));
        }

        $groundMembersMonths = MemberMonth::join('members','members_months.member_id','=','members.id')
                                ->where('members_months.month_id',$months->first()->id)
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
                                ->where('members_months.month_id',$months->first()->id)
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
                                ->where('members_months.month_id',$months->first()->id)
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

        return response(view('defult.home',compact('months','groundMembersMonths','firstMembersMonths','secondMembersMonths','groundTotalPaid','groundTotalAdjustment','groundTotalRent','groundTotalDue','firstTotalPaid','firstTotalAdjustment','firstTotalRent','firstTotalDue','secondTotalPaid','secondTotalAdjustment','secondTotalRent','secondTotalDue')));
    }

    function checkLoginHome()
    {
        return response()->json([
            'login' => checkLogin(),
        ]);
    }

    public function getForgetPassword(Request $request)
    {
        if($request->stage == 0){
            return response(view('defult.forget-password-forms.email-checker'));
        }
        else if($request->stage == 1){
            return response(view('defult.forget-password-forms.confirm-code'));
        }
        else if($request->stage == 2){
            return response(view('defult.forget-password-forms.new-password'));
        }
        else{
            return response($request->all());
        }
    }

    public function forgetPassword(Request $request)
    {
        if($request->stage == 0){
            $data = Validator::make($request->all(),[
                'email' => 'required|email',
            ]);

            //returning validation error
            if($data->fails()){
                return response()->json([
                    'status' => 'errors',
                    'errors' => $data->errors(),
                ]);
            }

            $data = $data->validate();

            $user = User::where('status','active')
                        ->where('email',$data['email'])
                        ->first();

            if($user !== null){
                $code = rand(1000,9999);
                $user->remember_token = Hash::make($code);
                // $user->remember_token = $code;
                $user->save();

                $user->notify(new ForgetPasswordNotification($user,$code));
                return response()->json([
                    'url'           => route('forget-password'),
                    'stage'         => 1,
                    'user_email'    => $data['email'],
                    'status'        => 'success',
                    'message'       => 'A 4-digit code has been sent to your email'
                ]);
            }

            return response()->json([
                'status'    => 'error',
                'message'   => 'Invalid email address!',
            ]);
        }

        else if($request->stage == 1){
            $data = Validator::make($request->all(),[
                'code'          => 'required|numeric',
                'user_email'    => 'required|email',
            ]);

            //returning validation error
            if($data->fails()){
                return response()->json([
                    'status' => 'errors',
                    'errors' => $data->errors(),
                ]);
            }

            $data = $data->validate();

            $user = User::where('email',$data['user_email'])->first();

            if(Hash::check($data['code'],$user->remember_token)){
            // if(strcmp($data['code'],$user->remember_token)==0){
                return response()->json([
                    'url'           => route('forget-password'),
                    'stage'         => 2,
                    'user_email'    => $user->email,
                    'status'        => 'success',
                    'message'       => 'Code confirmed'
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Code does not match',
            ]);
        }

        else if($request->stage == 2){
            $data = Validator::make($request->all(),[
                'user_email'                => 'required|email',
                'new_password'              => 'required|min:8|max:20|confirmed',
                'new_password_confirmation' => 'required|min:8|max:20',
            ]);

            //returning validation error
            if($data->fails()){
                return response()->json([
                    'status' => 'errors',
                    'errors' => $data->errors(),
                ]);
            }

            $data = $data->validate();

            $user = User::where('email',$data['user_email'])->first();
            $user->password = Hash::make($data['new_password']);
            $user->remember_token = '';
            $user->save();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Password changed successfully',
                'login'     => true,
            ]);
        }
    }
}
