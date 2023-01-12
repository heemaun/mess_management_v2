<?php

namespace App\Http\Controllers;

use App\Models\Month;
use App\Models\MemberMonth;
use Illuminate\Http\Request;

class MonthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Month  $month
     * @return \Illuminate\Http\Response
     */
    public function show(Month $month)
    {
        $groundMembersMonths = MemberMonth::join('members','members_months.member_id','=','members.id')
                                ->where('members_months.month_id',$month->id)
                                ->where('members.floor','Ground Floor')
                                ->where('members.status','active')
                                ->select('members_months.*')
                                ->get();

        $firstMembersMonths = MemberMonth::join('members','members_months.member_id','=','members.id')
                                ->where('members_months.month_id',$month->id)
                                ->where('members.floor','1st Floor')
                                ->where('members.status','active')
                                ->select('members_months.*')
                                ->get();
        $secondMembersMonths = MemberMonth::join('members','members_months.member_id','=','members.id')
                                ->where('members_months.month_id',$month->id)
                                ->where('members.floor','2nd Floor')
                                ->where('members.status','active')
                                ->select('members_months.*')
                                ->get();
        return response(view('defult.home-table-loader',compact('groundMembersMonths','firstMembersMonths','secondMembersMonths')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Month  $month
     * @return \Illuminate\Http\Response
     */
    public function edit(Month $month)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Month  $month
     * @return \Illuminate\Http\Response
     */
    public function destroy(Month $month)
    {
        //
    }
}
