@extends('Layout.dashboard')

@section('title','Admin | Post')

@section('css')
<style>
    .scroll {
        overflow: scroll;
    }

    .scroll::-webkit-scrollbar {
        width: 0px;
    }

    .image {
        width: 90px;
        height: 60px;
        object-fit: cover;
    }

    a {
        text-decoration: none;
    }

    @media (max-width:400px) {
        .image {
            width: 60px;
            height: 50px;
            object-fit: cover;
        }
    }
</style>
@endsection

@section('content')
<div class="col-12 px-3 mt-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6>Posts ...</h6>
        <a href="{{ route('admin#post#create#page') }}" class="btn btn-success btn-sm rounded-1">New Post <i class="fa-solid fa-plus ms-2"></i></a>
    </div>

    <div class="scroll">
        <table class="table table-hover">
            <thead class="bg-dark text-white-50">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col" class="d-none d-md-table-cell">Category</th>
                    <th scope="col" class="d-none d-md-table-cell">Tag</th>
                    <th scope="col" class="d-none d-md-table-cell">Description</th>
                    <th scope="col" class="d-none d-md-table-cell">View Count</th>
                    <th scope="col"><i class="fa-solid fa-gear"></i></th>
                </tr>
            </thead>
            <tbody>
                @if ($posts->total() != 0)
                @foreach ($posts as $post)
                <tr>
                    <th class="id" scope="row">{{$post->id}}</th>
                    <th><img src="{{ asset('storage/'.$post->image) }}" class="image"></th>
                    <th class="name"><small class="">{{ Str::words($post->title,9,'...') }}</small></th>
                    <td class="d-none d-md-table-cell"> @if ($post->category)
                        <small>{{ $post->category->name }}</small>
                        @else
                        <small class="text-muted">no category</small>
                        @endif
                    </td>
                    <td class="col-3 d-none d-md-table-cell">

                        @foreach ($post->tag as $tag)

                        <span class="badge rounded-pill text-bg-secondary"><small>{{ $tag->name }}</small></span>

                        @endforeach

                    </td>
                    <td class="d-none d-md-table-cell"><small>{!! Str::words($post->description,5,'...') !!}</small></td>
                    <td class="d-none d-md-table-cell"><small>{{ $post->view_count == null ? 0 : $post->view_count }}</small></td>
                    <td>

                        <a href="{{ route('admin#post#view',$post->id) }}"><i class="fa solid fa-eye me-1 text-primary text-decoration-none"></i><small class="d-none d-md-block">view</small></a>

                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="8" class="text-center">
                        <div class="text-primary fs-4 my-3"><i class="fa-solid fa-ghost me-3"></i><span>Create your first post .</span></div>
                    </td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end">{{ $posts->links() }}</div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="category_create" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Category Create</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('admin#category#create')}}" method="post">
                @csrf
                <div class="modal-body">
                    <label>Category Name</label>
                    <input type="text" class="form-control my-2 @error('name')
                        is-invalid
                    @enderror" name="name" placeholder="Enter Category Name">
                    @error('name')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Category Edit -->
<div class="modal fade" id="category_edit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Category Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin#category#edit') }}" method="post">
                @csrf
                <div class="modal-body">
                    <label>Category Name</label>
                    <input type="hidden" value="" id="cat_edit_id" name="id">
                    <input type="text" class="form-control my-2 @error('name')
                        is-invalid
                    @enderror" id="category_name_edit" name="name" placeholder="Enter Category Name">
                    @error('name')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Delete Category -->
<div class="modal fade" id="category_delete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title cat_modal"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('admin#category#delete')}}" method="post">
                @csrf
                @method('delete')
                <div class="modal-body">
                    <input type="hidden" value="" name="categoryId" id="cat_id">
                    <h4>Are you sure want to delete ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')

<script>
    $(document).ready(function() {

        $('.deleteBtn').click(function() {
            $parentNode = $(this).parents('tbody tr');
            //using parent node
            $('.cat_modal').text(`${$parentNode.find('.name').text()}`).css({
                'color': 'blue'
            })
            //using data -
            $('#cat_id').val($(this).data('id'));
        })

        $('.editBtn').click(function() {
            $parentNode = $(this).parents('tbody tr');

            $('#cat_edit_id').val($parentNode.find('.id').text());
            $('#category_name_edit').val($parentNode.find('.name').text());
        })

        toastr.options.timeOut = 5000;

        @if(session('created'))
        toastr.success("{{ session('created') }}");

        @elseif(session('deleted'))
        toastr.success("{{ session('deleted') }}");

        @elseif(session('updated'))
        toastr.success("{{ session('updated') }}");

        @endif
    })
</script>

@endsection
