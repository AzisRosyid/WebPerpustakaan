@extends('layouts.main')

@section('content')
<div class="row">
    <div class="card card-body">
        <div class="row">
            <div class="col-md-5">
                <div class="text-center">
                    <a data-bs-toggle="modal" data-bs-target="#imageModal">
                    <img src="http://192.168.21.1:8021/api/Books/ImageBook/{{ $book['image'] }}" class="rounded" width="100%"  id="imgProfile" alt="Book Image">
                    </a>
                </div>
            </div>
            <div class="col-md-7">
                <p class="text-hidden" style="font-size: 32px; height: 40px;">{{ $book['title'] }}</p>
                <p class="text-hidden" style="font-size: 24px; height: 30px;">{{ $book['author'] }}</p>
                <div class="p-3"></div>
                <p class="text-hidden" style="font-size: 18px; height: 24px;">By {{ $book['publisher'] }}</p>
                <p class="pt-1" style="font-size: 18px;">Category : @if ($book['category']['id'] != null)
                    <a class="btn btn-success ms-2" @if($fav??false) href="{{ route('favorite') }}?c={{ $book['category']['id'] }}" @else href="{{ route('books') }}?c={{ $book['category']['id'] }}" @endif>{{ $book['category']['name'] }} </a>
                @endif </p>
                <div class="row">
                    <div class="col-md-2 pt-1" style="font-size: 18px; width: 85px;">Genre :</div>
                    <div class="col-md-10">
                        <div class="row row-cols-auto">
                        @foreach ($book['genres'] as $st)
                            <a @if($fav??false) href="{{ route('favorite') }}?g%5B%5D={{ $st['id'] }}" @else href="{{ route('books') }}?g%5B%5D={{ $st['id'] }}" @endif class="btn btn-primary text-white m-1">{{ $st['name'] }}</a>
                        @endforeach
                        </div>
                    </div>
                </div>
                <p class="mt-2" style="font-size: 18px;">Pages : <span class="ms-1">{{ $book['page'] }}</span></p>
                <p class="" style="font-size: 18px;">Views : <span class="ms-1">{{ $book['viewCount'] }}</span></p>
                <form action="{{ route('downloadBook') }}" method="POST" target="_blank">
                    @csrf
                    <div class="d-grid gap-2" style="padding-top: 20px;">
                        <input type="text" name="name" value="{{ $book['title'] }}" style="display: none;">
                        <input type="text" name="download" value="{{ $book['download'] }}" style="display: none;">
                        <button class="btn btn-dark mt-6" type="submit" value="Submit">Download PDF</button>
                    </div>
                </form>
                <div class="pt-1"></div>
                @if($auth)
                <input type="text" name="id" value="{{ $book['id'] }}" style="display: none;">
                <div class="d-grid gap-2">
                    @if($favorite)
                    <button href="{{ route('favorite', ['id' => $book['id']]) }}" id="btnFavorite" class="btn btn-danger mt-6" type="submit" value="Submit">Delete Favorite</button>
                    @else
                    <button href="{{ route('favorite', ['id' => $book['id']]) }}" id="btnFavorite" class="btn btn-primary mt-6" type="submit" value="Submit">Favorite</button>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row pt-1 bg-light text-center">
    <div class="card card-body bg-dark text-white" style="font-size: 18px;">
        Book Description
    </div>
    <div class="card card-body" style="font-size: 16px;">
       <p class="text-justify">{{ $book['description'] }}</p>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content overflow-auto">
        <img src="http://192.168.21.1:8021/api/Books/ImageBook/{{ $book['image'] }}" class="rounded" id="imgProfile" alt="Book Image">
      </div>
    </div>
  </div>

  <script>
      const favoriteUrl = `{{ route('favorite') }}`;
      const favoriteBook = `{{ $book['id'] }}`;
      const token = `{{ Session::token() }}`;
  </script>
@endsection
