@extends('Layout.dashboard')

@section('title','Admin | Post View')

@section('css')

<style>
    .image {
        width: 100%;
        height: 440px;
        object-fit: cover;
    }

    .Up {
        position: fixed;
        right: 10;
        bottom: 10;
        min-width: 40px;
        min-height: 40px;
    }

    @media (max-width:450px) {
        .image {
            width: 100%;
            height: 210px;
            object-fit: cover;
        }
    }
</style>

@section('content')
<div class="col-12 px-3 mt-5 test">

    <div class="d-flex justify-content-between px-md-4 align-items-center mb-3">
        <a href="{{ route('admin#post#list') }}" class="btn btn-dark btn-sm"><i class="fa-solid fa-circle-left me-2"></i>Back</a>

        <a href="{{ route('admin#post#edit#page',$post->id) }}" class="btn btn-primary active btn-sm"><i class="fa-solid fa-edit me-2"></i>Edit</a>
    </div>

    <div class="col-12 col-md-10 offset-md-1 shadow-sm rounded-1 shadow">
        <img src="{{asset('storage/'.$post->image)}}" class="image">
        <h3 class="text-center my-3">{{ $post->title }}</h3>

        <p class="text-muted text-center"><i class="fa-solid fa-tag me-2"></i> {{ $post->category->name }}</p>

        <div class="text-center">
            @foreach ($post->tag as $tag)
            <span class="badge text-bg-dark rounded-1">{{ $tag->name }}</span>
            @endforeach
        </div>

        <div class="px-2 mt-4">
            <p>{!! $post->description !!}</p>
        </div>


        <a href="#" class="d-flex align-items-center btn btn-dark rounded-circle" id="button"><i class="fa-solid fa-arrow-up"></i></a>

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
</script>
@endsection
