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
                                <button class="list-group-item active" id="list-users-tab" data-bs-toggle="pill" data-bs-target="#list-users" type="button" role="tab" aria-controls="list users" aria-selected="true">List Users</button>
                                <button class="list-group-item" id="role-tab" data-bs-toggle="pill" data-bs-target="#role" type="button" role="tab" aria-controls="role" aria-selected="false">Role</button>
                                <button class="list-group-item" id="gender-tab" data-bs-toggle="pill" data-bs-target="#gender" type="button" role="tab" aria-controls="gender" aria-selected="false">Gender</button>
                                <button class="list-group-item" id="sort-by-tab" data-bs-toggle="pill" data-bs-target="#sort-by" type="button" role="tab" aria-controls="sort-by" aria-selected="false">Sort By</button>
                                <button class="list-group-item" id="order-by-tab" data-bs-toggle="pill" data-bs-target="#order-by" type="button" role="tab" aria-controls="order-by" aria-selected="false">Order By</button>
                            </div>
                            <form action="{{ route('adminUsers') }}">
                            <div class="d-grid btn-filter">
                                <input style="display: none;" type="search" aria-label="Search" name="s" value="{{ $s ?? '' }}">
                                <button class="btn btn-primary" type="submit">Filter</button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="card card-body" style="height: 275px;">
                                    <div class="tab-pane fade show active" id="list-users" role="tabpanel" aria-labelledby="list-users-tab">
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
                                    <div class="tab-pane fade" id="role" role="tabpanel" aria-labelledby="role-tab">
                                        <div class="row row-cols-auto overflow-auto">
                                            <div class="col-12">
                                                <div class="form-floating m-1">
                                                    <select class="form-select bg-white" name="r" id="floatingRole" aria-label="Select Role">
                                                        <option value="">--</option>
                                                        <option value="Admin" @if ($r === "Admin")
                                                        selected
                                                        @endif>Admin</option>
                                                        <option value="User" @if ($r === "User")
                                                        selected
                                                        @endif>User</option>
                                                    </select>
                                                    <label for="floatingRole">Role</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="gender" role="tabpanel" aria-labelledby="gender-tab">
                                        <div class="row row-cols-auto overflow-auto">
                                            <div class="col-12">
                                                <div class="form-floating m-1">
                                                    <select class="form-select bg-white" name="g" id="floatingGender" aria-label="Select Gender">
                                                        <option value="">--</option>
                                                        <option value="Male" @if ($g === "Male")
                                                        selected
                                                        @endif>Male</option>
                                                        <option value="Female" @if ($g === "Female")
                                                        selected
                                                        @endif>Female</option>
                                                    </select>
                                                    <label for="floatingGender">Gender</label>
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
                                                    <option value="Id" @if ($sb === "Id")
                                                    selected
                                                    @endif>Id</option>
                                                    <option value="Name" @if ($sb === "Name")
                                                    selected
                                                    @endif>Name</option>
                                                    <option value="Email" @if ($sb === "Email")
                                                    selected
                                                    @endif>Email</option>
                                                    <option value="Role"
                                                    @if ($sb === "Role")
                                                    selected
                                                    @endif>Role</option>
                                                    <option value="Gender"
                                                    @if ($sb === "Gender")
                                                    selected
                                                    @endif>Gender</option>
                                                    <option value="DateOfBirth"
                                                    @if ($sb === "DateOfBirth")
                                                    selected
                                                    @endif>Date Of Birth</option>
                                                    <option value="PhoneNumber"
                                                    @if ($sb === "PhoneNumber")
                                                    selected
                                                    @endif>PhoneNumber</option>
                                                    <option value="Address"
                                                    @if ($sb === "Address")
                                                    selected
                                                    @endif>Address</option>
                                                    <option value="DateCreated"
                                                    @if ($sb === "DateCreated")
                                                    selected
                                                    @endif>Date Created</option>
                                                    <option value="DateUpdated"
                                                    @if ($sb === "DateUpdated")
                                                    selected
                                                    @endif>Date Updated</option>
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

@if(Session::get('userErrors') != null)
<div class="alert alert-danger mt-2" style="margin-bottom: 0px;" role="alert">
    Errors : {{ Session::get('userErrors') }}
</div>
@else
<div class="mt-3"></div>
@endif

@if(!empty($users??[]))
@foreach ($users as $st)
<div class="card mt-2" >
    <div class="row g-0">
      <div class="col-md-2 align-self-center">
          <a data-bs-toggle="modal" data-bs-target="#imageModal{{$st['id']}}">
        <img src="http://192.168.21.1:8021/api/Users/UserImage/{{ $st['image'] }}" id="imageUser{{ $st['id'] }}" class="img-fluid rounded-start" alt="Image Profile">
        </a>
      </div>
      <div class="col-md-8 align-self-center" >
        <div class="row overflow-auto m-1" style="width: 95%; display: none;" id="contentUser{{ $st['id'] }}">
            <div class="card-body" >
                <p class="" style="font-size: 24px;">Name : <span class="ms-1">{{ $st['name'] }}</span></p>
                <p class="" style="font-size: 18px;">Email : <span class="ms-1">{{ $st['email'] }}</span></p>
                <p class="" style="font-size: 18px;">Role : <span class="ms-1">{{ $st['role'] }}</span></p>
                <p class="" style="font-size: 18px;">Gender : <span class="ms-1">{{ $st['gender'] }}</span></p>
                <p class="" style="font-size: 18px;">Phone Number : <span class="ms-1">{{ $st['phoneNumber'] }}</span></p>
                <p class="" style="font-size: 18px;">Date Of Birth : <span class="ms-1">{{ substr($st['dateOfBirth'], 0, 10) }}</span></p>
                <p class="" style="font-size: 18px;">Address : </p>
                <p style="font-size: 16px; margin-top: -8px;">{{ $st['address'] }}</p>
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
            <a class="btn btn-primary text-white" href="{{ route('adminShowUser', ['id' => $st['id']]) }}" target="_blank" type="submit" value="Submit">Show</a>
            <a class="btn btn-warning text-white" href="{{ route('adminEditUser', ['id' => $st['id']]) }}" type="submit" value="Submit">Edit</a>
            <a class="btn btn-danger" data-bs-target="#deleteUserModal{{$st['id']}}" data-bs-toggle="modal" aria-controls="Delete User Modal">Delete</a>
        </div>
      </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal{{$st['id']}}" tabindex="-1" aria-labelledby="imageModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content overflow-auto">
        <img src="http://192.168.21.1:8021/api/Users/UserImage/{{ $st['image'] }}" class="rounded" id="imgProfile" alt="Book Image">
      </div>
    </div>
</div>

<div class="modal fade" id="deleteUserModal{{$st['id']}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Delete User Modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-dark">
          <h5 class="modal-title text-white" id="staticBackdropLabel">Confirmation?</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p style="font-size: 15px;" class="m-1">Are you sure delete this user "{{ $st['name'] }}"?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
          <form action="{{ route('adminDeleteUser') }}" method="POST">
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
      Status Code 404 : Users Not Found!
    </div>
</div>
@endif
@endsection
