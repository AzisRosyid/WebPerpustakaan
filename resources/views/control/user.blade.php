@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-body bg-dark text-white" style="font-size: 28px;">
           @if($cr??false) User Create @elseif($ed??false) User Edit @endif
        </div>
    </div>
    @if(isset($userErrors))
    <div class="col pt-1">
        <div class="alert alert-danger" role="alert">
            Errors : {{ $userErrors }}
        </div>
    </div>
    <div class="col-md-12" style="margin-top: -12px;">
    @else
    <div class="col-md-12 pt-1">
    @endif
        <div class="card card-body">
            <form @if($cr??false) action="{{ route('adminStoreUser') }}" @elseif($ed??false) action="{{ route('adminUpdateUser', ['id' => $user['id']]) }}" @endif method="POST" enctype="multipart/form-data">
                @if($ed??false) @method('put') @endif
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-floating m-2">
                            <input type="text" name="name" class="form-control bg-white" id="name" placeholder="Name" value="{{ $user['name']??'' }}" required>
                            <label for="name">Name</label>
                        </div>
                        <div class="form-floating m-2">
                            <input type="email" name="email" class="form-control bg-white" id="email" placeholder="name@example.com" value="{{ $user['email']??'' }}" required>
                            <label for="email">Email Address</label>
                        </div>
                        <div class="form-floating m-2">
                            <input type="password" name="password" class="form-control bg-white" id="password" placeholder="Password" minlength="8" value="{{ $user['password']??'' }}" required>
                            <label for="password">Password</label>
                        </div>
                        <div class="form-floating m-2">
                            <select class="form-select bg-white" name="role" id="role" aria-label="Select Role" required>
                              <option value="">--</option>
                              <option value="Admin" @if ($user['role']??'' === "Admin")
                              selected
                              @endif>Admin</option>
                              <option value="User" @if ($user['role']??'' === "User")
                                selected
                                @endif>User</option>
                            </select>
                            <label for="role">Role</label>
                        </div>
                        <div class="form-floating m-2">
                            <select class="form-select bg-white" name="gender" id="gender" aria-label="Select Gender" required>
                              <option value="">--</option>
                              <option value="Male" @if ($user['gender']??'' === "Male")
                              selected
                              @endif>Male</option>
                              <option value="Female" @if ($user['gender']??'' === "Female")
                                selected
                                @endif>Female</option>
                            </select>
                            <label for="gender">Gender</label>
                        </div>
                        <div class="form-floating m-2">
                            <input type="date" name="dateOfBirth" class="form-control bg-white" id="dateOfBirth" placeholder="DateOfBirth" value="{{ substr($user['dateOfBirth']??'', 0, 10) }}" required>
                            <label for="dateOfBirth">Date Of Birth</label>
                        </div>
                        <div class="form-floating m-2">
                            <input type="tel" name="phoneNumber" pattern="[0-9]{8,13}" class="form-control bg-white" id="phoneNumber" placeholder="PhoneNumber" value="{{ $user['phoneNumber']??'' }}" required>
                            <label for="phoneNumber">Phone Number</label>
                        </div>
                        <div class="form-floating m-2">
                            <textarea class="form-control bg-white" placeholder="Address" name="address" id="address" style="height: 100px" required>{{ $user['address']??'' }}</textarea>
                            <label for="address">Address</label>
                        </div>
                        <div class="m-2">
                            <label for="image" class="form-label">Upload Image Profile</label>
                            <input class="form-control bg-white" type="file" name="image" accept="image/png, image/jpg, image/jpeg" id="image" placeholder="Select Image">
                          </div>
                    </div>
                    <div class="col-md-4 register-panel">
                        <div class="d-grid gap-2 m-2">
                            <input type="text" name="url" style="display: none;" value="{{ $url??'' }}" readonly>
                            @if($cr??false)
                            <button class="btn btn-success" type="submit" value="Submit">Store</button>
                            @elseif($ed??false)
                            <button class="btn btn-warning text-white" type="submit" value="Submit">Update</button>
                            @endif
                            <a class="btn btn-danger" href="{{ $url }}">Cancel</a>
                        </div>
                        <div class="text-center img-profile">
                            <label class="form-label" for="imgProfile">Image Profile</label>
                            <a data-bs-toggle="modal" data-bs-target="#imageModal">
                                <img @if($user['image']??null != null) src="http://192.168.21.1:8021/api/Users/UserImage/{{ $user['image'] }}" @else src="{{ asset('img/nopick.png') }}"  @endif class="rounded" width="100%"  id="imgProfile" alt="Profile Image">
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content overflow-auto">
        <img @if($user['image']??null != null) src="http://192.168.21.1:8021/api/Users/UserImage/{{ $user['image'] }}" @else src="{{ asset('img/nopick.png') }}" @endif class="rounded" width="100%"  id="imgProfileModal" alt="Image Profile">
      </div>
    </div>
</div>
@endsection
