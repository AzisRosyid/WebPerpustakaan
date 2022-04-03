@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-body bg-dark text-white" style="font-size: 28px;">
            Register Perpustakaan
        </div>
    </div>
    @if(isset($registerErrors))
    <div class="col pt-1">
        <div class="alert alert-danger" role="alert">
            Errors : {{ $registerErrors }}
        </div>
    </div>
    <div class="col-md-12" style="margin-top: -12px;">
    @else
    <div class="col-md-12 pt-1">
    @endif
        <div class="card card-body">
            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-floating m-2">
                            <input type="text" name="name" class="form-control bg-white" id="name" placeholder="Name" value="{{ $request->name??'' }}" required>
                            <label for="name">Name</label>
                        </div>
                        <div class="form-floating m-2">
                            <input type="email" name="email" class="form-control bg-white" id="email" placeholder="name@example.com" value="{{ $request->email??'' }}" required>
                            <label for="email">Email Address</label>
                        </div>
                        <div class="form-floating m-2">
                            <input type="password" name="password" class="form-control bg-white" id="password" placeholder="Password" minlength="8" value="{{ $request->password??'' }}">
                            <label for="password">Password</label>
                        </div>
                        <div class="form-floating m-2">
                            <select class="form-select bg-white" name="gender" id="gender" aria-label="Select Gender" required>
                              <option value="">--</option>
                              <option value="Male" @if ($request->gender??'' === "Male")
                              selected
                              @endif>Male</option>
                              <option value="Female" @if ($request->gender??'' === "Female")
                                selected
                                @endif>Female</option>
                            </select>
                            <label for="gender">Gender</label>
                        </div>
                        <div class="form-floating m-2">
                            <input type="date" name="dateOfBirth" class="form-control bg-white" id="dateOfBirth" placeholder="DateOfBirth" value="{{ $request->dateOfBirth??'' }}" required>
                            <label for="dateOfBirth">Date Of Birth</label>
                        </div>
                        <div class="form-floating m-2">
                            <input type="tel" name="phoneNumber" pattern="[0-9]{8,13}" class="form-control bg-white" id="phoneNumber" placeholder="PhoneNumber" value="{{ $request->phoneNumber??'' }}" required>
                            <label for="phoneNumber">Phone Number</label>
                        </div>
                        <div class="form-floating m-2">
                            <textarea class="form-control bg-white" placeholder="Address" name="address" id="address" style="height: 100px" required>{{ $request->address??'' }}</textarea>
                            <label for="address">Address</label>
                        </div>
                        <div class="m-2">
                            <label for="image" class="form-label">Upload Image Profile</label>
                            <input class="form-control bg-white" type="file" name="image" accept="image/png, image/jpg, image/jpeg" id="image" placeholder="Select Image">
                          </div>
                    </div>
                    <div class="col-md-4 register-panel">
                        <div class="d-grid gap-2 m-2">
                            <button class="btn btn-success" type="submit" value="Submit">Register</button>
                            <a class="btn btn-danger" href="{{ route('home') }}">Cancel</a>
                        </div>
                        <div class="text-center img-profile">
                            <label class="form-label" for="imgProfile">Image Profile</label>
                            <a data-bs-toggle="modal" data-bs-target="#imageModal">
                                <img src="{{ asset('img/nopick.png') }}" class="rounded" width="100%"  id="imgProfile" alt="Profile Image">
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
        <img src="{{ asset('img/nopick.png') }}" class="rounded" id="imgProfileModal" alt="Image Profile">
      </div>
    </div>
</div>
@endsection
