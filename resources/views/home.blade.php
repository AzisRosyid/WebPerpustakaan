@extends('layouts.main')

@section('content')

<div class="card mt-6">
    <div class="card-body" style="font-size: 16px;">
      Web Perpustakaan Laravel with ASP.Net Core .NET 6 API by Azis Rosyid
    </div>
    @if( $profile['name']??'' != '' )
    <div class="card-body">
        <p>Welcome : {{ $profile['name'] }}</p>
    </div>
    @endif
</div>

@endsection


