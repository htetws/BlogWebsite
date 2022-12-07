@extends('Layout.main')

@section('title','Blogs')

@section('bookmark')

<div class="d-flex align-items-center">
    <span>Bookmark : </span><span class="BookmarkData badge text-bg-danger active ms-2 rounded-circle mb-1">
        {{ $bookmarks != null ? count($bookmarks) : '0' }}
    </span>
</div>

@endsection

@section('content')
<div class="container-fluid row bg-light mt-4 p-0 m-0 m-auto">
    <div class="col-12 col-sm-12 col-md-12 col-xl-9">
        <div class="input-group mb-5">
            <div class="col-12 bg-white d-flex justify-content-between align-items-center border rounded-3 p-1 overflow-hidden mt-4">

                <form action="{{ route('blog#all') }}" class="d-flex justify-content-between align-items-center w-100">
                    <i class="fa-solid fa-magnifying-glass ms-4"></i>
                    <input id="searchKey" name="s" type="text" value="{{ request('search') }}" class="form-control border-0 mx-3" placeholder="Search blogs, topics and more">
                </form>
                <div style="width:13rem" class="d-flex align-items-center">
                    <i class="fa-solid fa-filter d-none d-md-block"></i>
                    <select name="filter" id="Filter" class="form-select border-0">
                        <option value="" selected class="d-none">Sorting ...</option>
                        <option value="view"> <i class="fa solid fa-tag me-1"></i> Most View</option>
                        <option value="trending">Trending</option>
                        <option value="new">New Post</option>
                        <option value="old">Older Post</option>
                        <option value="az">A - Z</option>
                        <option value="za">Z - A</option>
                    </select>
                </div>
            </div>

            <div class="row mx-auto w-100" id="DIV" style="margin-top: 2.1rem;">
                @if ($posts->total()!=0)
                @foreach ($posts as $post)
                <a href="{{ route('post#detail',$post->slug) }}" class="col-12 col-sm-6 col-md-3 text-decoration-none text-dark hover mb-5">
                    <img loading="lazy" decoding="async" src="{{ asset('storage/'.$post->image) }}" class="img-fluid rounded-3" style="width:100%;height:14rem;object-fit:cover">
                    <h5 class="mt-3 fst-italic">{{ $post->title }}</h5>
                    <div class="d-flex justify-content-between align-items-center text-muted mx-1">
                        <small> <i class="fa solid fa-tag me-1"></i> {{ $post->category->name }}</small>
                        <small>{{ $post->created_at->format('d, M') }}</small>
                    </div>
                </a>
                @endforeach
                <div class="d-flex justify-content-end">{{ $posts->links() }}</div>
                @else
                <div class="text-center">
                    <img src="https://stories.freepiklabs.com/storage/18539/no-data-pana-1440.png" style="width:300px;height:300px;object-fit:cover">
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12 my-5 col-sm-12 col-md-12 col-xl-3 my-md-0 col-md-3 px-4 px-md-5 stickyDiv">

        <div class="mb-4 mt-4">
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
    //live search by ajax...
    $(document).on('keyup', '#searchKey', function() {
        $input = $(this).val();
        //after 0.5s,call ajax.
        setTimeout(function() {
            if ($input != '') {
                $.get('ajax/search', {
                    'input': $input
                }, function(data) {
                    $div = '';
                    $M = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    if (data.length != 0) {
                        for ($i = 0; $i < data.length; $i++) {

                            $date = new Date(data[$i].created_at).getDate();
                            $month = $M[new Date(data[$i].created_at).getMonth()];

                            $div += `<a href="{{ url('p/${data[$i].slug}') }}" class="col-12 col-sm-6 col-md-3 text-decoration-none text-dark hover mb-5">
                            <img src="{{ asset('storage/${data[$i].image}') }}" alt="" class="img-fluid rounded-3" style="width:100%;height:14rem;object-fit:cover">
                            <h5 class="mt-3 fst-italic">${data[$i].title}</h5>
                            <div class="d-flex justify-content-between align-items-center text-muted mx-1">
                                <small><i class="fa solid fa-tag me-1"></i>${data[$i].catname}</small>
                                <small>${$date}, ${$month}</small>
                            </div>
                            </a>`;
                        }
                    } else {
                        $div = `<div class="text-center">
                            <img src="https://stories.freepiklabs.com/storage/18539/no-data-pana-1440.png" style="width:300px;height:300px;object-fit:cover">
                            </div>`
                    }

                    $('#DIV').html($div);
                })
            } else {
                $.get('ajax/search', {
                    'input': $input
                }, function(data) {
                    $div = '';
                    $M = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    if (data.length != 0) {
                        for ($i = 0; $i < data.length; $i++) {

                            $date = new Date(data[$i].created_at).getDate();
                            $month = $M[new Date(data[$i].created_at).getMonth()];


                            $div += `<a href="{{ url('p/${data[$i].slug}') }}" class="col-12 col-md-3 text-decoration-none text-dark hover mb-5">
                            <img src="{{ asset('storage/${data[$i].image}') }}" alt="" class="img-fluid rounded-3" style="height:14rem;object-fit:cover">
                            <h5 class="mt-3 fst-italic">${data[$i].title}</h5>
                            <div class="d-flex justify-content-between align-items-center text-muted mx-1">
                                <small><i class="fa solid fa-tag me-1"></i>${data[$i].catname}</small>
                                <small>${$date}, ${$month}</small>
                            </div>
                            </a>`;
                        }
                    } else {
                        $div = `<div class="text-center">
                            <img src="https://stories.freepiklabs.com/storage/18539/no-data-pana-1440.png" style="width:300px;height:300px;object-fit:cover">
                            </div>`
                    }

                    $('#DIV').html($div);
                })
            }
        }, 500)
    });

    //filter by ajax
    $(document).on('change', '#Filter', function() {
        $value = $(this).val();
        if ($value) {
            $.get("{{ route('sort#ajax') }}", {
                'value': $value
            }, function(data) {
                console.log(data);
                $div = '';
                $M = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                if (data.length != 0) {
                    for ($i = 0; $i < data.length; $i++) {

                        $date = new Date(data[$i].created_at).getDate();
                        $month = $M[new Date(data[$i].created_at).getMonth()];

                        $div += `<a href="{{ url('p/${data[$i].slug}') }}" class="col-12 col-sm-6 col-md-3 text-decoration-none text-dark hover mb-5">
                            <img src="{{ asset('storage/${data[$i].image}') }}" alt="" class="img-fluid rounded-3" style="width:100%;height:14rem;object-fit:cover">
                            <h5 class="mt-3 fst-italic">${data[$i].title}</h5>
                            <div class="d-flex justify-content-between align-items-center text-muted mx-1">
                                <small><i class="fa solid fa-tag me-1"></i>${data[$i].catname}</small>
                                <small>${$date}, ${$month}</small>
                            </div>
                            </a>`;
                    }
                } else {
                    $div = `<div class="text-center">
                            <img src="https://stories.freepiklabs.com/storage/18539/no-data-pana-1440.png" style="width:300px;height:300px;object-fit:cover">
                            </div>`
                }

                $('#DIV').html($div);
            })
        }
    });
</script>
@endsection
