<?php

namespace App\Http\Controllers;

use App\Models\Month;
use App\Models\Member;
use App\Models\Notice;
use App\Models\MemberMonth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

        $groundMembersMonths = MemberMonth::join('members','members_months.member_id','=','members.id')
                                ->where('members_months.month_id',$months->last()->id)
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
                                ->where('members_months.month_id',$months->last()->id)
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
                                ->where('members_months.month_id',$months->last()->id)
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
}
