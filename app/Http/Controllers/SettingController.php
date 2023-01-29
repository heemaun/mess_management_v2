<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('login');
        $this->middleware('guest')->only(['store','update','destroy']);
    }

    public function index(Request $request)
    {
        if(array_key_exists('from_ajax',$request->all())){
            return response()->json([
                'settings' => Setting::all(),
            ]);
        }
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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting,Request $request)
    {
        if(array_key_exists('from_ajax',$request->all())){
            return response()->json([
                'setting' => $setting,
            ]);
        }
        return $setting;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        $data = Validator::make($request->all(),[
            'ground_floor_rent' => 'required|numeric',
            'first_floor_rent'  => 'required|numeric',
            'second_floor_rent' => 'required|numeric',
        ]);

        //returning validation error
        if($data->fails()){
            return response()->json([
                'status' => 'errors',
                'errors' => $data->errors(),
            ]);
        }

        DB::beginTransaction();

        try{
            $data = $data->validate();

            $setting = Setting::where('key','Ground Floor Rent')->first();
            $setting->value = $data['ground_floor_rent'];
            $setting->user_id = getUser()->id;
            $setting->save();

            $setting = Setting::where('key','1st Floor Rent')->first();
            $setting->value = $data['first_floor_rent'];
            $setting->user_id = getUser()->id;
            $setting->save();

            $setting = Setting::where('key','2nd Floor Rent')->first();
            $setting->value = $data['second_floor_rent'];
            $setting->user_id = getUser()->id;
            $setting->save();

            DB::commit();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Data saved successfully',
            ]);
        }catch(Exception $e){
            return response()->json([
                'status'    => 'exception',
                'message'   => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
