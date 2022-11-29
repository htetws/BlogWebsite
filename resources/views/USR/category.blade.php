@extends('Layout.main')

@section('search')
<li class="nav-item d-none d-lg-block">
    <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
        <button class="btn btn-sm btn-primary rounded-1" type="submit">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </form>
</li>
@endsection

@section('content')

<!-- Best Rating -->
<div class="container my-5">
    <div class="row d-flex justify-content-start align-items-start">
        <div class="col-12 col-md-9">
            <div class="col-12">
                <div class="rating d-flex justify-content-between">
                    <div class="rating_text">Top Views</div>

                    <div class="col-md-3 d-flex justify-content-between">
                        <div class="select mb-1 me-4">
                            <select name="sorting" class="form-select form-select-sm">
                                <option value="" style="display:none" selected>Sorting ... </option>
                                <option value="view">Most View</option>
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>
                            </select>
                        </div>
                        <a href="#" class="text-primary text-decoration-none d-flex align-items-center">
                            <span class="view_text">View All</span><i class="fa-solid fa-cubes ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row p-md-5 g-4 mt-3 mt-md-0">
                @if ($posts->total() != 0)
                @foreach ($posts as $post)

                <a href="#" class="col-12 col-md-4 text-decoration-none text-dark overflow-hidden">
                    <img class="img-latest img-thumbnail rounded-3" src="{{ asset('storage/'.$post->image) }}" />
                    <h5 class="mt-4 blogTitle">{{ $post->title }}</h5>

                    <small><i class="fa-solid fa-tag me-2"></i>{{ $post->category->name }}</small><br>
                </a>

                @endforeach
                @else

                <div class="text-center"><img src="https://stories.freepiklabs.com/storage/18377/no-data-rafiki-1356.png" alt="" style="width: 300px;height:300px;object-fit:cover"></div>

                @endif

            </div>
        </div>

        <!-- Category -->
        <div class="col-12 my-5 my-md-0 col-md-3 px-5">
            <div class="bg-light">
                <h4 class="text-center my-3">Category Filter</h4>
                <hr />
                <ol class="category ms-3 px-5 py-2 lh-lg text-dark">

                    @foreach ($categories as $cat)
                    <li id="cat_a"><a href="{{ route('category#search',$cat->slug) }}" class="text-decoration-none text-dark">{{ $cat->name }}</a></li>
                    @endforeach

                </ol>
            </div>

            <div class="mt-5 tag">
                @foreach ($tags as $tag)
                <a href="{{ route('tag#search',$tag->slug) }}" class="me-2 text-muted"><small> <i class="fa-solid fa-hashtag me-1"></i>{{ $tag->name }} </small>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection

@section('modal')
<div class="modal fade" id="logout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm Logout</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure want to logout ?
            </div>
            <form action="{{route('logout')}}" method="post">
                <div class="modal-footer">

                    @csrf
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Logout</button>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
