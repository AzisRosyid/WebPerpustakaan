<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class ProfileController extends Controller
{
    public function profile(){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
            return view('profile', ['profile' => $profile, 'auth' => true]);
        } else {
            return redirect()->route('home');
        }
    }

    public function favorite(Request $request){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
        } else {
            return redirect()->route('home');
        }

        Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles/Favorite/'.$request->id.'/true');

        return back();
    }

    public function book(Request $request){
        $auth = false;
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $auth = true;
            $profile = $profile['user'];
        } else {
            return redirect()->route('home');
        }

        $books = []; $categories = []; $genres = []; $search = $request['s']; $sort = $request['sb']; $order = $request['ob']; $page = $request['p']; $total_page = 0; $url = $request->fullUrl(); $category = $request['c']; $genre = $request['g']; $pick = $request['pc'];

        if($page == '') { $page = 1; }
        if($pick == '') { $pick = 10; }

        $url = str_replace('p='.$page.'&', '', $url);
        $url = str_replace('p='.$page, '', $url);

        if(substr($url, strlen($url) - strlen('search'), strlen('search')) == 'search'){
            $url = $url.'?';
        }else if(substr($url, strlen($url) - strlen('search?'), strlen('search?')) != 'search?'){
            $url = $url.'&';
        }

        $getCategories = Http::get('http://192.168.21.1:8021/api/Categories', [ "Sort" => "Name"]);
        try { $categories = $getCategories['categories']; } catch(Throwable) { }
        $getGenres = Http::get('http://192.168.21.1:8021/api/Genres', [ "Sort" => "Name"]);
        try { $genres = $getGenres['genres']; } catch(Throwable){ }

        $data = [
            'Search' => $search,
            'Page' => $page,
            'Genres' => $genre,
            'Category' => $category,
            'Pick' => $pick,
            'Content' => 'Lite',
            'Sort' => $sort,
            'Order' => $order,
            'Start' => $request->start,
            'End' => $request->end,
            'User' => $profile['id'],
            'Favorite' => 'true',
        ];

        $getBooks = Http::asForm()->
        post('http://192.168.21.1:8021/api/Books/GetBooks', $data);
        try { $total_page = $getBooks['totalPages']; } catch(Throwable) { }
        try { $books = $getBooks['books']; } catch(Throwable) { }

        $context = ['s' => $search, 'p' => $page, 'pc' => $pick, 'tp' => $total_page, 'c' => $category, 'g' => $genre, 'sb' => $sort, 'ob' => $order, 'books' => $books, 'categories' => $categories, 'genres' => $genres, 'url' => $url, 'auth' => $auth, 'profile' => $profile, 'fav' => true];
        return view('books', $context);
    }

    public function show($id){
        $auth = false; $favorite = false;
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $getFavorite = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles/Favorite/'.$id.'/false');
            if($getFavorite->successful()){
                $favorite = $getFavorite['favorite'];
            }
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $auth = true;
            $profile = $profile['user'];
        } else {
            return redirect()->route('home');
        }

        $getBook = Http::get('http://192.168.21.1:8021/api/Books/'.$id);

        if($getBook->successful()){
            return view('book', ['book' => $getBook['book'], 'auth' => $auth, 'profile' => $profile, 'favorite' => $favorite, 'fav' => true]);
        } else {
            return $getBook['errors'];
        }
    }

    public function update(Request $request){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
        } else {
            return redirect()->route('home');
        }

        $password = $request->password;
        if($password == ''){
            $password = $request->passwordOld;
        }

        $data = [
            'email' => $request->email,
            'name' => $request->name,
            'password' => $password,
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
            )->put('http://192.168.21.1:8021/api/Profiles', $data);
        } else {
            $response = Http::withToken(session('token'))->asMultipart()->put('http://192.168.21.1:8021/api/Profiles', $data);
        }

        if($response->successful()){
            return back()->with('messages', $response['messages']);
        } else {
            return back()->with('profileErrors', $response['errors']);
        }
    }

    public function delete(){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
        } else {
            return redirect()->route('home');
        }

        $profile = Http::withToken(session('token'))->delete('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            session()->forget('token');
            return redirect()->route('home');
        } else {
            return back()->with('profileErrors', $profile['errors']);
        }
    }
}
