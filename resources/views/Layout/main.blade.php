<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap css -->
    <link rel="stylesheet" href="{{asset('USR/node_modules/bootstrap/dist/css/bootstrap.min.css')}}" />

    <!-- fav icon -->
    <link rel="shortcut icon" href="{{asset('USR/image/pinpng.com-office-icon-png-2002011.png')}}" type="image/x-icon" />

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- image hover -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/imagehover.css/2.0.0/css/imagehover.min.css" integrity="sha512-SYBBAnJsPEzSQ/kBqkR/9krJ+EUgF624c8uaMBww1Q26pnCw5k7zVmtc48BfXjZ9MRNNBveIdhx/na1xRLWgjw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('USR/css/style.css') }}" />

    <title>@yield('title')</title>
</head>

<body>

    <div id="loading">
        <div class="spinner-grow text-primary" role="status"></div>
        <small class="ms-2 mt-3">Wait a second ...</small>
    </div>

    <div class="container-fluid">
        <!-- Main Header -->

        @yield('main-header')

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-light container-fluid px-5">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('post#home') }}"><img src="{{ asset('USR/image/pinpng.com-office-icon-png-2002011.png') }}" class="logo" /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav m-auto text-center gap-lg-5">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page" href="{{route('post#home')}}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('blog') ? 'active' : '' }}" href="{{ route('blog#all') }}">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link disabled">Contact</a>
                        </li> -->

                        @yield('search')

                        <li class="nav-item dropdown ms-md-5">
                            <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-flex justify-content-center align-items-center">
                                    <i class="fa-solid fa-right-to-bracket me-2"></i><span class="acc">
                                        @if (Auth::user())
                                        <small>{{ Auth::user()->name }}</small>
                                        @else
                                        Account
                                        @endif
                                    </span>
                                </div>
                            </a>
                            <ul class="dropdown-menu w-25 m-auto">

                                @if (Auth::user())


                                @if (Auth::user()->role == 'admin')
                                <li><a class="dropdown-item" href="{{route('admin#dashboard')}}">Dashboard</a></li>
                                @else
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                @endif


                                <li><a class="dropdown-item" href="#">Change Password</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li><a class="dropdown-item" href="#" data-bs-target="#logout" data-bs-toggle="modal">Logout</a></li>

                                @else

                                <li><a class="dropdown-item" href="{{route('login#page')}}">Login</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li><a class="dropdown-item" href="{{route('register#page')}}">Register</a></li>

                                @endif
                            </ul>
                        </li>
                    </ul>

                    <!-- duplicate ul -->
                </div>
            </div>
        </nav>

        @yield('content')

        <!-- Footer -->
        @yield('footer')

    </div>

    <!-- Modal -->
    @yield('modal')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('USR/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    @yield('js')

    <script>
        $(window).on('load', function() {
            $("#loading").hide();
        });
    </script>

</body>

</html>
