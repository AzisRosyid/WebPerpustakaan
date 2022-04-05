<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class AdminController extends Controller
{
    // Admin User
    public function users(Request $request){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
            if ($profile['role'] != "Admin") {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }

        $users = []; $search = $request['s']; $sort = $request['sb']; $order = $request['ob']; $page = $request['p']; $total_page = 0; $url = $request->fullUrl(); $pick = $request['pc']; $gender = $request['g']; $role = $request['r'];

        if($page == '') { $page = 1; }
        if($pick == '') { $pick = 10; }

        $url = str_replace('p='.$page.'&', '', $url);
        $url = str_replace('p='.$page, '', $url);

        if(substr($url, strlen($url) - strlen('users'), strlen('users')) == 'users'){
            $url = $url.'?';
        }else if(substr($url, strlen($url) - strlen('users?'), strlen('users?')) != 'users?'){
            $url = $url.'&';
        }

        $data = [
            'Search' => $search,
            'Page' => $page,
            'Pick' => $pick,
            'Sort' => $sort,
            'Order' => $order,
            'Role' => $role,
            'Gender' => $gender
        ];

        $getUsers = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Users', $data);

        try { $total_page = $getUsers['totalPages']; } catch(Throwable) { }
        try { $users = $getUsers['users']; } catch(Throwable) { }

        $context = ['s' => $search, 'p' => $page, 'pc' => $pick, 'tp' => $total_page, 'sb' => $sort, 'g' => $gender, 'r' => $role, 'ob' => $order, 'users' => $users, 'url' => $url, 'auth' => true, 'profile' => $profile, 'au' => true];
        return view('control.users', $context);
    }

    public function userShow(Request $request){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
            if ($profile['role'] != "Admin") {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }

        $response = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Users/'.$request->id);

        if($response->successful()){
            return view('user', ['user' => $response['user'], 'auth' => true, 'profile' => $profile, 'au' => true]);
        } else {
            return $response['errors'];
        }
    }

    public function userCreate(){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
            if ($profile['role'] != "Admin") {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }

        $url = back()->getTargetUrl();

        $context = [
            'au' => true, 'auth' => true, 'profile' => $profile, 'cr' => true, 'url' => $url
        ];

        return view('control.user', $context);
    }

    public function userStore(Request $request){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
            if ($profile['role'] != "Admin") {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }

        $data = [
            'email' => $request->email,
            'name' => $request->name,
            'password' => $request->password,
            'role' => $request->role,
            'gender' => $request->gender,
            'dateOfBirth' => $request->dateOfBirth,
            'phoneNumber' => $request->phoneNumber,
            'address' => $request->address
        ];

        if($request->hasFile('image')) {
            $file_name = $request->file('image')->getClientOriginalName();
            $response = Http::withToken(session('token'))->attach(
                'image', file_get_contents($request->file('image')), $file_name
            )->post('http://192.168.21.1:8021/api/Users', $data);
        } else {
            $response = Http::withToken(session('token'))->asMultipart()->post('http://192.168.21.1:8021/api/Users', $data);
        }

        if($response->successful()){
            return redirect($request->url)->with('messages', $response['messages']);
        } else {
            $context = [
                'au' => true, 'auth' => true, 'profile' => $profile, 'cr' => true, 'url' => $request->url, 'user' => $request, 'userErrors' => $response['errors']
            ];
            return view('control.user', $context);
        }
    }

    public function userEdit(Request $request){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
            if ($profile['role'] != "Admin") {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }

        $user = null; $url = back()->getTargetUrl();

        $response = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Users/'.$request->id);

        try { $user = $response['user']; } catch(Throwable) { }

        $context = [
            'au' => true, 'auth' => true, 'profile' => $profile, 'ed' => true, 'user' => $user, 'url' => $url
        ];

        return view('control.user', $context);
    }

    public function userUpdate(Request $request){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
            if ($profile['role'] != "Admin") {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }

        $data = [
            'email' => $request->email,
            'name' => $request->name,
            'password' => $request->password,
            'role' => $request->role,
            'gender' => $request->gender,
            'dateOfBirth' => $request->dateOfBirth,
            'phoneNumber' => $request->phoneNumber,
            'address' => $request->address
        ];

        if($request->hasFile('image')) {
            $file_name = $request->file('image')->getClientOriginalName();
            $response = Http::withToken(session('token'))->attach(
                'image', file_get_contents($request->file('image')), $file_name
            )->put('http://192.168.21.1:8021/api/Users/'.$request->id, $data);
        } else {
            $response = Http::withToken(session('token'))->asMultipart()->put('http://192.168.21.1:8021/api/Users/'.$request->id, $data);
        }

        if($response->successful()){
            return redirect($request->url)->with('messages', $response['messages']);
        } else {
            $user = null;
            $getUser = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Users/'.$request->id);
            try { $user = $getUser['user']; } catch(Throwable) { }
            $context = [
                'au' => true, 'auth' => true, 'profile' => $profile, 'ed' => true, 'url' => $request->url, 'user' => $user, 'userErrors' => $response['errors']
            ];
            return view('control.user', $context);
        }
    }

    public function userDelete(Request $request){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
            if ($profile['role'] != "Admin") {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }

        $response = Http::withToken(session('token'))->delete('http://192.168.21.1:8021/api/Users/'.$request->id);

        if($response->successful()){
            return back()->with('messages', $response['messages']);
        } else {
            return back()->with('userErrors', $response['errors']);
        }
    }

    // Admin Category
    public function categories(Request $request){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
            if ($profile['role'] != "Admin") {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }

        $categories = []; $search = $request['s']; $sort = $request['sb']; $order = $request['ob']; $page = $request['p']; $total_page = 0; $url = $request->fullUrl(); $pick = $request['pc'];

        if($page == '') { $page = 1; }
        if($pick == '') { $pick = 10; }

        $url = str_replace('p='.$page.'&', '', $url);
        $url = str_replace('p='.$page, '', $url);

        if(substr($url, strlen($url) - strlen('categories'), strlen('categories')) == 'categories'){
            $url = $url.'?';
        }else if(substr($url, strlen($url) - strlen('categories?'), strlen('categories?')) != 'categories?'){
            $url = $url.'&';
        }

        $data = [
            'Search' => $search,
            'Page' => $page,
            'Pick' => $pick,
            'Sort' => $sort,
            'Order' => $order,
        ];

        $getCategories = Http::get('http://192.168.21.1:8021/api/Categories', $data);

        try { $total_page = $getCategories['totalPages']; } catch(Throwable) { }
        try { $categories = $getCategories['categories']; } catch(Throwable) { }

        $context = ['s' => $search, 'p' => $page, 'pc' => $pick, 'tp' => $total_page, 'sb' => $sort, 'ob' => $order, 'categories' => $categories, 'url' => $url, 'auth' => true, 'profile' => $profile, 'ac' => true];
        return view('control.categories', $context);
    }

    public function categoryStore(Request $request){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
            if ($profile['role'] != "Admin") {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }

        $response = Http::withToken(session('token'))->post('http://192.168.21.1:8021/api/Categories', ['Name' => $request->name]);

        if($response->successful()){
            return back()->with('messages', $response['messages']);
        } else {
            return back()->with('categoryErrors', $response['errors']);
        }
    }

    public function categoryUpdate(Request $request){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
            if ($profile['role'] != "Admin") {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }

        $response = Http::withToken(session('token'))->put('http://192.168.21.1:8021/api/Categories/'.$request->id, ['Name' => $request->name]);

        if($response->successful()){
            return back()->with('messages', $response['messages']);
        } else {
            return back()->with('categoryErrors', $response['errors']);
        }
    }

    public function categoryDelete(Request $request){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
            if ($profile['role'] != "Admin") {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }

        $response = Http::withToken(session('token'))->delete('http://192.168.21.1:8021/api/Categories/'.$request->id);

        if($response->successful()){
            return back()->with('messages', $response['messages']);
        } else {
            return back()->with('categoryErrors', $response['errors']);
        }
    }

    // Admin Genre
    public function genres(Request $request){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
            if ($profile['role'] != "Admin") {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }

        $genres = []; $search = $request['s']; $sort = $request['sb']; $order = $request['ob']; $page = $request['p']; $total_page = 0; $url = $request->fullUrl(); $pick = $request['pc'];

        if($page == '') { $page = 1; }
        if($pick == '') { $pick = 10; }

        $url = str_replace('p='.$page.'&', '', $url);
        $url = str_replace('p='.$page, '', $url);

        if(substr($url, strlen($url) - strlen('genres'), strlen('genres')) == 'genres'){
            $url = $url.'?';
        }else if(substr($url, strlen($url) - strlen('genres?'), strlen('genres?')) != 'genres?'){
            $url = $url.'&';
        }

        $data = [
            'Search' => $search,
            'Page' => $page,
            'Pick' => $pick,
            'Sort' => $sort,
            'Order' => $order,
        ];

        $getGenres = Http::get('http://192.168.21.1:8021/api/Genres', $data);

        try { $total_page = $getGenres['totalPages']; } catch(Throwable) { }
        try { $genres = $getGenres['genres']; } catch(Throwable) { }

        $context = ['s' => $search, 'p' => $page, 'pc' => $pick, 'tp' => $total_page, 'sb' => $sort, 'ob' => $order, 'genres' => $genres, 'url' => $url, 'auth' => true, 'profile' => $profile, 'ag' => true];
        return view('control.genres', $context);
    }

    public function genreStore(Request $request){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
            if ($profile['role'] != "Admin") {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }

        $response = Http::withToken(session('token'))->post('http://192.168.21.1:8021/api/Genres', ['Name' => $request->name]);

        if($response->successful()){
            return back()->with('messages', $response['messages']);
        } else {
            return back()->with('genreErrors', $response['errors']);
        }
    }

    public function genreUpdate(Request $request){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
            if ($profile['role'] != "Admin") {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }

        $response = Http::withToken(session('token'))->put('http://192.168.21.1:8021/api/Genres/'.$request->id, ['Name' => $request->name]);

        if($response->successful()){
            return back()->with('messages', $response['messages']);
        } else {
            return back()->with('genreErrors', $response['errors']);
        }
    }

    public function genreDelete(Request $request){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
            if ($profile['role'] != "Admin") {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }

        $response = Http::withToken(session('token'))->delete('http://192.168.21.1:8021/api/Genres/'.$request->id);

        if($response->successful()){
            return back()->with('messages', $response['messages']);
        } else {
            return back()->with('genreErrors', $response['errors']);
        }
    }
}
