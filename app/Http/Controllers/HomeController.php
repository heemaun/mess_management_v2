<?php

namespace App\Http\Controllers;

use App\Models\Month;
use App\Models\Member;
use App\Models\Notice;
use App\Models\MemberMonth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
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

        // $groundMemberMonths = MemberMonth::join('members','members-months.member_id','=','members.id')
        //                         ->where('members-months.month_id',$month->last()->id)
        //                         ->whereIn('members.status','Ground Floor')
        //                         ->select('members-months.*')
        //                         ->get();

        // $firstMemberMonths = MemberMonth::join('members','members-months.member_id','=','members.id')
        //                         ->where('members-months.month_id',$month->last()->id)
        //                         ->whereIn('members.status','1st Floor')
        //                         ->select('members-months.*')
        //                         ->get();
        // $secondMemberMonths = MemberMonth::join('members','members-months.member_id','=','members.id')
        //                         ->where('members-months.month_id',$month->last()->id)
        //                         ->whereIn('members.status','2nd Floor')
        //                         ->select('members-months.*')
        //                         ->get();
        return response(view('defult.home',compact('months')));
    }
}
