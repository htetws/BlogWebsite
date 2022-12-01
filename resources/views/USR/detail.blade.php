@extends('Layout.main')

@section('')

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
<!-- Best Rating -->
<div class="container-fluid my-3 my-md-5 px-md-5">
    <div class="row d-flex justify-content-start align-items-start">
        <div class="col-12 col-sm-12 col-md-12 col-xl-9 px-md-5">

            <div class="position-relative">
                <img src="{{asset('storage/'.$post->image)}}" class="image1">
                <img src="{{asset('storage/'.$post->image)}}" class="image0 ">
            </div>

            <h3 class="text-center my-3">{{ $post->title }}</h3>

            <p class="text-muted text-center"><i class="fa-solid fa-tag me-2"></i> {{ $post->category->name }}</p>

            <div class="text-center">
                @foreach ($post->tag as $tag)
                <a href="{{ route('tag#search',$tag->slug) }}" class="badge text-bg-dark opacity-75 rounded-1 text-decoration-none rounded-pill">{{ $tag->name }}</a>
                @endforeach
            </div>
            <hr class="mx-2">
            <div class="px-2 mt-4">
                <p>{!! $post->description !!}</p>

                <div class="text-end">
                    <i class="fa solid fa-clock me-2 text-secondary"></i>
                    <span class="text-secondary">Created At {{ $post->created_at->format('d M, Y') }}</span>
                </div>
            </div>


            <a href="#" class="d-flex align-items-center justify-content-center btn btn-primary rounded-circle" id="button"><i class="fa-solid fa-arrow-up"></i></a>
            <hr>
            <div class="position-relative d-flex justify-content-between align-items-center mt-5 mb-4 mx-2 mx-md-0">

                @if ($prev)
                <a href="{{ $prev != null ? route('post#detail',$prev->slug) : '#' }}" class="routeBtn btn btn-dark opacity-75 btn-sm text-decoration-none rounded-pill"><i class="fa-solid fa-circle-chevron-left me-2"></i>Previous</a>
                @endif

                @if ($next)
                <a href="{{ $next != null ? route('post#detail',$next->slug) : '#' }}" class="routeBtn1 btn btn-dark opacity-75 btn-sm text-decoration-none rounded-pill"> Next <i class="fa-solid fa-circle-chevron-right ms-2"></i></a>
                @endif

            </div>
        </div>

        <!-- Category -->
        <div class="col-12 my-5 col-sm-12 col-md-12 col-xl-3 my-md-0 col-md-3 px-4 px-md-5 right-div">

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
                @foreach ($posts as $view)
                <a href="{{ route('post#detail',$view->slug) }}" class="text-decoration-none text-dark">
                    <div class="d-flex justify-content-start align-items-center bg-light shadow-sm mb-3 rounded-1">
                        <img src="{{ asset('storage/'.$view->image) }}" style="width: 60px;height:60px;object-fit:cover" class="rounded-2">
                        <div class="ms-3">
                            <h6 class="mt-3">{{ $view->title }}</h6>
                            <small>{!! Str::words($view->description,4,' ...') !!}</small>
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


@section('js')
<script>
    document.onscroll = () => {
        if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
            document.getElementById('button').classList.add('Up');
        } else {
            document.getElementById('button').classList.remove('Up');
        }
    }

    //View Count
    $(document).ready(function() {
        $slug = $(location).attr('pathname').slice(3);
        $.post("{{ route('view#count') }}", {
            'slug': $slug,
            _token: "{{ csrf_token() }}"
        }, function(data) {
            // console.log(data);
        })
    })
</script>
@endsection
