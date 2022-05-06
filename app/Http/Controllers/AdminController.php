<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Method;
use Throwable;

class AdminController extends Controller
{
    // Admin Books
    public function books(Request $request){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

        $books = []; $categories = []; $genres = []; $search = $request['s']; $sort = $request['sb']; $order = $request['ob']; $page = $request['p']; $total_page = 1; $url = $request->fullUrl(); $category = $request['c']; $genre = $request['g']; $pick = $request['pc']; $user = $request['u']; $userId = $request['ui'];

        if($page == '') { $page = 1; }
        if($pick == '') { $pick = 10; }

        $url = str_replace('p='.$page.'&', '', $url);
        $url = str_replace('p='.$page, '', $url);

        if(substr($url, strlen($url) - strlen('books'), strlen('books')) == 'books'){
            $url = $url.'?';
        }else if(substr($url, strlen($url) - strlen('books?'), strlen('books?')) != 'books?'){
            $url = $url.'&';
        }

        $getCategories = Http::get(Method::$baseUrl.'Categories', [ "Sort" => "Name"]);
        try { $categories = $getCategories['categories']; } catch(Throwable) { }
        $getGenres = Http::get(Method::$baseUrl.'Genres', [ "Sort" => "Name"]);
        try { $genres = $getGenres['genres']; } catch(Throwable){ }

        $data = [
            'Search' => $search,
            'Page' => $page,
            'Genres' => $genre,
            'User' => $userId,
            'Category' => $category,
            'Pick' => $pick,
            'Sort' => $sort,
            'Content' => 'Full',
            'Order' => $order,
            'Start' => $request->start,
            'End' => $request->end,
        ];

        $getBooks = Http::asForm()->
        post(Method::$baseUrl.'Books/GetBooks', $data);
        try { $total_page = $getBooks['totalPages']; } catch(Throwable) { }
        try { $books = $getBooks['books']; } catch(Throwable) { }

        $context = ['s' => $search, 'p' => $page, 'pc' => $pick, 'tp' => $total_page, 'u' => $user, 'ui' => $userId, 'c' => $category, 'g' => $genre, 'sb' => $sort, 'ob' => $order, 'books' => $books, 'categories' => $categories, 'genres' => $genres, 'url' => $url, 'auth' => true, 'profile' => $profile, 'ab' => true, 'f' => true];

        return view('control.books', $context);
    }

    public function bookCreate(){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

        $categories = []; $genres = []; $url = back()->getTargetUrl();

        $getCategories = Http::get(Method::$baseUrl.'Categories', [ "Sort" => "Name"]);
        try { $categories = $getCategories['categories']; } catch(Throwable) { }
        $getGenres = Http::get(Method::$baseUrl.'Genres', [ "Sort" => "Name"]);
        try { $genres = $getGenres['genres']; } catch(Throwable){ }

        $context = [
            'c' => $categories, 'g' => $genres, 'cr' => true, 'auth' => true, 'profile' => $profile, 'ab' => true, 'url' => $url
        ];

        return view('control.book', $context);
    }

    public function bookStore(Request $request){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

        $data = [
            'title' => $request->title,
            'user' => $request->userId,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'page' => $request->page,
            'category' => $request->category,
            'genreIds' => json_encode($request->genre),
            'description' => $request->description,
        ];

        if($request->hasFile('image')) {
            $response = Http::withToken(session('token'))->attach(
                'image', file_get_contents($request->file('image')), $request->file('image')->getClientOriginalName()
            )->attach('download', file_get_contents($request->file('download')), $request->file('download')->getClientOriginalName())->post(Method::$baseUrl.'Books', $data);
        } else {
            $response = Http::withToken(session('token'))->attach('download', file_get_contents($request->file('download')), $request->file('download')->getClientOriginalName())->post(Method::$baseUrl.'Books', $data);
        }

        if($response->successful()){
            return redirect($request->url)->with('messages', $response['messages']);
        } else {
            $categories = []; $genres = [];
            $getCategories = Http::get(Method::$baseUrl.'Categories', [ "Sort" => "Name"]);
            try { $categories = $getCategories['categories']; } catch(Throwable) { }
            $getGenres = Http::get(Method::$baseUrl.'Genres', [ "Sort" => "Name"]);
            try { $genres = $getGenres['genres']; } catch(Throwable){ }
            return view('control.book', ['bookErrors' => $response['errors'], 'profile' => $profile, 'auth' => true, 'cr' => true, 'book' => $request, 'c' => $categories, 'g' => $genres, 'genre' => $request->genre, 'category' => $request->category, 'url' => $request->url, 'ab' => true]);
        }
    }

