<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
                $status = ['pending','active','banned','restricted'];
            }
            else{
                $status = [$request->status];
            }
            if(is_numeric($request->search)){
                $users = User::where('phone',$request->search)
                                ->whereIn('status',$status)
                                ->get();
            }
            else if(Str::contains($request->search, '@')){
                $users = User::where('email',$request->search)
                                ->whereIn('status',$status)
                                ->get();
            }
            else{
                $users = User::where('name','LIKE','%'.$request->search.'%')
                                ->whereIn('status',$status)
                                ->get();
            }
            return response(view('user.search',compact('users')));
        }
        $users = User::where('status','active')->get();
        return response(view('user.index',compact('users')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response(view('user.create'));
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
            'name'      => 'required|min:3|max:30',
            'email'     => 'required|email',
            'phone'     => 'required|digits:11',
            'status'    => 'required',
            'image'     => 'nullable',
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

            $user = User::create([
                'name'          => $data['name'],
                'email'         => $data['email'],
                'phone'         => $data['phone'],
                'password'      => Hash::make('11111111'),
                'status'        => $data['status'],
            ]);

            if(array_key_exists('picture',$data)){
                $imageName = time().'.'.$data['picture']->extension();

                $data['picture']->move(public_path('images'),$imageName);

                $user->picture = $imageName;
                $user->save();
            }

            DB::commit();

            return response()->json([
                'status'    => 'success',
                'message'   => 'User added successfully',
                'url'       => route('users.show',$user->id),
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response(view('user.show',compact('user')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return response(view('user.edit',compact('user')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = Validator::make($request->all(),[
            'name'   => 'required|string|min:3|max:30',
            'email'  => 'required|email|unique:users,email,'.$user->id,
            'phone'  => 'required|numeric|unique:users,phone,'.$user->id,
            'status' => 'required',
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

            $user->name   = $data['name'];
            $user->email  = $data['email'];
            $user->phone  = $data['phone'];
            $user->status = $data['status'];

            $user->save();

            DB::commit();

            return response()->json([
                'status'    => 'success',
                'message'   => 'User updated successfully',
                'url'       => route('users.show',$user->id),
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user,Request $request)
    {
        $data = Validator::make($request->all(),[
            'password'          => 'required|min:8|max:20',
            'permanent_delete'  => 'sometimes',
        ]);

        if($data->fails()){
            return response()->json([
                'status' => 'errors',
                'errors' => $data->errors(),
            ]);
        }

        if($user->id === 1){
            return response()->json([
                'status' => 'error',
                'message' => 'This user can not be deleted',
            ]);
        }

        DB::beginTransaction();

        try{
            $data = $data->validate();

            if(Hash::check($data['password'],getUser()->password)){
                if(strcmp('true',$data['permanent_delete'])==0){
                    $user->delete();
                }
                else{
                    $user->status = 'deleted';

                    $user->save();
                }

                DB::commit();

                return response()->json([
                    'status'    => 'success',
                    'message'   => 'User deleted successfully',
                    'url'       => route('users.index'),
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
