<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if($auth??false)
    @if($profile['role'] === 'Admin')
    <title>Perpustakaan Admin</title>
    @else
    <title>Perpustakaan User</title>
    @endif
    @else
    <title>Perpustakaan</title>
    @endif


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
        <div class="container-fluid">
            <div>
                <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#controlPanel" aria-controls="Control Panel">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @if($auth??false)
                @if($profile['role'] === 'Admin')
                <a class="navbar-brand fs-4 ps-3 align-middle" href="{{ route('home') }}">Perpustakaan Admin</a>
                @else
                <a class="navbar-brand fs-4 ps-3 align-middle" href="{{ route('home') }}">Perpustakaan User</a>
                @endif
                @else
                <a class="navbar-brand fs-4 ps-3 align-middle" href="{{ route('home') }}">Perpustakaan</a>
                @endif
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                    <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                  </svg>
              </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <form class="d-flex navbar-form navbar-center me-auto" type="get" @if($fav??false) action="{{ route('favorite') }}" @elseif($my??false) accept="{{ route('myBooks') }}" @elseif($ag??false) accept="{{ route('adminGenres') }}" @elseif($ac??false) accept="{{ route('adminCategories') }}" @elseif($au??false) accept="{{ route('adminUsers') }}" @elseif($ab??false) accept="{{ route('adminBooks') }}" @else action="{{ route('books') }}" @endif>
            <input class="form-control input-search me-2" type="search" @if($fav??false) placeholder="Search Favorite..." @elseif($my??false) placeholder="Search My Books..." @elseif($ag??false) placeholder="Search Admin Genres..." @elseif($ac??false) placeholder="Search Admin Categories..." @elseif($au??false) placeholder="Search Admin Users..." @elseif($ab??false) placeholder="Search Admin Books..." @else placeholder="Search Books..." @endif aria-label="Search" name="s" value="{{ $s ?? '' }}" autofocus>
            <button class="btn btn-outline-light" type="submit">Search</button>
          </form>
          @if($my??false)
            <div class="d-grid gap-2 nav-create">
                <a class="btn btn-success text-white" href="{{ route('createBook') }}" type="submit" value="Submit">Create</a>
            </div>
          @elseif($ag??false)
            <div class="d-grid gap-2 nav-create">
                <a class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#createGenreModal" type="submit" value="Submit">Create</a>
            </div>
          @elseif($ac??false)
            <div class="d-grid gap-2 nav-create">
                <a class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#createCategoryModal" type="submit" value="Submit">Create</a>
            </div>
          @elseif($au??false)
            <div class="d-grid gap-2 nav-create">
                <a class="btn btn-success text-white" href="{{ route('adminCreateUser') }}" type="submit" value="Submit">Create</a>
            </div>
          @elseif($ab??false)
            <div class="d-grid gap-2 nav-create">
                <a class="btn btn-success text-white" href="{{ route('adminCreateBook') }}" type="submit" value="Submit">Create</a>
            </div>
          @endif
        </div>
        </div>
      </nav>
    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <div class="offcanvas offcanvas-start bg-dark text-white" data-bs-scroll="true" tabindex="-1" id="controlPanel" aria-labelledby="Control Panel" style="width: 300px">
        <div class="offcanvas-header">
            @if($auth??false)
                @if($profile['role'] == 'Admin')
                <h5 class="offcanvas-title" id="offcanvasLabel">Admin Control Panel</h5>
                @elseif ($profile['role'] == 'User')
                <h5 class="offcanvas-title" id="offcanvasLabel">Control Panel</h5>
                @endif
            @else
                <h5 class="offcanvas-title" id="offcanvasLabel">Auth Perpustakaan</h5>
            @endif
          <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @if($auth??false)
            <a @if(route('home') == Request::url()) class="row offcanvas-item active" @else class="row offcanvas-item" @endif href="{{ route('home') }}">
                <div class="col">
                    Home
                </div>
            </a>
            <a @if(route('profile') == Request::url()) class="row offcanvas-item active" @else class="row offcanvas-item" @endif href="{{ route('profile') }}">
                <div class="col">
                    Profile
                </div>
            </a>
            <a @if(route('books') == Request::url()) class="row offcanvas-item active" @else class="row offcanvas-item" @endif href="{{ route('books') }}">
                <div class="col">
                    Books
                </div>
            </a>
            <a @if(route('favoriteBook') == Request::url()) class="row offcanvas-item active" @else class="row offcanvas-item" @endif href="{{ route('favorite') }}">
                <div class="col">
                    Favorite
                </div>
            </a>
            <a @if(route('myBooks') == Request::url()) class="row offcanvas-item active" @else class="row offcanvas-item" @endif href="{{ route('myBooks') }}">
                <div class="col">
                    My Books
                </div>
            </a>
            @if($profile['role'] === 'Admin')
            <div style="border-top: 1px solid silver; margin-top: 8px;">
                {{-- <p style="padding-top: 12px; font-size: 17px; color: silver; font-weight: bold;">Admin Control</p> --}}
            </div>
            <a @if(route('adminBooks') == Request::url()) class="row offcanvas-item active" @else class="row offcanvas-item" @endif href="{{ route('adminBooks') }}" style="margin-top: 8px;">
                <div class="col">
                    Admin Books
                </div>
            </a>
            <a @if(route('adminUsers') == Request::url()) class="row offcanvas-item active" @else class="row offcanvas-item" @endif href="{{ route('adminUsers') }}">
                <div class="col">
                    Admin Users
                </div>
            </a>
            <a @if(route('adminCategories') == Request::url()) class="row offcanvas-item active" @else class="row offcanvas-item" @endif href="{{ route('adminCategories') }}">
                <div class="col">
                    Admin Categories
                </div>
            </a>
            <a @if(route('adminGenres') == Request::url()) class="row offcanvas-item active" @else class="row offcanvas-item" @endif href="{{ route('adminGenres') }}">
                <div class="col">
                    Admin Genres
                </div>
            </a>
            @endif
            @endif
            @if(!($auth??false))
            <a class="row offcanvas-item" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">
                <div class="col">
                    Login
                </div>
            </a>
            <a @if(route('register') == Request::url()) class="row offcanvas-item active" @else class="row offcanvas-item" @endif href="{{ route('register') }}">
                <div class="col">
                    Register
                </div>
            </a>
            @else
            <div style="border-top: 1px solid silver; margin-top: 8px;">
                {{-- <p style="padding-top: 12px; font-size: 17px; color: silver; font-weight: bold;">Admin Control</p> --}}
            </div>
            <a class="row offcanvas-item" type="button" href="{{ route('logout') }}" data-bs-toggle="modal" data-bs-target="#logoutModal" type="submit" style="margin-top: 8px;">
                <div class="col">
                    Logout
                </div>
            </a>
            </div>
          @endif
        </div>
      </div>

      <!-- Modal -->
