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
                                <button class="list-group-item" id="list-books-tab" data-bs-toggle="pill" data-bs-target="#list-books" type="button" role="tab" aria-controls="list books" aria-selected="true">List Books</button>
                                <button class="list-group-item" id="category-tab" data-bs-toggle="pill" data-bs-target="#categories" type="button" role="tab" aria-controls="categories" aria-selected="true">Categories</button>
                                <button class="list-group-item" id="genres-tab" data-bs-toggle="pill" data-bs-target="#genres" type="button" role="tab" aria-controls="genres" aria-selected="false">Genres</button>
                                <button class="list-group-item" id="sort-by-tab" data-bs-toggle="pill" data-bs-target="#sort-by" type="button" role="tab" aria-controls="sort-by" aria-selected="false">Sort By</button>
                                <button class="list-group-item" id="order-by-tab" data-bs-toggle="pill" data-bs-target="#order-by" type="button" role="tab" aria-controls="order-by" aria-selected="false">Order By</button>
                                <button class="list-group-item" id="date-tab" data-bs-toggle="pill" data-bs-target="#date" type="button" role="tab" aria-controls="date" aria-selected="false">Date</button>
                            </div>
                            <form @if($fav??false) action="{{ route('favorite') }}" @else action="{{ route('books') }} @endif">
                            <div class="d-grid btn-filter">
                                <input style="display: none;" type="search" aria-label="Search" name="s" value="{{ $s ?? '' }}">
                                <button class="btn btn-primary" type="submit">Filter</button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="card card-body" style="height: 315px;">
                                    <div class="tab-pane fade" id="list-books" role="tabpanel" aria-labelledby="list-books-tab">
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
                                    <div class="tab-pane fade show active" id="categories" role="tabpanel" aria-labelledby="category-tab">
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
                                                    <input type="date" id="start" name="start"  class="form-control bg-white" placeholder="Date Start" aria-label="Date Start">
                                                    <span class="input-group-text">-</span>
                                                    <input type="date"
                                                    id="end" name="end" class="form-control bg-white" placeholder="Date End" aria-label="Date End">
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

@if (!empty($books))

<div class="row row-cols-auto align-items-center">
    @foreach ($books as $st)
    <div class="">
        <a @if($fav??false) href="{{ route('getFavorite', ['id' => $st['id']]) }}" @else href="{{ route('getBook', ['id' => $st['id']]) }}" @endif class="text-decoration-none text-black">
        <div class="card book-item">
            <img src="http://192.168.21.1:8021/api/Books/ImageBook/{{ $st['image'] }}" class="card-img-top" alt="...">
            <div class="card-body">
            <h5 class="card-title text-hidden">{{ $st['title'] }}</h5>
            <p class="card-text text-hidden">{{ $st['author'] }}</p>
            </div>
        </div>
        </a>
    </div>
@endforeach
</div>

<div class="card mt-6">
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

@endsection