    public function bookEdit(Request $request){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

        $categories = []; $genres = []; $genre = []; $category = []; $url = back()->getTargetUrl();

        $getCategories = Http::get(Method::$baseUrl.'Categories', [ "Sort" => "Name"]);
        try { $categories = $getCategories['categories']; } catch(Throwable) { }
        $getGenres = Http::get(Method::$baseUrl.'Genres', [ "Sort" => "Name"]);
        try { $genres = $getGenres['genres']; } catch(Throwable){ }

        $getBook = Http::get(Method::$baseUrl.'Books/'.$request->id);

        foreach($getBook['book']['genres'] as $st){
            $genre[] = $st['id'];
        }

        try { $category[] = $getBook['book']['category']['id']; } catch (Throwable){}

        $context = [
            'c' => $categories, 'g' => $genres, 'ed' => true, 'auth' => true, 'profile' => $profile, 'book' => $getBook['book'], 'genre' => $genre, 'category' => $category, 'ab' => true, 'url' => $url
        ];

        return view('control.book', $context);
    }

    public function bookUpdate(Request $request){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }

        $profile = $profile['user'];

        $data = [
            'title' => $request->title,
            'user' => $request->userId,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'page' => $request->page,
            'category' => $request->category,
            'genreIds' => json_encode($request->genre),
            'description' => $request->description,
        ];

        if($request->hasFile('image') && $request->hasFile('download')) {
            $response = Http::withToken(session('token'))->attach(
                'image', file_get_contents($request->file('image')), $request->file('image')->getClientOriginalName()
            )->attach('download', file_get_contents($request->file('download')), $request->file('download')->getClientOriginalName())->put(Method::$baseUrl.'Books/'.$request->id, $data);
        } elseif($request->hasFile('download')) {
            $response = Http::withToken(session('token'))->attach('download', file_get_contents($request->file('download')), $request->file('download')->getClientOriginalName())->put(Method::$baseUrl.'Books/'.$request->id, $data);
        } elseif($request->hasFile('image')){
            $response = Http::withToken(session('token'))->attach(
                'image', file_get_contents($request->file('image')), $request->file('image')->getClientOriginalName()
            )->put(Method::$baseUrl.'Books/'.$request->id, $data);
        } else {
            $response = Http::withToken(session('token'))->asMultipart()->put(Method::$baseUrl.'Books/'.$request->id, $data);
        }

