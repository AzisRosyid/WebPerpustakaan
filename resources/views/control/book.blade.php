@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-body bg-dark text-white" style="font-size: 28px;">
            @if($cr??false) Create Book @elseif($ed??false) Edit Book @endif
        </div>
    </div>
    @if(isset($bookErrors))
    <div class="col pt-1">
        <div class="alert alert-danger" role="alert">
            Errors : {{ $bookErrors }}
        </div>
    </div>
    <div class="col-md-12" style="margin-top: -12px;">
    @else
    <div class="col-md-12 pt-1">
    @endif
        <div class="card card-body">
            <form @if($my??false) @if($cr??false) action="{{ route('storeBook') }}" @elseif($ed??false) action="{{ route('updateBook', ['id' => $book['id']??'']) }}" @endif @elseif($ab??false) @if($cr??false) action="{{ route('adminStoreBook') }}" @elseif($ed??false) action="{{ route('adminUpdateBook', ['id' => $book['id']??'']) }}" @endif @endif method="POST" enctype="multipart/form-data">
                @if($ed??false)
                @method('put')
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-floating m-2">
                            <input type="text" name="title" class="form-control bg-white" id="title" placeholder="Title" value="{{ $book['title']??'' }}" required>
                            <label for="title">Title</label>
                        </div>
                        <div class="form-floating m-2">
                            <input type="text" name="author" class="form-control bg-white" id="author" placeholder="Author" value="{{ $book['author']??'' }}" required>
                            <label for="author">Author</label>
                        </div>
                        @if($ab??false)
                        <div class="m-2">
                            <div class="input-group">
                                <button class="btn btn-dark text-white" id="btn-user" type="button" data-bs-toggle="modal" data-bs-target="#userModal">Select User</button>
                                <input type="text" style="display: none;" id="userId" name="userId" value="{{ $book['userId']??$book['user']['id']??'' }}" readonly>
                                <input type="text" style="display: none;" name="userName" id="userName" value="{{ $book['user']['name']??$book['userName']??'Click to Select User' }}" readonly>
                                <label class="card card-body user-select" id="userLabel" for="btn-user">{{ $book['user']['name']??$book['userName']??'Click to Select User' }}</label>
                            </div>
                        </div>
                        @endif
                        <div class="form-floating m-2">
                            <input type="text" name="publisher" class="form-control bg-white" id="publisher" placeholder="Publisher" value="{{ $book['publisher']??'' }}">
                            <label for="publisher">Publisher</label>
                        </div>
                        <div class="form-floating m-2">
                            <input type="number" min="1" name="page" class="form-control bg-white" id="page" placeholder="Page" value="{{ $book['page']??'' }}" required>
                            <label for="page">Page</label>
                        </div>
                        <div class="form-floating m-2">
                            <select class="form-select bg-white" name="category" id="category" aria-label="Select Category">
                              <option value="">--</option>
                              @foreach ($c as $st)
                              <option value="{{ $st['id'] }}" @if($category??'' == $st['id']) selected @endif>{{ $st['name'] }}</option>
                              @endforeach
                            </select>
                            <label for="category">Category</label>
                        </div>
                        <div class="accordion m-2 bg-white" id="accordionGenres">
                            <div class="accordion-item bg-white">
                              <h2 class="accordion-header bg-white" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genresCollapse" aria-expanded="false" aria-controls="Accordion Genres">
                                  Genres List
                                </button>
                              </h2>
                              <div id="genresCollapse" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionGenres">
                                <div class="accordion-body">
                                    <div class="row row-cols-auto">
                                        @foreach ($g as $st)
                                        <div class="col m-1">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" value="{{ $st['id'] }}" id="genres{{ $st['id'] }}" name="genre[]" @if (in_array($st['id'], $genre??[]))
                                                    checked
                                                @endif>
                                                <label class="form-check-label" for="genres{{ $st['id'] }}">{{ $st['name'] }}</label>
                                            </div>
                                        </div>
                                         @endforeach
                                    </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="form-floating m-2">
                            <textarea class="form-control bg-white" placeholder="Description" name="description" id="description" style="height: 200px" required>{{ $book['description']??'' }}</textarea>
                            <label for="description">Description</label>
                        </div>
                        <div class="m-2">
                            <label for="image" class="form-label">Upload Image Book</label>
                            <input class="form-control bg-white" type="file" name="image" accept="image/png, image/jpg, image/jpeg" id="image" placeholder="Select Image">
                        </div>
                        <div class="m-2">
                            <label for="download" class="form-label">Upload PDF</label>
                            <input class="form-control bg-white" type="file" name="download" accept="application/pdf" id="download" placeholder="Select PDF" @if($cr??false) required @endif >
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
                            <a class="btn btn-danger" href="{{ $url??'' }}">Cancel</a>
                        </div>
                        <div class="text-center img-profile">
                            <label class="form-label" for="imgProfile">Image Book</label>
                            <a data-bs-toggle="modal" data-bs-target="#imageModal">
                                <img @if($book['image']??null != null) src="http://192.168.21.1:8021/api/Books/ImageBook/{{ $book['image'] }}" @else src="{{ asset('img/nopick.png') }}"  @endif class="rounded" width="100%"  id="imgProfile" alt="Profile Image">
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
        <img @if($book['image']??null != null) src="http://192.168.21.1:8021/api/Books/ImageBook/{{ $book['image'] }}" @else src="{{ asset('img/nopick.png') }}" @endif  class="rounded" id="imgProfileModal" alt="Image Profile">
      </div>
    </div>
</div>

<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModal" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
      <div class="modal-content" style="background: transparent; overflow: auto;">
        <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
            <div class="container-fluid">
                <div>
                    <span class="navbar-brand fs-4 ps-2 align-middle">Select User</span>
                </div>
                <input class="form-control search-modal input-search me-2" type="search" placeholder="Search User..." aria-label="Search" name="s" id="searchUserModal">
                {{-- <form class="d-flex navbar-form navbar-center me-auto">
                    <input class="form-control input-search me-2" type="search" aria-label="Search" name="s" autofocus>
                    <button class="btn btn-outline-light" type="submit">Search</button>
                  </form> --}}
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
