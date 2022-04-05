@extends('layouts.main')

@section('content')
<div class="row">
    <div class="card card-body">
        <div class="row">
            @if(Session::get('deleteErrors') != null)
            <div class="col-md-12">
                <div class="alert alert-danger" style="margin-top: 4px; margin-bottom: 3px;" role="alert">
                    Errors : {{ Session::get('deleteErrors') }}
                </div>
            </div>
            @endif
            <div class="col-md-5">
                <div class="text-center">
                    <a data-bs-toggle="modal" data-bs-target="#imageModal">
                        <img src="http://192.168.21.1:8021/api/Users/UserImage/{{ $profile['image'] }}" class="rounded" width="100%"  id="imageProfile" alt="Profile Image">
                    </a>
                </div>
            </div>
            <div class="col-md-7">
                <p class="text-hidden" style="font-size: 32px; height: 40px;">{{ $profile['name'] }}</p>
                <p class="text-hidden" style="font-size: 24px; height: 30px;">{{ $profile['email'] }}</p>
                <div class="p-3"></div>
                <p style="font-size: 18px; height: 24px;">Role : <span class="ms-1">{{ $profile['role'] }}</span></p>
                <p class="pt-1" style="font-size: 18px;">Gender : <span class="ms-1">{{ $profile['gender'] }}</span></p>
                <p class="mt-2" style="font-size: 18px;">Phone Number : <span class="ms-1">{{ $profile['phoneNumber'] }}</span></p>
                <p class="mt-2" style="font-size: 18px;">Date Of Birth : <span class="ms-1">{{ substr($profile['dateOfBirth'], 0, 10) }}</span></p>
                <p class="" style="font-size: 18px;">Address : <span class="ms-1">{{ $profile['address'] }}</span></p>
                <div class="d-grid gap-2" style="padding-top: 20px;">
                    <button class="btn btn-dark mt-3" type="submit" value="Submit" data-bs-target="#updateProfile" data-bs-toggle="collapse" aria-expanded="false" aria-controls="updateCollapse">Edit Profile</button>
                    <button class="btn btn-danger" type="submit" value="Submit" data-bs-target="#deleteAccountModal" data-bs-toggle="modal" aria-controls="deleteAccountModal">Delete Account</button>
                </div>
                <div class="pt-1"></div>
            </div>
        </div>
    </div>
</div>

