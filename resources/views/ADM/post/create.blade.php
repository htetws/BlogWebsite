@extends('Layout.dashboard')

@section('title','Admin | Post Create')

@section('css')

<style>
    .form-control:focus {
        box-shadow: none !important;
    }

    .form-select:focus {
        box-shadow: none !important;
    }

    .ck-editor__editable {
        min-height: 250px;
    }
</style>

@section('content')
<div class="col-12 px-3 mt-5 test">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin#post#list') }}" class="btn btn-dark btn-sm"><i class="fa-solid fa-circle-left me-2"></i>Back</a>
    </div>

    <div class="col-12 col-md-10 offset-md-1 shadow-sm bg-light rounded-3">
        <form action="{{ route('admin#post#create') }}" class="row py-4 px-3 px-md-5 py-md-3" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-12 col-md p-md-3">

                <div class="form-group mt-1">
                    <label class="mb-2">Title</label>
                    <input type="text" name="postTitle" class="form-control form-control-sm @error('postTitle') is-invalid @enderror" placeholder="Enter post title" value="{{ old('postTitle') }}">
                    @error('postTitle')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label class="mb-2">Category</label>
                    <select name="categoryId" class="form-select form-select-sm @error('categoryId') is-invalid @enderror">
                        <option value="" selected class="d-none">Choose one category.</option>

                        @foreach ($categories as $category)
                        <option value="{{$category->id}}" {{ old('categoryId') == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                        @endforeach

                    </select>
                    @error('categoryId')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label class="mb-2">Image</label>
                    <input type="file" name="postImage" class="form-control form-control-sm @error('postImage') is-invalid @enderror">
                    @error('postImage')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="my-4">
                    @foreach ($tags as $tag)
                    <input class="form-check-input" type="checkbox" name="postTag[]" value="{{$tag->id}}" id="{{$tag->id}}" {{ is_array(old('postTag')) && in_array($tag->id,old('postTag')) ? 'checked' : '' }}>
                    <small class="me-3 ms-1 text-muted">{{ $tag->name }}</small>
                    @endforeach
                </div>



            </div>
            <div class="col-12 col-md-6 p-md-3 mt-3 mt-md-0">

                <div class="form-group">
                    <label class="mb-2">Description</label>
                    <textarea id="editor" class="form-control form-control-sm @error('postDesc') is-invalid @enderror" name="postDesc" cols="30" rows="9" placeholder="Enter post description"> {{ old('postDesc') }} </textarea>
                    @error('postDesc')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-5 text-end">
                    <input type="submit" class="btn btn-dark btn-sm">
                </div>
            </div>
        </form>

    </div>

</div>

@endsection

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/classic/ckeditor.js"></script>

<script>
    ClassicEditor

        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>

@endsection
