@extends('layouts.main')

@section('content')

<div class="card mt-6">
    <div class="card-body">
      <div class="row align-items-center">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
              <h1 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne" style="font-size: 26px;">
                  Filter Search
                </button>
              </h1>
              <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <div class="card card-body a-search-collapse">
                    <div class="row">
                        <div class="col-md-4">
                            <div id="v-pills-tab" role="tablist" class="list-group">
                                <button class="list-group-item active" id="list-books-tab" data-bs-toggle="pill" data-bs-target="#list-books" type="button" role="tab" aria-controls="list books" aria-selected="true">List Books</button>
                                <button class="list-group-item" id="user-tab" data-bs-toggle="pill" data-bs-target="#user" type="button" role="tab" aria-controls="user" aria-selected="false">User</button>
                                <button class="list-group-item" id="category-tab" data-bs-toggle="pill" data-bs-target="#category" type="button" role="tab" aria-controls="category" aria-selected="false">Category</button>
                                <button class="list-group-item" id="genres-tab" data-bs-toggle="pill" data-bs-target="#genres" type="button" role="tab" aria-controls="genres" aria-selected="false">Genres</button>
                                <button class="list-group-item" id="sort-by-tab" data-bs-toggle="pill" data-bs-target="#sort-by" type="button" role="tab" aria-controls="sort-by" aria-selected="false">Sort By</button>
                                <button class="list-group-item" id="order-by-tab" data-bs-toggle="pill" data-bs-target="#order-by" type="button" role="tab" aria-controls="order-by" aria-selected="false">Order By</button>
                                <button class="list-group-item" id="date-tab" data-bs-toggle="pill" data-bs-target="#date" type="button" role="tab" aria-controls="date" aria-selected="false">Date</button>
                            </div>
                            <form @if($my??false) action="{{ route('myBooks') }}" @elseif($ab??false) action="{{ route('adminBooks') }}" @endif>
                            <div class="d-grid btn-filter">
                                <input style="display: none;" type="search" aria-label="Search" name="s" value="{{ $s ?? '' }}">
                                <button class="btn btn-primary" type="submit">Filter</button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="card card-body" style="height: 355px;">
                                    <div class="tab-pane fade show active" id="list-books" role="tabpanel" aria-labelledby="list-books-tab">
                                        <div class="row row-cols-auto overflow-auto">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="ms-2" for="page">Page</label>
                                                        <div class="input-group mb-3 m-1">
                                                            <span class="input-group-text">1</span>
                                                            <input type="number"
                                                            min="1" max="{{ $tp }}"
                                                            value="{{ $p }}"
                                                            id="page" name="p" class="form-control bg-white" aria-label="Page">
                                                            <span class="input-group-text">{{ $tp }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="ms-3" for="pick">Pick</label>
                                                        <div class="input-group mb-3 m-1">
                                                            <span class="input-group-text">1</span>
                                                            <input type="number"
                                                            min="1" max="99"
                                                            value="{{ $pc }}"
                                                            id="pick" name="pc" class="form-control bg-white" aria-label="Pick">
                                                            <span class="input-group-text">99</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
                                        <div class="row overflow-auto">
                                            <div class="m-1 col">
                                                <div class="input-group">
                                                    <button class="btn btn-primary text-white" id="btn-user" type="button" data-bs-toggle="modal" data-bs-target="#userModal">Select User</button>
                                                    <input type="text" style="display: none;" id="userId" name="ui" value="{{ $ui??'' }}" readonly>
                                                    <input type="text" style="display: none;" name="u" id="userName" value="{{ $u??'Click to Select User' }}" readonly>
                                                    <label class="card card-body user-select-search" id="userLabel" for="btn-user">{{ $u??'Click to Select User' }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="category" role="tabpanel" aria-labelledby="category-tab">
                                        <div class="row row-cols-auto overflow-auto">
                                                @foreach ($categories as $st)
                                                <div class="col m-1">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="c" id="category{{ $st['id'] }}" value="{{ $st['id'] }}" @if ($c == $st['id'])
                                                        checked
                                                        @endif>
                                                        <label class="form-check-label" for="category{{ $st['id'] }}">
                                                        {{ $st['name'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="genres" role="tabpanel" aria-labelledby="genres-tab">
                                        <div class="row row-cols-auto overflow-auto">
                                            @foreach ($genres as $st)
                                                <div class="col m-1">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" value="{{ $st['id'] }}" id="genres{{ $st['id'] }}" name="g[]" @if (in_array($st['id'], $g ?? []))
                                                            checked
                                                        @endif>
                                                        <label class="form-check-label" for="genres{{ $st['id'] }}">{{ $st['name'] }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="sort-by" role="tabpanel" aria-labelledby="sort-by-tab">
                                        <div class="row row-cols-auto overflow-auto">
                                            <div class="col-12">
                                                <div class="form-floating m-1">
                                                    <select class="form-select bg-white"
                                                name="sb" id="floatingSort" aria-label="Select Sort By">
                                                    <option value="">--</option>
                                                    <option value="Popularity" @if ($sb === "Popularity")
                                                    selected
                                                    @endif>Popularity</option>
                                                    <option value="Favorite" @if ($sb === "Favorite")
                                                    selected
                                                    @endif>Favorite</option>
                                                    <option value="Id" @if ($sb === "Id")
                                                    selected
                                                    @endif>Id</option>
                                                    <option value="Title" @if ($sb === "Title")
                                                    selected
                                                    @endif>Title</option>
                                                    <option value="Author" @if ($sb === "Author")
                                                    selected
                                                    @endif>Author</option>
                                                    <option value="Publisher" @if ($sb === "Publisher")
                                                    selected
                                                    @endif>Publisher</option>
                                                    <option value="TotalPage" @if ($sb === "TotalPage")
                                                    selected
                                                    @endif>Total Page</option>
                                                    <option value="DateUpdated" @if ($sb === "DateUpdated")
                                                    selected
                                                    @endif>Date Updated</option>
                                                    <option value="DateCreated"
                                                    @if ($sb === "DateCreated")
                                                    selected
                                                    @endif>Date Created</option>
                                                </select>
                                                <label for="floatingSort">Sort By</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="order-by" role="tabpanel" aria-labelledby="order-by-tab">
                                        <div class="row row-cols-auto overflow-auto">
                                            <div class="col-12">
                                                <div class="form-floating m-1">
                                                    <select class="form-select bg-white" name="ob" id="floatingOrder" aria-label="Select Order By">
                                                        <option value="">--</option>
                                                        <option value="Ascending" @if ($ob === "Ascending")
                                                        selected
                                                        @endif>Ascending [A-Z]</option>
                                                        <option value="Descending" @if ($ob === "Descending")
                                                        selected
                                                        @endif>Descending [Z-A]</option>
                                                    </select>
                                                    <label for="floatingOrder">Order By</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="date" role="tabpanel" aria-labelledby="date-tab">
                                        <div class="row row-cols-auto overflow-auto">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="ms-2" for="start">Date Start</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="ms-3" for="end">Date End</label>
                                                    </div>
                                                </div>
                                                <div class="input-group mb-3 m-1">
                                                    <input type="date" id="start" name="start"  class="form-control bg-white" placeholder="Date Start" aria-label="Date Start" value="{{ $start }}">
                                                    <span class="input-group-text">-</span>
                                                    <input type="date"
                                                    id="end" name="end" class="form-control bg-white" placeholder="Date End" aria-label="Date End" value="{{ $end }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                           </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
              </div>
            </div>
        </div>
      </div>
    </div>
</div>

@if(Session::get('bookErrors') != null)
<div class="alert alert-danger mt-2" style="margin-bottom: 0px;" role="alert">
    Errors : {{ Session::get('bookErrors') }}
</div>
@else
<div class="mt-3"></div>
@endif

@if(!empty($books??[]))
@foreach ($books as $st)
<div class="card mt-2" >
    <div class="row g-0">
      <div class="col-md-2 align-self-center">
          <a data-bs-toggle="modal" data-bs-target="#imageModal{{$st['id']}}">
        <img src="http://192.168.21.1:8021/api/Books/ImageBook/{{ $st['image'] }}" id="imageBook{{ $st['id'] }}" class="img-fluid rounded-start" alt="Image Profile">
        </a>
      </div>
      <div class="col-md-8 align-self-center" >
        <div class="row overflow-auto m-1" style="width: 95%; display: none;" id="contentBook{{ $st['id'] }}">
            <div class="card-body" >
                <p class="text-hidden" style="font-size: 24px; height: 30px;">Title : {{ $st['title'] }}</p>
                <p class="text-hidden" style="font-size: 18px; height: 24px;">Author : {{ $st['author'] }}</p>
                <div class="p-1"></div>
                @if($ab??false)
                <p class="text-hidden" style="font-size: 18px; height: 24px;">User : {{ $st['user']['name'] }}</p>
                @endif
                <p class="text-hidden" style="font-size: 18px; height: 24px;">Publisher : {{ $st['publisher'] }}</p>
                <p class="pt-1" style="font-size: 18px;">Category : @if ($st['category']['id'] != null)
                    <a class="btn btn-success ms-2" @if($fav??false) href="{{ route('favorite') }}?c={{ $st['category']['id'] }}" @else href="{{ route('myBooks') }}?c={{ $st['category']['id'] }}" @endif>{{ $st['category']['name'] }} </a>
                @endif </p>
                <div class="row">
                    <div class="col-md-2 pt-1" style="font-size: 18px; width: 85px;">Genre :</div>
                    <div class="col-md-10">
                        <div class="row row-cols-auto">
                        @foreach ($st['genres'] as $id)
                            <a @if($fav??false) href="{{ route('favorite') }}?g%5B%5D={{ $id['id'] }}" @else href="{{ route('myBooks') }}?g%5B%5D={{ $id['id'] }}" @endif class="btn btn-primary text-white m-1">{{ $id['name'] }}</a>
                        @endforeach
                        </div>
                    </div>
                </div>
                <p class="mt-2" style="font-size: 18px;">Pages : <span class="ms-1">{{ $st['page'] }}</span></p>
                <p class="" style="font-size: 18px;">Views : <span class="ms-1">{{ $st['viewCount'] }}</span></p>
                <p class="" style="font-size: 18px;">Description : </p>
                <p style="font-size: 16px; margin-top: -8px;">{{ $st['description'] }}</p>
                <div class="row">
                    <div class="col-md-6">
                        <p class="" style="font-size: 18px;">Date Created : <span class="ms-1">{{ substr($st['dateCreated'], 0, 10) }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="" style="font-size: 18px;">Date Updated : <span class="ms-1">{{ substr($st['dateUpdated'], 0, 10) }}</span></p>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="col-md-2 align-self-center pe-2">
        <div class="d-grid gap-2 m-2">
            <a class="btn btn-primary text-white" href="{{ route('getBook', ['id' => $st['id']]) }}" target="_blank" type="submit" value="Submit">Show</a>
            <a class="btn btn-warning text-white" @if($ab??false) href="{{ route('adminEditBook', ['id' => $st['id']]) }}" @elseif($my??false) href="{{ route('editBook', ['id' => $st['id']]) }}" @endif type="submit" value="Submit">Edit</a>
            <a class="btn btn-danger" data-bs-target="#deleteBookModal{{$st['id']}}" data-bs-toggle="modal" aria-controls="Delete Book Modal">Delete</a>
        </div>
      </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal{{$st['id']}}" tabindex="-1" aria-labelledby="imageModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content overflow-auto">
        <img src="http://192.168.21.1:8021/api/Books/ImageBook/{{ $st['image'] }}" class="rounded" id="imgProfile" alt="Book Image">
      </div>
    </div>
</div>

<div class="modal fade" id="deleteBookModal{{$st['id']}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Delete Book Modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-dark">
          <h5 class="modal-title text-white" id="staticBackdropLabel">Confirmation?</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p style="font-size: 15px;" class="m-1">Are you sure delete this book "{{ $st['title'] }}"?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
          <form @if($ab??false) action="{{ route('adminDeleteBook') }}" @elseif($my??false) action="{{ route('deleteBook') }}" @endif method="POST">
            @method('delete')
            @csrf
            <input type="text" name="id" value="{{$st['id']}}" style="display: none;" readonly>
          <button class="btn btn-danger" type="submit">Delete</button>
        </form>
        </div>
      </div>
    </div>
  </div>

@endforeach

<div class="card mt-3">
    <div class="card-body">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
              <li class="page-item @if($p <= 1) disabled @endif">
                <a class="page-link" href="{{ $url.'p='.$p-1 }}" tabindex="-1" @if($p <= 1)aria-disabled="true" @endif>Previous</a>
              </li>
              @if($p <= 1)<li class="page-item active"><a class="page-link"  href="{{ $url.'p='.$p }}">{{ $p }}</a></li>@elseif($p > 1 &&  ($p < $tp || $tp <= 2))<li class="page-item"><a class="page-link" href="{{ $url.'p='.$p-1 }}">{{ $p-1 }}</a></li>@else<li class="page-item"><a class="page-link" href="{{ $url.'p='.$p-2 }}">{{ $p-2 }}</a></li>@endif
              @if($tp >= 2)
              @if($p > 1 && ($p < $tp || $tp <= 2))<li class="page-item active"><a class="page-link" href="{{ $url.'p='.$p  }}">{{ $p }}</a></li>@elseif($p <= 1)<li class="page-item"><a class="page-link" href="{{ $url.'p='.$p+1 }}">{{ $p+1 }}</a></li>@else<li class="page-item"><a class="page-link" href="{{ $url.'p='.$p-1 }}">{{ $p-1 }}</a></li>@endif
              @endif
              @if($tp >= 3)
              @if($p <= 1)<li class="page-item"><a class="page-link"  href="{{ $url.'p='.$p+2  }}">{{ $p+2 }}</a></li>@elseif($p > 1 && $p < $tp)<li class="page-item"><a class="page-link" href="{{ $url.'p='.$p+1 }}">{{ $p+1 }}</a></li>@else<li class="page-item active"><a class="page-link" href="{{ $url.'p='.$p }}">{{ $p }}</a></li>@endif
              @endif
              <li class="page-item @if($p >= $tp) disabled @endif">
                <a class="page-link" href="{{ $url.'p='.$p+1 }}">Next</a>
              </li>
            </ul>
          </nav>
    </div>
</div>


@else
<div class="card mt-1">
    <div class="card-body" style="font-size: 18px;">
      Status Code 404 : Books Not Found!
    </div>
</div>
@endif

{{-- Modal --}}
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModal" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
      <div class="modal-content" style="background: transparent; overflow: auto;">
        <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
            <div class="container-fluid">
                <div>
                    <span class="navbar-brand fs-4 ps-2 align-middle">Select User</span>
                </div>
                <input class="form-control search-modal input-search me-2" type="search" placeholder="Search User..." aria-label="Search" name="s" id="searchUserModal">
              <button type="button" id="closeUserModal" class="btn-modal-close btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </nav>
        <div id="userModalContent"></div>
      </div>
    </div>
</div>

<script>
    const usersUrl = "{{ route('adminUsers') }}";
    const userUrl = "{{ route('adminShowUser', ['']) }}";
    const defaultImg = "{{ asset('img/nopick.png') }}";
</script>

@endsection
