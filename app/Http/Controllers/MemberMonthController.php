<?php

namespace App\Http\Controllers;

use App\Models\Month;
use App\Models\Member;
use App\Models\MemberMonth;
use Illuminate\Http\Request;

class MemberMonthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit = 5; // this is the number of months will be shown in ther dashboard
        $m = array(); //
        $months = Month::where('status','active')
                        ->orderBy('name','DESC')
                        ->limit($limit)
                        ->get('id');

        $groundMembers = Member::where('floor','Ground Floor')
                                ->where('status','active')
                                ->get('id');
        $firstMembers = Member::where('floor','1st Floor')
                                ->where('status','active')
                                ->get('id');
        $secondMembers = Member::where('floor','2nd Floor')
                                ->where('status','active')
                                ->get('id');

        $gm = array();
        $fm = array();
        $sm = array();

        foreach($months as $month){
            // storing member months of each month based on member floor

            // each index of $gm,$fm,$sm will be a months membermonths
            $mm = MemberMonth::whereIn('month_id',$month)
                                ->whereIn('member_id',$groundMembers)
                                ->get();
            array_push($gm,$mm);

            $mm = MemberMonth::whereIn('month_id',$month)
                                ->whereIn('member_id',$firstMembers)
                                ->get();
            array_push($fm,$mm);

            $mm = MemberMonth::whereIn('month_id',$month)
                                ->whereIn('member_id',$secondMembers)
                                ->get();
            array_push($sm,$mm);
        }

        for($x=0;$x<count($gm);$x++){
            $gm_payment = 0;
            $fm_payment = 0;
            $sm_payment = 0;

            //storing total payments of a floor members using membermonths of that floor
            foreach($gm[$x] as $mm){
                $gm_payment += $mm->payments->where('status','active')->sum('amount');
            }

            foreach($fm[$x] as $mm){
                $fm_payment += $mm->payments->where('status','active')->sum('amount');
            }

            foreach($sm[$x] as $mm){
                $sm_payment += $mm->payments->where('status','active')->sum('amount');
            }

            //this data consists of all floor rent,due & payments based on the member months by floor
            //each index will refer to a month worth of data
            $m[$x] = [
                'gm_rent' => $gm[$x]->sum('rent_this_month'),
                'fm_rent' => $fm[$x]->sum('rent_this_month'),
                'sm_rent' => $sm[$x]->sum('rent_this_month'),
                'gm_payment' => $gm_payment,
                'fm_payment' => $fm_payment,
                'sm_payment' => $sm_payment,
                'gm_due' => $gm[$x]->sum('due'),
                'fm_due' => $fm[$x]->sum('due'),
                'sm_due' => $sm[$x]->sum('due'),
            ];
        }

        return response()->json([
            'm' => $m,
            'months' => Month::where('status','active')
                                ->orderBy('name','DESC')
                                ->limit($limit)
                                ->get('name'),
        ]);
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
     * @param  \App\Models\MemberMonth  $memberMonth
     * @return \Illuminate\Http\Response
     */
    public function show(MemberMonth $memberMonth)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MemberMonth  $memberMonth
     * @return \Illuminate\Http\Response
     */
    public function edit(MemberMonth $memberMonth)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MemberMonth  $memberMonth
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MemberMonth $memberMonth)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MemberMonth  $memberMonth
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemberMonth $memberMonth)
    {
        //
    }
}
