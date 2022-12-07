@extends('Layout.dashboard')

@section('title','Admin | Dashboard')

@section('css')
<style>
    .dashboardImage {
        width: 70%;
        margin-top: 4rem;
    }
</style>
@endsection

@section('content')
<div class="col-12 px-3 px-md-0 col-md-8 offset-md-2 mt-5 text-center">

    <div class="">
        <img src="{{ asset('undraw_maintenance_re_59vn.svg') }}" class="dashboardImage">
    </div>

    <h4 class="display-6 mt-5">Dashboard page under maintenance.</h4>

    <!-- <table class="table table-hover">
        <thead class="bg-dark text-white-50">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Slug</th>
                <th scope="col"><i class="fa-solid fa-gear"></i></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Web Development</td>
                <td>web-development</td>
                <td><i class="fa-regular fa-pen-to-square me-2 text-primary"></i>
                    <i class="fa-regular fa-circle-xmark text-danger"></i>
                </td>
            </tr>
        </tbody>
    </table> -->
</div>
@endsection
