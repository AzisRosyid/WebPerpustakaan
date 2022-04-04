<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class AdminController extends Controller
{
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
        return view('categories-control', $context);
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
        return view('genres-control', $context);
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
