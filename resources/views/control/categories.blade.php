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
                    <div class="card card-body a-search-collapse-v2">
                    <div class="row">
                        <div class="col-md-4">
                            <div id="v-pills-tab" role="tablist" class="list-group">
                                <button class="list-group-item active" id="list-categories-tab" data-bs-toggle="pill" data-bs-target="#list-categories" type="button" role="tab" aria-controls="list categories" aria-selected="true">List Categories</button>
                                <button class="list-group-item" id="sort-by-tab" data-bs-toggle="pill" data-bs-target="#sort-by" type="button" role="tab" aria-controls="sort-by" aria-selected="false">Sort By</button>
                                <button class="list-group-item" id="order-by-tab" data-bs-toggle="pill" data-bs-target="#order-by" type="button" role="tab" aria-controls="order-by" aria-selected="false">Order By</button>
                            </div>
                            <form action="{{ route('adminCategories') }}">
                            <div class="d-grid btn-filter">
                                <input style="display: none;" type="search" aria-label="Search" name="s" value="{{ $s ?? '' }}">
                                <button class="btn btn-primary" type="submit">Filter</button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="card card-body" style="height: 200px;">
                                    <div class="tab-pane fade show active" id="list-genres" role="tabpanel" aria-labelledby="list-genres-tab">
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
                                                    <option value="Id" @if ($sb === "Id")
                                                    selected
                                                    @endif>Id</option>
                                                    <option value="Name" @if ($sb === "Name")
                                                    selected
                                                    @endif>Name</option>
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

@if(Session::get('categoryErrors') != null)
<div class="alert alert-danger mt-2" style="margin-bottom: 0px;" role="alert">
    Errors : {{ Session::get('categoryErrors') }}
</div>
@else
<div class="mt-3"></div>
@endif

@if(!empty($categories??[]))

@foreach ($categories as $st)
<div class="card mt-2" >
    <div class="row ps-3 g-0">
      <div class="col-md-2 align-self-center">
          <div class="row">
            <p class="align-middle" style="position: relative; bottom: -8px; padding-left: 20px; font-size: 18px;">{{ $loop->index + 1 + (($p - 1) * $pc) }}.</p>
          </div>
      </div>
      <div class="col-md-6 align-self-center" >
        <div class="row row-cols-auto">
            <p class="align-middle align-self-center col overflow-auto" style="position: relative; margin-left: 10px; bottom: -8px;font-size: 18px; width: 60%;" >{{ $st['name'] }}</p>
            <p class="align-middle align-self-center col" style="position: relative; margin-left: 10px; bottom: -8px; font-size: 18px; width: 30%" >Tags : {{ $st['tags'] }}</p>
        </div>
      </div>
      <div class="col-md-2 align-self-center">
        <div class="d-grid gap-2 m-2">
            <a class="btn btn-warning text-white" data-bs-target="#editCategoryModal{{ $st['id'] }}" data-bs-toggle="modal" aria-controls="Edit Cateogory Modal">Edit</a>
        </div>
      </div>
      <div class="col-md-2 align-self-center pe-2">
        <div class="d-grid gap-2 m-2">
            <a class="btn btn-danger" data-bs-target="#deleteCategoryModal{{$st['id']}}" data-bs-toggle="modal" aria-controls="Delete Category Modal">Delete</a>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="editCategoryModal{{ $st['id'] }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Edit Category Modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Edit Category</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('adminUpdateCategory') }}">
                @method('put')
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" name="id" value="{{$st['id']}}" style="display: none;" readonly>
                    <input type="text" class="form-control" id="name-category" name="name" placeholder="Name" value="{{ $st['name'] }}" minlength="1" maxlength="50" required>
                    <label for="name-category">Name</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-warning text-white">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteCategoryModal{{$st['id']}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Delete Category Modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-dark">
          <h5 class="modal-title text-white" id="staticBackdropLabel">Confirmation?</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p style="font-size: 15px;" class="m-1">Are you sure delete this category "{{ $st['name'] }}"?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
          <form action="{{ route('adminDeleteCategory') }}" method="POST">
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
      Status Code 404 : Categories Not Found!
    </div>
</div>
@endif
@endsection
