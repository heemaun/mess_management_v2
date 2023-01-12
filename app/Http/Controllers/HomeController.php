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

        $groundMembersMonths = MemberMonth::join('members','members_months.member_id','=','members.id')
                                ->where('members_months.month_id',$months->last()->id)
                                ->where('members.floor','Ground Floor')
                                ->where('members.status','active')
                                ->select('members_months.*')
                                ->get();

        $firstMembersMonths = MemberMonth::join('members','members_months.member_id','=','members.id')
                                ->where('members_months.month_id',$months->last()->id)
                                ->where('members.floor','1st Floor')
                                ->where('members.status','active')
                                ->select('members_months.*')
                                ->get();
        $secondMembersMonths = MemberMonth::join('members','members_months.member_id','=','members.id')
                                ->where('members_months.month_id',$months->last()->id)
                                ->where('members.floor','2nd Floor')
                                ->where('members.status','active')
                                ->select('members_months.*')
                                ->get();
        return response(view('defult.home',compact('months','groundMembersMonths','firstMembersMonths','secondMembersMonths')));
    }
}
