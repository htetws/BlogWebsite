<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{asset('USR/image/pinpng.com-office-icon-png-2002011.png')}}" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

    @yield('css')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bungee&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .DivLeft {
            color: white;
            position: relative;
            top: 30px;
            text-align: center;
        }

        .category {
            text-decoration: none;
            font-size: 1.2rem;
            color: inherit;
        }

        .linkdiv {
            padding: .6rem;
            margin: 1.2rem 0px 1.2rem 0rem;
            padding-left: 2.4rem;
        }

        .linkdiv:hover {
            background-color: #141414;
            border-radius: 8px;
        }

        .linkdiv:active {
            background-color: #000;
            border-radius: 8px;
        }

        .activebtn {
            background-color: #000;
            border-radius: 8px;
        }

        .navimage {
            width: 20%;
            object-fit: cover;
        }

        .textblog {
            font-family: 'Bungee', cursive;
        }

        @media (max-width:500px) {
            .dropdown-menu {
                width: 56%;
            }
        }

        .navbar {
            z-index: 10;
        }

        #loading {
            position: fixed;
            width: 100%;
            height: 100vh;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 20;
        }
    </style>
</head>

<body>
    <div id="loading">
        <div class="spinner-border text-primary" role="status"></div>
        <small class="ms-2 mt-3">Wait a second ...</small>
    </div>

    <div class="container-fluid" style="height: 100vh;">
        <div class="row position-relative">

            <!-- Left Div -->
            <div class="leftdiv d-none d-md-block bg-dark col-md-2 position-fixed vh-100">

                <div class="DivLeft text-start">
                    <a href="{{route('post#home')}}" class="d-flex justify-content-evenly align-items-center bg-dark text-decoration-none text-white">

                        <img class="navimage" src="{{asset('USR/image/pinpng.com-office-icon-png-2002011.png')}}" alt="">

                        <h4 class="mt-2 textblog">iblog ...</h4>

                    </a>
                    <hr>

                    <a href="{{route('admin#dashboard')}}" class="text-white category">
                        <div class="linkdiv mt-4 {{ request()->is('admin/dashboard') ? 'activebtn' : '' }}"><i class="fa-solid fa-gauge me-3"></i>Dashboard</div>
                    </a>

                    <a href="{{route('admin#category')}}" class="text-white category">
                        <div class="linkdiv {{ request()->is('admin/category/list') ? 'activebtn' : '' }}"><i class="fa-solid fa-tag me-3"></i>Category</div>
                    </a>

                    <a href="{{route('admin#tag')}}" class="text-white category">
                        <div class="linkdiv {{ request()->is('admin/tag/list') ? 'activebtn' : '' }}">
                            <i class="fa-solid fa-tags me-3"></i>Tags
                        </div>
                    </a>

                    <a href="{{route('admin#post#list')}}" class="text-white category">
                        <div class="linkdiv {{ request()->is('admin/post/list') ? 'activebtn' : '' }}"><i class="fa-brands fa-blogger-b me-3"></i></i>Post</div>
                    </a>

                </div>

                <div class="text-white position-fixed bottom-0 mb-3 ms-3">
                    <small class="text-secondary">powered by igris.(version 1.1)</small>
                </div>
            </div>


            <!-- Right Div -->
            <div class="col-12 px-0 col-md-10 offset-md-2 overflow-auto">

                <nav class="navbar navbar-expand-lg bg-dark navbar-dark sticky-top">
                    <div class="container-fluid">
                        <a data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" class="text-white w-25 d-md-none fs-2"><i class="fa-solid fa-gear"></i></a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">

                            <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                                <!-- <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#">Blog Page</a>
                                </li> -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-regular fa-user me-2"></i>
                                        {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu m-auto">
                                        <li><a class="dropdown-item" href="#"><i class="fa-regular fa-address-card me-3"></i>Profile</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-unlock me-3"></i>Change Password</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="#" data-bs-target="#logout" data-bs-toggle="modal"><i class="fa-solid fa-arrow-right-from-bracket me-3"></i>Logout</a></li>
                                    </ul>
                                </li>



                            </ul>

                            <form class="my-3 m-md-0 d-flex mx-2 mx-md-0 me-md-5" role="search">
                                <input class="form-control form-control-md-sm rounded-1 me-2" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn btn-md-sm btn-primary" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </form>

                        </div>
                    </div>
                </nav>

                @yield('content')

            </div>
        </div>
    </div>


    <!-- Modal -->
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

    <!-- Offcanvas -->
    <div class="offcanvas offcanvas-start text-bg-dark w-75" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
        <div class="offcanvas-header">
            <h6 class="offcanvas-title" id="staticBackdropLabel">Power by igris</h6>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <div class="DivLeft text-start">
                    <div class="d-flex justify-content-between align-items-center bg-dark">

                        <a href="{{ route('post#home') }}" class="d-flex align-items-center justify-items-center text-decoration-none text-white">
                            <img class="navimage" src="{{asset('USR/image/pinpng.com-office-icon-png-2002011.png')}}" alt="">

                            <h4 class="textblog ms-3 mt-3">iblog</h4>
                        </a>

                        <div class="mt-1 fs-2"> <a href="#" class="text-white"><i class="fa-regular fa-thumbs-up"></i></a>
                        </div>
                    </div>
                    <hr>

                    <a href="{{route('admin#dashboard')}}" class="text-white category">
                        <div class="linkdiv mt-4 {{ request()->is('admin/dashboard') ? 'activebtn' : '' }}"><i class="fa-solid fa-gauge me-3"></i>Dashboard</div>
                    </a>

                    <a href="{{route('admin#category')}}" class="text-white category">
                        <div class="linkdiv {{ request()->is('admin/category/list') ? 'activebtn' : '' }}"><i class="fa-solid fa-tag me-3"></i>Category</div>
                    </a>

                    <a href="{{route('admin#tag')}}" class="text-white category">
                        <div class="linkdiv {{ request()->is('admin/tag/list') ? 'activebtn' : '' }}">
                            <i class="fa-solid fa-tags me-3"></i>Tags
                        </div>
                    </a>

                    <a href="{{route('admin#post#list')}}" class="text-white category">
                        <div class="linkdiv {{ request()->is('admin/post/list') ? 'activebtn' : '' }}"><i class="fa-brands fa-blogger-b me-3"></i></i>Post</div>
                    </a>

                </div>
                <div class="text-white position-fixed bottom-0 mb-3 ms-3">
                    <small class="text-secondary">powered by igris.(version 1.1)</small>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>

    @yield('js')

    <script>
        $(window).on('load', function() {
            $('#loading').hide();
        })
    </script>
</body>



</html>
