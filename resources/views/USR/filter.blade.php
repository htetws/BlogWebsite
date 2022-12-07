@extends('Layout.main')

@section('title', "Filter")

@section('bookmark')
<div class="d-flex align-items-center">
    <span>Bookmark : </span><span class="BookmarkData badge text-bg-danger active ms-2 rounded-circle mb-1">
        {{ $bookmarks != null ? count($bookmarks) : '0' }}
    </span>
</div>
@endsection

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
<div class="container-fluid my-3 my-md-5 px-md-5">
    <div class="row d-flex justify-content-start align-items-start">



        <div class="col-12 col-md-12 col-xl-9">
            <div class="col-12">
                <div class="rating d-flex justify-content-between align-items-center">
                    <div class="rating_text mb-2"><small>Filter by {{ ucfirst(...(collect(request()->segments()[0]))) }} : ( {{ ucfirst(str_replace('%20',' ',basename(request()->path()))) }} )</small> </div>
                    <div class="col-md-3 d-flex justify-content-end">
                        <a href="{{ route('blog#all') }}" class="text-primary text-decoration-none d-flex align-items-center">
                            <h6 class="view_text">View All<i class="fa-solid fa-cubes ms-2"></i></h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row p-md-5 g-5">
                @if ($posts->total() != 0)

                @foreach ($posts as $view)

                <a href="{{ route('post#detail',$view->slug) }}" class="col-12 col-md-4 text-decoration-none text-dark overflow-hidden">
                    <img class="img-latest img-thumbnail rounded-3" src="{{ asset('storage/'.$view->image) }}" />
                    <h5 class="mt-4 blogTitle">{{ $view->title }}</h5>

                    <small><i class="fa-solid fa-tag me-2"></i>{{ $view->category->name }}</small><br>


                </a>

                @endforeach

                @else
                <div class="text-center">
                    <img src="https://stories.freepiklabs.com/storage/18539/no-data-pana-1440.png" style="width:300px;height:300px;object-fit:cover">
                </div>
                @endif


            </div>
        </div>


        <!-- Category -->
        <div class="col-12 my-5 my-md-0 col-md-12 col-xl-3 px-4 px-md-5 right-div">

            <div class="mb-4">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item ">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <i class="fa-solid fa-tag me-3"></i>Categories
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body text-center">
                                @foreach ($categories as $cat)
                                <a href="{{ route('category#search',$cat->slug) }}" class="badge text-bg-primary shadow-sm active rounded-pill text-decoration-none my-2">{{ $cat->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h5><i class="fa-solid fa-fire me-2 mt-2 text-danger"></i>Trending</h5>
            <div class="trending">
                @foreach ($posts as $trending)
                <a href="{{ route('post#detail',$trending->slug) }}" class="text-decoration-none text-dark">
                    <div class="d-flex justify-content-start align-items-center bg-light shadow-sm mb-3 rounded-1">
                        <img src="{{ asset('storage/'.$trending->image) }}" style="width: 60px;height:60px;object-fit:cover" class="rounded-2">
                        <div class="ms-3">
                            <h6 class="mt-3">{{ $trending->title }}</h6>
                            <small>{!! Str::words($trending->description,4,' ...') !!}</small>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <hr class="text-secondary mt-4">
            <div class="overflow-auto text-center my-4 tag_overflow">
                <i class="fa solid fa-tags"></i> :
                @foreach ($tags as $tag)
                <a href="{{ route('tag#search',$tag->slug) }}" class="badge text-bg-light shadow-sm me-1 text-decoration-none mb-1"><span>{{ $tag->name }}</span></a>
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
