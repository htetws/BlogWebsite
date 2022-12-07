@extends('Layout.main')

@section('title','Home')

@section('bookmark')
<div class="d-flex align-items-center">
    <span>Bookmark : </span><span class="BookmarkData badge text-bg-danger active ms-2 rounded-circle mb-1">
        {{ $bookmarks != null ? count($bookmarks) : '0' }}
    </span>
</div>
@endsection

@section('main-header')
<div class="text-center container-fluid p-5 header_div">
    <p class="igris text-primary fw-bolder">igris's</p>
    <p class="title display-6 fw-bold text-white">Blog Page</p>
    <small class="text-white-50">Lorem, ipsum dolor sit amet consectetur adipisicing elit.</small>
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
<!-- Latest -->
<div class="container-fluid mt-5">
    <h4 class="text-center text-muted my-4 latest_post">Latest posts</h4>
    <div class="bg-light">
        <div id="carouselExampleIndicators" class="container carousel carousel-dark slide" data-bs-ride="true">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <div class="carousel-inner">
                @for($i = 0; $i < count($posts) ; $i++) <div class="carousel-item {{ $i == 0 ?  'active' : '' }}">
                    <div class="row p-md-5">
                        <div class="col-12 col-md-7 pe-md-5">
                            <p class="article text-uppercase text-muted mb-4">{{ $posts[$i]->category->name}}</p>

                            <h2 class="pt-1 mb-3">
                                {{ $posts[$i]->title }}
                            </h2>

                            <p class="desc text-muted">
                                {!! Str::words($posts[$i]->description,21,' ...') !!}
                            </p>
                            <div class="pt-md-3">
                                <a href="{{ route('post#detail',$posts[$i]->slug) }}" class="btn btn-dark my-4 rounded-2 seemoreBtn">Read <span class="d-none d-md-inline">More</span></a>
                            </div>
                        </div>
                        <div class="order-first order-md-0 mb-4 mb-md-0 col-12 col-md-5">
                            <img style="width: 100%; height: 18rem; object-fit: cover" src="{{ asset('storage/'.$posts[$i]->image) }}" alt="" />
                        </div>
                    </div>
            </div>
            @endfor
        </div>
    </div>
    </ <!-- Best Rating -->
    <div class="container-fluid my-5">
        <div class="row d-flex justify-content-start align-items-start">
            <div class="col-12 col-md-9">
                <div class="col-12">
                    <div class="rating d-flex justify-content-between">
                        <div class="rating_text">Most Views</div>

                        <div class="col-md-3 d-flex justify-content-end">
                            <a href="{{ route('blog#all') }}" class="text-primary text-decoration-none d-flex align-items-center">
                                <h6 class="view_text">View All<i class="fa-solid fa-cubes ms-2"></i></h6>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row px-md-5 py-md-3">
                    @foreach ($order_view as $view)

                    <a href="{{ route('post#detail',$view->slug) }}" class="col-12 col-md-4 text-decoration-none text-dark overflow-hidden g-5">
                        <img class="img-latest img-thumbnail rounded-3" src="{{ asset('storage/'.$view->image) }}" />
                        <h5 class="mt-4 blogTitle">{{ $view->title }}</h5>

                        <div class="d-flex justify-content-between align-items-center">
                            <small><i class="fa-solid fa-tag me-2"></i>{{ $view->category->name }}</small>
                            <small class="text-muted">{{ $view->created_at->format('d, M') }}</small>
                        </div>

                    </a>
                    @endforeach

                </div>
            </div>

            <!-- Category -->
            <div class="col-12 my-5 my-md-0 col-md-3 catsticky">

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

                <!-- Trending -->
                <h5><i class="fa-solid fa-fire me-2 mt-2 text-danger"></i>Trending</h5>
                <div class="trending">
                    @foreach ($trending as $trend)
                    <a href="{{ route('post#detail',$trend->posts->slug) }}" class="text-decoration-none text-dark">
                        <div class="d-flex justify-content-start align-items-center bg-light shadow-sm mb-3 rounded-1">
                            <img src="{{ asset('storage/'.$trend->posts->image) }}" style="width: 60px;height:60px;object-fit:cover" class="rounded-2">
                            <div class="ms-3">
                                <h6 class="mt-3">{{ $trend->posts->title }}</h6>
                                <small>{!! Str::words($trend->posts->description,4,' ...') !!}</small>
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

@section('footer')
<div class="container-fluid bg-dark text-white">
    <div class="row p-md-5">
        <div class="col-12 col-md">
            <div class="upper p-3 my-5 my-md-3">
                <small class="text-success">no credit card required.</small>
                <h3 class="my-3">Start using Iblog today</h3>
                <div class="row form-group">
                    <div class="col-9 col-md-6">
                        <input type="text" class="form-control form-control-sm rounded-0" placeholder="Your Email" />
                    </div>
                    <div class="col-3 col-md-2">
                        <button class="w-100 btn btn-sm btn-primary rounded-1">
                            send
                        </button>
                    </div>
                </div>
            </div>
            <div class="lower mt-5">
                <div class="row">
                    <div class="col-12 px-4 px-md-3 col-md-8">
                        <h3 class="text-primary">Iblog</h3>
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Iusto libero ullam consectetur nobis autem totam fuga sint.
                        </p>
                    </div>
                    <div class="col-12 d-flex justify-content-evenly d-md-block col-md-4 text-center">
                        <p>About</p>
                        <p>Job</p>
                        <p>Docs</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md text-center">
            <div class="upper">
                <div class="col-12 col-md-4 image text-start">
                    <img class="footer_images w-100" src="https://www.shakebugs.com/wp-content/uploads/2022/06/6-benefits-of-pair-programming-for-your-dev-team.png" alt="" />
                </div>
            </div>
            <div class="lower mt-5">
                <div class="row">
                    <div class="col-12 mx-2 col-md text-start mx-md-5">
                        <p>Teams and Conditions</p>
                        <p>Privacy policy</p>
                        <p>Cookie Policy</p>
                    </div>
                    <div class="col-12 my-4 my-md-0 col-md">
                        <h5>Let's chat!</h5>
                        <small>yamori@mail.com</small>
                        <div class="logo">
                            <span>F</span>
                            <span>G</span>
                            <span>T</span>
                            <span>U</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
