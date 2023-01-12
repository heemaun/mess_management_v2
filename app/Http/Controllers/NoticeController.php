<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class NoticeController extends Controller
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
                $status = ['pending','active','inactive','deleted'];
            }
            else{
                $status = [$request->status];
            }

            $notices = Notice::whereIn('status',$status)
                                ->whereBetween('created_at',[$request->from,$request->to])
                                ->get();
            return response(view('notice.search',compact('notices')));
        }
        $notices = Notice::where('status','active')->get();
        return view('notice.index',compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response(view('notice.create'));
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
            'heading'   => 'required|min:10|max:30|string',
            'body'      => 'required|min:50|max:500|string',
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

            $notice = Notice::create([
                'user_id'   => getUser()->id,
                'heading'   => $data['heading'],
                'body'      => $data['body'],
                'status'    => $data['status'],
            ]);

            DB::commit();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Notice added successfully',
                'url'       => route('notices.show',$notice->id),
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
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice,Request $request)
    {
        if(array_key_exists('from_home',$request->all())){
            return view('defult.home-notice',compact('notice'));
        }
        return response(view('notice.show',compact('notice')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {
        return response(view('notice.edit',compact('notice')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notice $notice)
    {
        $data = Validator::make($request->all(),[
            'heading'   => 'required|min:10|max:30|string',
            'body'      => 'required|min:50|max:500|string',
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

            $notice->heading = $data['heading'];
            $notice->body = $data['body'];
            $notice->status = $data['status'];
            $notice->user_id = getUser()->id;

            $notice->save();

            DB::commit();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Notice updated successfully',
                'url'       => route('notices.show',$notice->id),
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
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice,Request $request)
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
                if($request->permanent_delete === 1){
                    $notice->delete();
                }
                else{
                    $notice->status = 'deleted';

                    $notice->save();
                }

                DB::commit();

                return response()->json([
                    'status'    => 'success',
                    'message'   => 'Notice deleted successfully',
                    'url'       => route('notices.index'),
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
