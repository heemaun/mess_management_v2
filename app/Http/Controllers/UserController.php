<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NewUserNotification;
use App\Notifications\SmsNotification;

class UserController extends Controller
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
                                ->paginate($request->limit);
            }
            else if(Str::contains($request->search, '@')){
                $users = User::where('email',$request->search)
                                ->whereIn('status',$status)
                                ->paginate($request->limit);
            }
            else{
                $users = User::where('name','LIKE','%'.$request->search.'%')
                                ->whereIn('status',$status)
                                ->paginate($request->limit);
            }
            return response(view('user.search',compact('users')));
        }
        $users = User::where('status','active')->paginate(10);
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

            $password = Str::random(20);

            $user = User::create([
                'name'          => $data['name'],
                'email'         => $data['email'],
                'phone'         => $data['phone'],
                'password'      => Hash::make($password),
                'status'        => $data['status'],
            ]);

            if(array_key_exists('picture',$data)){
                $imageName = time().'.'.$data['picture']->extension();

                $data['picture']->move(public_path('images'),$imageName);

                $user->picture = $imageName;
                $user->save();
            }

            $user->notify(new NewUserNotification($user,$password));

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
            'name'                          => 'required_if:password,false|string|min:3|max:30',
            'email'                         => 'required_if:password,false|email|unique:users,email,'.$user->id,
            'phone'                         => 'required_if:password,false|numeric|unique:users,phone,'.$user->id,
            'status'                        => 'required_if:password,false',
            'current_password'              => 'required_if:password,true|min:8|max:20',
            'new_password'                  => 'required_if:password,true|min:8|max:20|confirmed',
            'new_password_confirmation'     => 'required_if:password,true|min:8|max:20',
            'password'                      => 'required',
        ],$messages = [
            'current_password.required_if'          => 'Current password field is required',
            'new_password.required_if'              => 'New password field is required',
            'new_password_confirmation.required_if' => 'Confirm new password field is required',
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

            if(strcmp($data['password'],'true')==0){
                if(Hash::check($data['current_password'],$user->password)){
                    $user->password = Hash::make($data['new_password']);
                }
                else{
                    return response()->json([
                        'status'    => 'error',
                        'message'   => 'Incorrect current password',
                    ]);
                }
            }
            else{
                $user->name   = $data['name'];
                $user->email  = $data['email'];
                $user->phone  = $data['phone'];
                $user->status = $data['status'];
            }

            $user->save();

            DB::commit();

            return response()->json([
                'status'    => 'success',
                'message'   => (strcmp($data['password'],'true')==0) ? 'Password changed successfully' : 'User updated successfully',
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