<div @if(Session::get('profileErrors') == null) class="row pt-2 bg-light text-center collapse" @else class="row pt-2 bg-light text-center collapse show" @endif id="updateProfile">
    <div class="card card-body bg-dark text-white" style="font-size: 18px;">
        Edit Profile
    </div>
    @if(Session::get('profileErrors') != null)
    <div class="alert alert-danger" style="margin-top: 4px; margin-bottom: 3px;" role="alert">
        Errors : {{ Session::get('profileErrors') }}
    </div>
    @else
    <div class="col-md-12 pt-1"></div>
    @endif
    <div class="card card-body" style="font-size: 16px;">
        <div class="row">
            <div class="col-md-12 pt-1">
                    <div class="">
                        <form action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-floating m-2">
                                        <input type="text" name="name" class="form-control bg-white" id="name" placeholder="Name" value="{{ $profile['name'] }}" required>
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="form-floating m-2">
                                        <input type="email" name="email" class="form-control bg-white" id="email" placeholder="name@example.com" value="{{ $profile['email'] }}" required>
                                        <label for="email">Email Address</label>
                                    </div>
                                    <div class="form-floating m-2">
                                        <input type="password" name="passwordOld" class="form-control bg-white" id="passwordOld" placeholder="Password Old" minlength="8" required>
                                        <label for="passwordOld">Password Old</label>
                                    </div>
                                    <div class="form-floating m-2">
                                        <input type="password" name="password" class="form-control bg-white" id="password" placeholder="Password" minlength="8">
                                        <label for="password">New Password</label>
                                    </div>
                                    @if($profile['role'] == 'Admin')
                                    <div class="form-floating m-2">
                                        <select class="form-select bg-white" name="role" id="role" aria-label="Select Role" required>
                                          <option value="Admin" @if ($profile['role'] === "Admin")
                                          selected
                                          @endif>Admin</option>
                                          <option value="User" @if ($profile['role'] === "User")
                                            selected
                                            @endif>User</option>
                                        </select>
                                        <label for="role">Role</label>
                                    </div>
                                    @elseif($profile['role'] == 'User')
                                    <div class="form-floating m-2">
                                        <select class="form-select bg-white" name="role" id="role" aria-label="Select Role" required readonly style="display: none;">
                                          <option value="User" @if ($profile['role'] === "User")
                                            selected
                                            @endif>User</option>
                                        </select>
                                        <label for="role">Role</label>
                                    </div>
                                    @endif
                                    <div class="form-floating m-2">
                                        <select class="form-select bg-white" name="gender" id="gender" aria-label="Select Gender" required>
                                          <option value="Male" @if ($profile['gender'] === "Male")
                                          selected
                                          @endif>Male</option>
                                          <option value="Female" @if ($profile['gender'] === "Female")
                                            selected
                                            @endif>Female</option>
                                        </select>
                                        <label for="gender">Gender</label>
                                    </div>
                                    <div class="form-floating m-2">
                                        <input type="date" name="dateOfBirth" class="form-control bg-white" id="dateOfBirth" placeholder="DateOfBirth" value="{{ substr($profile['dateOfBirth'], 0, 10) }}" required>
                                        <label for="dateOfBirth">Date Of Birth</label>
                                    </div>
                                    <div class="form-floating m-2">
                                        <input type="tel" name="phoneNumber" pattern="[0-9]{8,13}" class="form-control bg-white" id="phoneNumber" placeholder="PhoneNumber" value="{{ $profile['phoneNumber'] }}" required>
                                        <label for="phoneNumber">Phone Number</label>
                                    </div>
                                    <div class="form-floating m-2">
                                        <textarea class="form-control bg-white" placeholder="Address" name="address" id="address" style="height: 100px" required>{{ $profile['address'] }}</textarea>
                                        <label for="address">Address</label>
                                    </div>
                                    <div class="m-2">
                                        <label for="image" class="form-label">Upload Image Profile</label>
                                        <input class="form-control bg-white" type="file" name="image" accept="image/png, image/jpg, image/jpeg" id="image" placeholder="Select Image">
                                    </div>
                                </div>
                                <div class="col-md-4 register-panel">
                                    <div class="d-grid gap-2 m-2">
                                        <button class="btn btn-warning text-white" type="submit" value="Submit">Update</button>
                                        <a class="btn btn-danger" data-bs-target="#updateProfile" data-bs-toggle="collapse" aria-expanded="false" aria-controls="updateCollapse">Cancel</a>
                                    </div>
                                    <div class="text-center img-profile">
                                        <label class="form-label" for="imgProfile">Image Profile</label>
                                        <a data-bs-toggle="modal" data-bs-target="#imgModal">
                                            <img src="http://192.168.21.1:8021/api/Users/UserImage/{{ $profile['image'] }}" class="rounded" width="100%"  id="imgProfile" alt="Profile Image">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="imgModal" tabindex="-1" aria-labelledby="imgModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content overflow-auto">
        <img src="http://192.168.21.1:8021/api/Users/UserImage/{{ $profile['image'] }}" class="rounded" id="imgProfileModal" alt="Image Profile">
      </div>
    </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content overflow-auto">
        <img src="http://192.168.21.1:8021/api/Users/UserImage/{{ $profile['image'] }}" class="rounded" id="imgProfileModal" alt="Image Profile">
      </div>
    </div>
</div>

<div class="modal fade" id="deleteAccountModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Logout" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-dark">
          <h5 class="modal-title text-white" id="staticBackdropLabel">Confirmation?</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p style="font-size: 15px;" class="m-1">Are you sure delete this account?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
          <form action="{{ route('deleteProfile') }}" method="POST">
            @method('delete')
            @csrf
          <button class="btn btn-danger" type="submit">Delete</button>
        </form>
        </div>
      </div>
    </div>
  </div>
@endsection
