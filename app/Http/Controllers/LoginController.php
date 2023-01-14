<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $data = Validator::make($request->all(),[
            'email'     => 'required|email',
            'password'  => 'required|min:8|max:20'
        ]);

        if($data->fails()){
            return response()->json([
                'status' => 'errors',
                'errors' => $data->errors(),
            ]);
        }

        try{
            $data = $data->validate();

            $user = User::where('email',$data['email'])->first();

            if($user === null){
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Invalid email id',
                ]);
            }

            else if(!Hash::check($data['password'],$user->password)){
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Incorrect password',
                ]);
            }

            else if(strcmp('active',$user->status) != 0){
                if(strcmp('pending',$user->status)==0){
                    return response()->json([
                        'status'    => 'error',
                        'message'   => 'Please verify your email account',
                    ]);
                }
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'This account is '.$user->status,
                ]);
            }

            Session::put('user_id',$user->id);

            return response()->json([
                'status'    => 'success',
                'message'   => 'Login successful',
                'url'       => route('index'),
            ]);
        }catch(Exception $e){
            return response()->json([
                'status'    => 'exception',
                'message'   => $e->getMessage(),
            ]);
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect(route('index'));
    }
}
