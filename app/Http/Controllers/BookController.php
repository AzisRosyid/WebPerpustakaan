<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $auth = false;
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $auth = true;
            $profile = $profile['user'];
        }

        $books = []; $categories = []; $genres = []; $search = $request['s']; $sort = $request['sb']; $order = $request['ob']; $page = $request['p']; $total_page = 0; $url = $request->fullUrl(); $category = $request['c']; $genre = $request['g']; $pick = $request['pc'];

        if($page == '') { $page = 1; }
        if($pick == '') { $pick = 10; }

        $url = str_replace('p='.$page.'&', '', $url);
        $url = str_replace('p='.$page, '', $url);

        if(substr($url, strlen($url) - strlen('books'), strlen('books')) == 'books'){
            $url = $url.'?';
        }else if(substr($url, strlen($url) - strlen('books?'), strlen('books?')) != 'books?'){
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
        ];

        $getBooks = Http::asForm()->
        post('http://192.168.21.1:8021/api/Books/GetBooks', $data);
        try { $total_page = $getBooks['totalPages']; } catch(Throwable) { }
        try { $books = $getBooks['books']; } catch(Throwable) { }

        $context = ['s' => $search, 'p' => $page, 'pc' => $pick, 'tp' => $total_page, 'c' => $category, 'g' => $genre, 'sb' => $sort, 'ob' => $order, 'books' => $books, 'categories' => $categories, 'genres' => $genres, 'url' => $url, 'auth' => $auth, 'profile' => $profile];
        return view('books', $context);
    }

    public function my(Request $request){
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
        } else {
            return redirect()->route('home');
        }

        $books = []; $categories = []; $genres = []; $search = $request['s']; $sort = $request['sb']; $order = $request['ob']; $page = $request['p']; $total_page = 0; $url = $request->fullUrl(); $category = $request['c']; $genre = $request['g']; $pick = $request['pc'];

        if($page == '') { $page = 1; }
        if($pick == '') { $pick = 10; }

        $url = str_replace('p='.$page.'&', '', $url);
        $url = str_replace('p='.$page, '', $url);

        if(substr($url, strlen($url) - strlen('mybooks'), strlen('mybooks')) == 'mybooks'){
            $url = $url.'?';
        }else if(substr($url, strlen($url) - strlen('mybooks?'), strlen('mybooks?')) != 'mybooks?'){
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
            'Sort' => $sort,
            'Content' => 'Mid',
            'Order' => $order,
            'Start' => $request->start,
            'End' => $request->end,
            'User' => $profile['id'],
        ];

        $getBooks = Http::asForm()->
        post('http://192.168.21.1:8021/api/Books/GetBooks', $data);
        try { $total_page = $getBooks['totalPages']; } catch(Throwable) { }
        try { $books = $getBooks['books']; } catch(Throwable) { }

        $context = ['s' => $search, 'p' => $page, 'pc' => $pick, 'tp' => $total_page, 'c' => $category, 'g' => $genre, 'sb' => $sort, 'ob' => $order, 'books' => $books, 'categories' => $categories, 'genres' => $genres, 'url' => $url, 'auth' => true, 'profile' => $profile, 'my' => true];

        return view('control.books', $context);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
        } else {
            return redirect()->route('home');
        }

        $categories = []; $genres = []; $url = back()->getTargetUrl();

        $getCategories = Http::get('http://192.168.21.1:8021/api/Categories', [ "Sort" => "Name"]);
        try { $categories = $getCategories['categories']; } catch(Throwable) { }
        $getGenres = Http::get('http://192.168.21.1:8021/api/Genres', [ "Sort" => "Name"]);
        try { $genres = $getGenres['genres']; } catch(Throwable){ }

        $context = [
            'c' => $categories, 'g' => $genres, 'cr' => true, 'auth' => true, 'profile' => $profile, 'my' => true, 'url' => $url
        ];

        return view('control.book', $context);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
        } else {
            return redirect()->route('home');
        }

        $data = [
            'title' => $request->title,
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
            )->attach('download', file_get_contents($request->file('download')), $request->file('download')->getClientOriginalName())->post('http://192.168.21.1:8021/api/Books', $data);
        } else {
            $response = Http::withToken(session('token'))->attach('download', file_get_contents($request->file('download')), $request->file('download')->getClientOriginalName())->post('http://192.168.21.1:8021/api/Books', $data);
        }

        if($response->successful()){
            return redirect($request->url)->with('messages', $response['messages']);
        } else {
            $categories = []; $genres = [];
            $getCategories = Http::get('http://192.168.21.1:8021/api/Categories', [ "Sort" => "Name"]);
            try { $categories = $getCategories['categories']; } catch(Throwable) { }
            $getGenres = Http::get('http://192.168.21.1:8021/api/Genres', [ "Sort" => "Name"]);
            try { $genres = $getGenres['genres']; } catch(Throwable){ }
            return view('control.book', ['bookErrors' => $response['errors'], 'profile' => $profile, 'auth' => true, 'cr' => true, 'book' => $request, 'c' => $categories, 'g' => $genres, 'genre' => $request->genre, 'url' => $request->url]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        }

        $getBook = Http::get('http://192.168.21.1:8021/api/Books/'.$id);

        if($getBook->successful()){
            return view('book', ['book' => $getBook['book'], 'auth' => $auth, 'profile' => $profile, 'favorite' => $favorite]);
        } else {
            return $getBook['errors'];
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
        } else {
            return redirect()->route('home');
        }

        $categories = []; $genres = []; $genre = []; $category = []; $url = back()->getTargetUrl();

        $getCategories = Http::get('http://192.168.21.1:8021/api/Categories', [ "Sort" => "Name"]);
        try { $categories = $getCategories['categories']; } catch(Throwable) { }
        $getGenres = Http::get('http://192.168.21.1:8021/api/Genres', [ "Sort" => "Name"]);
        try { $genres = $getGenres['genres']; } catch(Throwable){ }

        $getBook = Http::get('http://192.168.21.1:8021/api/Books/'.$id);

        foreach($getBook['book']['genres'] as $st){
            $genre[] = $st['id'];
        }

        try { $category[] = $getBook['book']['category']['id']; } catch (Throwable){}

        $context = [
            'c' => $categories, 'g' => $genres, 'ed' => true, 'auth' => true, 'profile' => $profile, 'book' => $getBook['book'], 'genre' => $genre, 'category' => $category, 'my' => true, 'url' => $url
        ];

        return view('control.book', $context);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
        } else {
            return redirect()->route('home');
        }

        $data = [
            'title' => $request->title,
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
            )->attach('download', file_get_contents($request->file('download')), $request->file('download')->getClientOriginalName())->put('http://192.168.21.1:8021/api/Books/'.$id, $data);
        } elseif($request->hasFile('download')) {
            $response = Http::withToken(session('token'))->attach('download', file_get_contents($request->file('download')), $request->file('download')->getClientOriginalName())->put('http://192.168.21.1:8021/api/Books/'.$id, $data);
        } elseif($request->hasFile('image')){
            $response = Http::withToken(session('token'))->attach(
                'image', file_get_contents($request->file('image')), $request->file('image')->getClientOriginalName()
            )->put('http://192.168.21.1:8021/api/Books/'.$id, $data);
        } else {
            $response = Http::withToken(session('token'))->asMultipart()->put('http://192.168.21.1:8021/api/Books/'.$id, $data);
        }


        if($response->successful()){
            return redirect($request->url)->with('messages', $response['messages']);
        } else {
            $categories = []; $genres = [];
            $getCategories = Http::get('http://192.168.21.1:8021/api/Categories', [ "Sort" => "Name"]);
            try { $categories = $getCategories['categories']; } catch(Throwable) { }
            $getGenres = Http::get('http://192.168.21.1:8021/api/Genres', [ "Sort" => "Name"]);
            try { $genres = $getGenres['genres']; } catch(Throwable){ }
            return view('control.book', ['bookErrors' => 'helo', 'profile' => $profile, 'auth' => true, 'ed' => true, 'book' => $request, 'c' => $categories, 'g' => $genres, 'genre' => $request->genre, 'url' => $request->url]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $profile = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Profiles');

        if ($profile->successful()){
            $refreshToken = Http::withToken(session('token'))->get('http://192.168.21.1:8021/api/Auth/RefreshToken');
            session(['token' => $refreshToken['token']]);
            $profile = $profile['user'];
        } else {
            return redirect()->route('home');
        }

        $response = Http::withToken(session('token'))->delete('http://192.168.21.1:8021/api/Books/'.$request->id);

        if($response->successful()){
            return back()->with('messages', $response['messages']);
        } else {
            return back()->with('bookErrors', $response['errors']);
        }
    }

    public function download(Request $request){
        $response = Http::get('http://192.168.21.1:8021/api/Books/DownloadBook/'.$request->download);

        $url = 'http://192.168.21.1:8021/api/Books/DownloadBook/'.$request->download;

        if($response->successful()){
            return redirect($url);
        }else{
            return $response['errors'];
        }
    }
}
