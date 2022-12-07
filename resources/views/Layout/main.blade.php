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

    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('USR/css/style.css') }}" />

    <!-- Toastr -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

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
        <nav class="navbar navbar-expand-lg bg-light shadow container-fluid px-md-5">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('post#home') }}"><img src="{{ asset('USR/image/pinpng.com-office-icon-png-2002011.png') }}" class="logo" /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav m-auto text-center gap-lg-5 d-flex align-items-center ">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page" href="{{route('post#home')}}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('blog') ? 'active' : '' }}" href="{{ route('blog#all') }}">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('bookmark') ? 'active' : '' }}" href="{{ route('bookmark#page') }}">@yield('bookmark')</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link disabled">Contact</a>
                        </li> -->

                        @yield('search')

                        <li class="nav-item dropdown ms-md-5">
                            <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-flex justify-content-center align-items-center">
                                    <span class="acc">
                                        @if (Auth::user())
                                        <div class="">
                                            @if (Auth::user()->avatar)
                                            <img src="{{ Auth::user()->avatar }}" style="width:30px;height:30px;object-fit:cover" class="rounded-circle">
                                            @else
                                            <img src="{{ asset('USR/image/free-user-icon-3296-thumb.png') }}" style="width:30px;height:30px;object-fit:cover" class="rounded-circle">
                                            @endif
                                            <small class="ms-2">{{ Auth::user()->name }}</small>
                                        </div>
                                        @else
                                        <i class="fa-solid fa-paw me-2"></i>
                                        <span>Woof</span>
                                        @endif
                                    </span>
                                </div>
                            </a>
                            <ul class="dropdown-menu w-25 m-auto">
                                @if (Auth::user())
                                @if (Auth::user()->role == 'admin')
                                <li><a class="dropdown-item" href="{{route('admin#dashboard')}}"> <i class="fa-solid fa-gauge me-2"></i>Dashboard</a></li>
                                @else
                                <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user me-2"></i>Profile</a></li>
                                @endif

                                <li><a class="dropdown-item" href="#"><i class="fa-solid fa-lock me-2"></i>Password</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li><a class="dropdown-item" href="#" data-bs-target="#logout" data-bs-toggle="modal"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>

                                @else

                                <li><a class="dropdown-item" href="{{route('login#page')}}"><i class="fa-solid fa-user-lock me-2"></i>Login</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li><a class="dropdown-item" href="{{route('register#page')}}"> <i class="fa-solid fa-registered me-2"></i>Register</a></li>

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>

    @yield('js')

    <script>
        $(window).on('load', function() {
            $("#loading").hide();
        });
    </script>

    <script id="dsq-count-scr" src="//i-blog-1.disqus.com/count.js" async></script>
</body>

</html>