@if(!($auth??false))
<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Login">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-dark">
          <h5 class="modal-title text-white" id="staticBackdropLabel">Login Perpustakaan</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @if(Session::get('loginErrors') != null)
                <div class="alert alert-danger" role="alert">
                    Errors : {{ Session::get('loginErrors') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-8 offset-md-4">

                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
        </div>
      </div>
    </div>
  </div>
  @endif

  @if($auth??false)
  <div class="modal fade" id="logoutModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Logout" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-dark">
          <h5 class="modal-title text-white" id="staticBackdropLabel">Logout Perpustakaan</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p style="font-size: 15px;" class="m-1">Are you sure logout this account?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
          <a class="btn btn-danger" href="{{ route('logout') }}" type="submit">Logout</a>
        </div>
      </div>
    </div>
  </div>
  @endif

@if($ag??false)
<div class="modal fade" id="createGenreModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Create Genre">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Create Genre</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('adminStoreGenre') }}">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="name-genre" name="name" placeholder="Name" maxlength="50" minlength="1" required>
                    <label for="name-genre">Name</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Store</button>
                </form>
            </div>
        </div>
    </div>
</div>
@elseif($ac??false)
<div class="modal fade" id="createCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Create Category">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Create Category</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('adminStoreCategory') }}">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="name-category" name="name" placeholder="Name" maxlength="50" minlength="1" required>
                    <label for="name-category">Name</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Store</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<div class="modal fade" id="messagesModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Logout" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-dark">
          <h5 class="modal-title text-white" id="staticBackdropLabel">Messages</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p style="font-size: 15px;" class="m-1">{{ Session::get('messages')??'' }}</p>
        </div>
        <div class="modal-footer">
          <button type="button" style="width: 70px;" class="btn btn-dark" data-bs-dismiss="modal">OK</button>
          {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal" type="submit">Login</button> --}}
        </div>
      </div>
    </div>
</div>

<div style="margin-top: 300px;">

</div>

  <script src="{{ asset('js/jquery.js') }}" type="text/javascript"></script>
  <script>
    const errors = "<?php echo Session::get('loginErrors')??'' ?>";
    const messages = "<?php echo Session::get('messages')??'' ?>";
    const books = []; const users = [];
  </script>
  <script src="{{ asset('js/script.js') }}"></script>

  @foreach ($books??[] as $st)
  <script>
    books.push("<?php echo $st['id'] ?>");
  </script>
  @endforeach

  @foreach ($users??[] as $st)
  <script>
    users.push("<?php echo $st['id'] ?>");
  </script>
  @endforeach


</body>
</html>
