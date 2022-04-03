<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    public function login(Request $request){

        $response = Http::post('http://192.168.21.1:8021/api/Auth/Login', [
            'email' => $request->email,
            'password' => $request->password
        ]);

        if($response->successful()){
            session(['token' => $response['token']]);
            if(URL::previous() == route('register')){
                return redirect()->route('home');
            }
            return back();
        } else {
            return back()->with('loginErrors', $response['errors']);
        }

    }

    public function register(Request $request){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            return redirect()->route('home');
        }

        $data = [
            'email' => $request->email,
            'name' => $request->name,
            'password' => $request->password,
            'role' => 'User',
            'gender' => $request->gender,
            'dateOfBirth' => $request->dateOfBirth,
            'phoneNumber' => $request->phoneNumber,
            'address' => $request->address
        ];

        if($request->hasFile('image')) {
            $files_name = [];
            foreach ($request->file('image') as $st){
                if(file_exists($st)){
                    $files_name[] = $st->getClientOriginalName();
                }
            }
            $response = Http::attach(
                'image', file_get_contents($request->file('image')), $request->file('image')->getClientOriginalName()
            )->post('http://192.168.21.1:8021/api/Auth/Register', $data);
        } else {
            $response = Http::asMultipart()->post('http://192.168.21.1:8021/api/Auth/Register', $data);
        }

        if($response->successful()){
            return redirect()->route('home')->with('messages', $response['messages']);
        } else {
            return view('register', ['request' => $request])->with('registerErrors', $response['errors']);
        }
    }

    public function logout(){
        session()->forget('token');
        return route('home');
    }
}
