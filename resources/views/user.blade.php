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
                        <img src="http://192.168.21.1:8021/api/Users/UserImage/{{ $user['image'] }}" class="rounded" width="100%"  id="imageProfile" alt="Profile Image">
                    </a>
                </div>
            </div>
            <div class="col-md-7">
                <p class="text-hidden" style="font-size: 32px; height: 40px;">{{ $user['name'] }}</p>
                <p class="text-hidden" style="font-size: 24px; height: 30px;">{{ $user['email'] }}</p>
                <div class="p-3"></div>
                <p style="font-size: 18px; height: 24px;">Role : <span class="ms-1">{{ $user['role'] }}</span></p>
                <p class="pt-1" style="font-size: 18px;">Gender : <span class="ms-1">{{ $user['gender'] }}</span></p>
                <p class="mt-2" style="font-size: 18px;">Phone Number : <span class="ms-1">{{ $user['phoneNumber'] }}</span></p>
                <p class="mt-2" style="font-size: 18px;">Date Of Birth : <span class="ms-1">{{ substr($user['dateOfBirth'], 0, 10) }}</span></p>
                <p class="" style="font-size: 18px;">Address : <span class="ms-1">{{ $profile['address'] }}</span></p>
                <div class="pt-1"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imgModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content overflow-auto">
        <img src="http://192.168.21.1:8021/api/Users/UserImage/{{ $user['image'] }}" class="rounded" id="imgProfileModal" alt="Image Profile">
      </div>
    </div>
</div>
@endsection
