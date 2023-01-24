<?php

use App\Models\User;
use App\Models\Setting;
use App\Models\Settings;
use Illuminate\Support\Facades\Session;
function checkLogin()
{
    if(Session::has('user_id')){
        return true;
    }
    return false;
}

function getUser()
{
    if(checkLogin()){
        return User::where('id',Session::get('user_id'))->first();
    }
    return null;
}

function checkSuperAdmin()
{
    if(getUser()->role === "super_admin"){
        return true;
    }
    return false;
}

function checkAdmin()
{
    if(getUser()->role === "admin"){
        return true;
    }
    return false;
}

function checkManager()
{
    if(getUser()->role === "manager"){
        return true;
    }
    return false;
}

function checkSeller()
{
    if(getUser()->role === "seller"){
        return true;
    }
    return false;
}
function checkCustomer()
{
    if(getUser()->role === "customer"){
        return true;
    }
    return false;
}

function getSetting($key)
{
    if($key === null || $key === ''){
        return null;
    }
    return Setting::where('key',$key)->first();
}
?>
