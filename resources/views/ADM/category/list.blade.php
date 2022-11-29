@extends('Layout.dashboard')

@section('title','Admin | Category')

@section('content')
<div class="col-12 px-3 px-md-0 col-md-8 offset-md-2 mt-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6>Categories ...</h6>
        <button type="button" data-bs-target="#category_create" data-bs-toggle="modal" class="btn btn-success btn-sm rounded-1">New Category <i class="fa-solid fa-plus ms-2"></i></button>
    </div>

    <table class="table table-hover">
        <thead class="bg-dark text-white-50">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Slug</th>
                <th scope="col"><i class="fa-solid fa-gear"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <th class="id" scope="row">{{$category->id}}</th>
                <td class="name">{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>

                    <a href="#" class="editBtn " data-bs-target="#category_edit" data-bs-toggle="modal"><i class="fa-regular fa-pen-to-square me-2 text-primary"></i></a>

                    <a href="#" class="deleteBtn " data-bs-target="#category_delete" data-bs-toggle="modal" data-id="{{ $category->id }}">
                        <i class="fa-regular fa-circle-xmark text-danger"></i>
                    </a>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-end">{{ $categories->links() }}</div>
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

        @if(session('success'))
        toastr.success("{{ session('success') }}");

        @elseif(session('deleted'))
        toastr.success("{{ session('deleted') }}");

        @elseif(session('updated'))
        toastr.success("{{ session('updated') }}");

        @endif
    })
</script>

@endsection
