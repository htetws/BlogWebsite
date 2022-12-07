@extends('Layout.main')

@section('title', "$post->title" )

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
<!-- Best Rating -->
<div class="container-fluid my-3 my-md-5 px-md-5">
    <div class="row d-flex justify-content-start align-items-start">
        <div class="col-12 col-sm-12 col-md-12 col-xl-9 px-md-5 position-relative">

            <div class="position-relative">
                <img src="{{asset('storage/'.$post->image)}}" class="image1">
                <img src="{{asset('storage/'.$post->image)}}" class="image0">

                @if($save != null)
                <i id="bookmarkBTN" class="fa-solid fa-bookmark bookmark" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-content="Added to Bookmark"></i>
                @else
                <i id="bookmarkBTN" class="fa-regular fa-bookmark bookmark" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-content="Add to Bookmark"></i>
                @endif
            </div>

            <h3 class="text-center mt-3 mb-3">{{ $post->title }}</h3>

            <div class="text-center">
                @foreach ($post->tag as $tag)
                <a href="{{ route('tag#search',$tag->slug) }}" class="badge text-bg-dark opacity-75 rounded-1 text-decoration-none rounded-pill">{{ $tag->name }}</a>
                @endforeach
            </div>

            <div class="d-flex justify-content-between mt-4 mt-md-3 align-items-center mx-2">
                <span class="text-muted"><i class="fa-solid fa-tag me-2"></i> {{ $post->category->name }}</span>
                <div class="d-flex align-items-center">
                    @if($love == null)
                    <i id="saveBTN" class="fa-regular fa-heart fs-3"></i>
                    @else
                    <i id="saveBTN" class="fa-solid fa-heart fs-3 text-danger"></i>
                    @endif
                    <span class="fs-5 ms-2 ms-md-3" id="loveCount"> {{ count($loves) }} </span>
                </div>
            </div>

            <hr class="mx-2 mt-1">

            <div class="px-2 mt-4">
                <p>{!! $post->description !!}</p>

                <div class="row mt-5 opacity-80">
                    <small class="col-12 col-md-6 text-muted"><i class="fa solid fa-user me-2"></i>Published by <a href="{{ route('user#search',$post->users->name) }}" class="text-decoration-none">{{ $post->users->name }}</a></small>
                    <small class="col-12 col-md-6 text-secondary text-start mt-3 mt-md-0 text-md-end"><i class="fa solid fa-clock me-2 text-secondary"></i>{{ $post->created_at->format('d M, Y') }}</small>
                </div>
            </div>


            <a href="#" class="d-none d-flex align-items-center justify-content-center btn btn-primary rounded-circle" id="button"><i class="fa-solid fa-arrow-up"></i></a>
            <hr>

            <!-- Prev Next -->
            <div class="position-relative d-flex justify-content-between align-items-center mt-5 mb-4 mx-2 mx-md-0">

                @if ($prev)
                <a href="{{ $prev != null ? route('post#detail',$prev->slug) : '#' }}" class="routeBtn btn btn-dark opacity-75 btn-sm text-decoration-none rounded-pill"><i class="fa-solid fa-circle-chevron-left me-2"></i>Previous</a>
                @endif

                @if ($next)
                <a href="{{ $next != null ? route('post#detail',$next->slug) : '#' }}" class="routeBtn1 btn btn-dark opacity-75 btn-sm text-decoration-none rounded-pill"> Next <i class="fa-solid fa-circle-chevron-right ms-2"></i></a>
                @endif
            </div>

            <!-- Disqus -->
            <div id="disqus_thread" style="margin-top: 5rem;"></div>

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

            <h6><i class="fa-regular fa-folder-open text-secondary me-2"></i></i> Related .</h5>
                <div class="trending">
                    @foreach ($rels as $rel)
                    <a href="{{ route('post#detail',$rel->slug) }}" class="text-decoration-none text-dark">
                        <div class="d-flex justify-content-start align-items-center bg-light shadow-sm mb-3 rounded-1">
                            <img src="{{ asset('storage/'.$rel->image) }}" style="width: 60px;height:60px;object-fit:cover" class="rounded-2">
                            <div class="ms-3">
                                <h6 class="mt-3">{{ $rel->title }}</h6>
                                <small>{!! Str::words($rel->description,4,' ...') !!}</small>
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
            document.getElementById('button').classList.remove('d-none');
        } else {
            document.getElementById('button').classList.add('d-none');
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

    //Bookmark
    $(document).on('click', '#bookmarkBTN', function() {
        if ($(this).hasClass('fa-regular fa-bookmark bookmark')) {
            $(this).removeClass();
            $(this).addClass('fa-solid fa-bookmark bookmark');

            //ajax add
            $.post("{{route('view#bookmark')}}", {
                'slug': $(location).attr('pathname').slice(3),
                'status': 'save',
                _token: "{{ csrf_token() }}"
            }, function(data) {
                if (data) {
                    toastr.options = {
                        "progressBar": true,
                        "timeOut": 2200
                    }
                    toastr.remove();
                    toastr.success("added to bookmark");
                    $('.BookmarkData').text(data.length);
                }
            });
        } else {
            $(this).removeClass();
            $(this).addClass('fa-regular fa-bookmark bookmark');
            //ajax remove
            $.post("{{route('view#bookmark')}}", {
                'slug': $(location).attr('pathname').slice(3),
                'status': 'remove',
                _token: "{{ csrf_token() }}"
            }, function(data) {
                if (data) {
                    toastr.options = {
                        "progressBar": true,
                        "timeOut": 2200
                    }
                    toastr.remove();
                    toastr.info("removed from bookmark");
                    $('.BookmarkData').text(data.length);
                }
            });
        }
    })

    $(document).on('click', '#saveBTN', function() {
        if ($(this).hasClass('fa-regular fa-heart')) {
            $(this).removeClass();
            $(this).addClass('fa-solid fa-heart text-danger fs-3')
            //ajax call
            $.post("{{route('ajax#love')}}", {
                'slug': $(location).attr('pathname').slice(3),
                'status': 'save',
                _token: "{{ csrf_token() }}"
            }, function(data) {
                $('#loveCount').text(data.length);
            });
        } else {
            $(this).removeClass('fa-solid fa-heart');
            $(this).addClass('fa-regular fa-heart fs-3')
            //ajax remove
            $.post("{{route('ajax#love')}}", {
                'slug': $(location).attr('pathname').slice(3),
                'status': 'remove',
                _token: "{{ csrf_token() }}"
            }, function(data) {
                $('#loveCount').text(data.length);
            });
        }
    })

    //popover
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
</script>

<script>
    (function() {
        var d = document,
            s = d.createElement('script');
        s.src = 'https://i-blog-1.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
    })();
</script>
@endsection