        if($response->successful()){
            return redirect($request->url)->with('messages', $response['messages']);
        } else {
            $categories = []; $genres = [];
            $getCategories = Http::get(Method::$baseUrl.'Categories', [ "Sort" => "Name"]);
            try { $categories = $getCategories['categories']; } catch(Throwable) { }
            $getGenres = Http::get(Method::$baseUrl.'Genres', [ "Sort" => "Name"]);
            try { $genres = $getGenres['genres']; } catch(Throwable){ }
            return view('control.book', ['bookErrors' => $response['errors'], 'profile' => $profile, 'auth' => true, 'ed' => true, 'book' => $request, 'c' => $categories, 'g' => $genres, 'genre' => $request->genre, 'category' => $request->category, 'url' => $request->url, 'ab' => true]);
        }
    }

    public function bookDelete(Request $request){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

        $response = Http::withToken(session('token'))->delete(Method::$baseUrl.'Books/'.$request->id);

        if($response->successful()){
            return back()->with('messages', $response['messages']);
        } else {
            return back()->with('bookErrors', $response['errors']);
        }
    }

    // Admin User
    public function users(Request $request){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

        $users = []; $search = $request['s']; $sort = $request['sb']; $order = $request['ob']; $page = $request['p']; $total_page = 1; $url = $request->fullUrl(); $pick = $request['pc']; $gender = $request['g']; $role = $request['r'];

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

        $getUsers = Http::withToken(session('token'))->get(Method::$baseUrl.'Users', $data);

        try { $total_page = $getUsers['totalPages']; } catch(Throwable) { }
        try { $users = $getUsers['users']; } catch(Throwable) { }

        if($request->modal ?? false){
            return response($getUsers);
        }

        $context = ['s' => $search, 'p' => $page, 'pc' => $pick, 'tp' => $total_page, 'sb' => $sort, 'g' => $gender, 'r' => $role, 'ob' => $order, 'users' => $users, 'url' => $url, 'auth' => true, 'profile' => $profile, 'au' => true, 'f' => true];
        return view('control.users', $context);
    }

    public function userShow(Request $request){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

        $response = Http::withToken(session('token'))->get(Method::$baseUrl.'Users/'.$request->id);

        if($response->successful()){
            return view('user', ['user' => $response['user'], 'auth' => true, 'profile' => $profile, 'au' => true]);
        } else {
            return $response['errors'];
        }
    }

    public function userCreate(){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

        $url = back()->getTargetUrl();

        $context = [
            'au' => true, 'auth' => true, 'profile' => $profile, 'cr' => true, 'url' => $url
        ];

        return view('control.user', $context);
    }

    public function userStore(Request $request){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

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
            )->post(Method::$baseUrl.'Users', $data);
        } else {
            $response = Http::withToken(session('token'))->asMultipart()->post(Method::$baseUrl.'Users', $data);
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
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

        $user = null; $url = back()->getTargetUrl();

        $response = Http::withToken(session('token'))->get(Method::$baseUrl.'Users/'.$request->id);

        try { $user = $response['user']; } catch(Throwable) { }

        $context = [
            'au' => true, 'auth' => true, 'profile' => $profile, 'ed' => true, 'user' => $user, 'url' => $url
        ];

        return view('control.user', $context);
    }

    public function userUpdate(Request $request){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

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
            )->put(Method::$baseUrl.'Users/'.$request->id, $data);
        } else {
            $response = Http::withToken(session('token'))->asMultipart()->put(Method::$baseUrl.'Users/'.$request->id, $data);
        }

        if($response->successful()){
            return redirect($request->url)->with('messages', $response['messages']);
        } else {
            $user = null;
            $getUser = Http::withToken(session('token'))->get(Method::$baseUrl.'Users/'.$request->id);
            try { $user = $getUser['user']; } catch(Throwable) { }
            $context = [
                'au' => true, 'auth' => true, 'profile' => $profile, 'ed' => true, 'url' => $request->url, 'user' => $user, 'userErrors' => $response['errors']
            ];
            return view('control.user', $context);
        }
    }

    public function userDelete(Request $request){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

        $response = Http::withToken(session('token'))->delete(Method::$baseUrl.'Users/'.$request->id);

        if($response->successful()){
            return back()->with('messages', $response['messages']);
        } else {
            return back()->with('userErrors', $response['errors']);
        }
    }

    // Admin Category
    public function categories(Request $request){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

        $categories = []; $search = $request['s']; $sort = $request['sb']; $order = $request['ob']; $page = $request['p']; $total_page = 1; $url = $request->fullUrl(); $pick = $request['pc'];

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

        $getCategories = Http::get(Method::$baseUrl.'Categories', $data);

        try { $total_page = $getCategories['totalPages']; } catch(Throwable) { }
        try { $categories = $getCategories['categories']; } catch(Throwable) { }

        $context = ['s' => $search, 'p' => $page, 'pc' => $pick, 'tp' => $total_page, 'sb' => $sort, 'ob' => $order, 'categories' => $categories, 'url' => $url, 'auth' => true, 'profile' => $profile, 'ac' => true, 'f' => true];
        return view('control.categories', $context);
    }

    public function categoryStore(Request $request){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

        $response = Http::withToken(session('token'))->post(Method::$baseUrl.'Categories', ['Name' => $request->name]);

        if($response->successful()){
            return back()->with('messages', $response['messages']);
        } else {
            return back()->with('categoryErrors', $response['errors']);
        }
    }

    public function categoryUpdate(Request $request){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

        $response = Http::withToken(session('token'))->put(Method::$baseUrl.'Categories/'.$request->id, ['Name' => $request->name]);

        if($response->successful()){
            return back()->with('messages', $response['messages']);
        } else {
            return back()->with('categoryErrors', $response['errors']);
        }
    }

    public function categoryDelete(Request $request){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

        $response = Http::withToken(session('token'))->delete(Method::$baseUrl.'Categories/'.$request->id);

        if($response->successful()){
            return back()->with('messages', $response['messages']);
        } else {
            return back()->with('categoryErrors', $response['errors']);
        }
    }

    // Admin Genre
    public function genres(Request $request){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

        $genres = []; $search = $request['s']; $sort = $request['sb']; $order = $request['ob']; $page = $request['p']; $total_page = 1; $url = $request->fullUrl(); $pick = $request['pc'];

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

        $getGenres = Http::get(Method::$baseUrl.'Genres', $data);

        try { $total_page = $getGenres['totalPages']; } catch(Throwable) { }
        try { $genres = $getGenres['genres']; } catch(Throwable) { }

        $context = ['s' => $search, 'p' => $page, 'pc' => $pick, 'tp' => $total_page, 'sb' => $sort, 'ob' => $order, 'genres' => $genres, 'url' => $url, 'auth' => true, 'profile' => $profile, 'ag' => true, 'f' => true];
        return view('control.genres', $context);
    }

    public function genreStore(Request $request){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

        $response = Http::withToken(session('token'))->post(Method::$baseUrl.'Genres', ['Name' => $request->name]);

        if($response->successful()){
            return back()->with('messages', $response['messages']);
        } else {
            return back()->with('genreErrors', $response['errors']);
        }
    }

    public function genreUpdate(Request $request){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

        $response = Http::withToken(session('token'))->put(Method::$baseUrl.'Genres/'.$request->id, ['Name' => $request->name]);

        if($response->successful()){
            return back()->with('messages', $response['messages']);
        } else {
            return back()->with('genreErrors', $response['errors']);
        }
    }

    public function genreDelete(Request $request){
        $profile = Http::withToken(session('token'))->get(Method::$baseUrl.'Profiles');
        if (!Method::auth($profile, true)){
            return redirect()->route('home');
        }
        $profile = $profile['user'];

        $response = Http::withToken(session('token'))->delete(Method::$baseUrl.'Genres/'.$request->id);

        if($response->successful()){
            return back()->with('messages', $response['messages']);
        } else {
            return back()->with('genreErrors', $response['errors']);
        }
    }
}
