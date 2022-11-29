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
<!-- Latest -->
<div class="container mt-5">
    <h4 class="text-center text-muted my-4 latest_post">Latest posts</h4>
    <div class="bg-light">
        <div id="carouselExampleIndicators" class="carousel carousel-dark slide" data-bs-ride="true">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <div class="carousel-inner">

                @foreach ($posts as $post)
                <div class="carousel-item {{ $post->id == 1 ? 'active' : '' }}">
                    <div class="row p-md-5">
                        <div class="col-12 col-md-7 pe-md-5">
                            <p class="article text-uppercase mb-4">{{ $post->category->name }}</p>
                            <h2 class="pt-1 mb-4">
                                {{ $post->title }}
                            </h2>
                            <p class="desc text-muted">
                                {!! Str::words($post->description,20," ...") !!}
                            </p>
                            <button class="btn btn-dark my-4">Read <span class="d-none d-md-inline">More</span></button>
                        </div>
                        <div class="order-first order-md-0 mb-4 mb-md-0 col-12 col-md-5">
                            <img style="width: 100%; height: 18rem; object-fit: cover" src="{{ asset('storage/'.$post->image) }}" alt="" />
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>

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
            <div class="row p-md-5 g-5">
                @foreach ($order_view as $view)

                <a href="#" class="col-12 col-md-4 text-decoration-none text-dark overflow-hidden">
                    <img class="img-latest img-thumbnail rounded-3" src="{{ asset('storage/'.$view->image) }}" />
                    <h5 class="mt-4 blogTitle">{{ $view->title }}</h5>

                    <small><i class="fa-solid fa-tag me-2"></i>{{ $post->category->name }}</small><br>


                </a>

                @endforeach

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
