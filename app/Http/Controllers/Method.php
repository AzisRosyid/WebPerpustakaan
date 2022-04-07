<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Method extends Controller
{
    public static $baseUrl = "http://192.168.21.1:8021/api/";

    public static function auth($profile, $admin = false){
        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get(Method::$baseUrl.'Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            if($admin){
                if ($profile['user']['role'] == "Admin") {
                    return true;
                }
            } else {
                return true;
            }
        }
        return false;
    }
}
