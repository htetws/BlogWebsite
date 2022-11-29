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

    <title>Blog | Website</title>
</head>

<body>
    <div class="container-fluid">
        <!-- Main Header -->
        <div class="text-center container-fluid p-5 header_div">
            <p class="igris text-primary fw-bolder">igris's</p>
            <p class="title display-6 fw-bold text-white">Blog Page</p>
            <small class="text-white-50">Lorem, ipsum dolor sit amet consectetur adipisicing elit.</small>
        </div>

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-light container-fluid px-5">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img src="{{ asset('USR/image/pinpng.com-office-icon-png-2002011.png') }}" class="logo" /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav m-auto text-center gap-lg-5">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('post#home')}}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled">Contact</a>
                        </li>

                        @yield('search')

                        <li class="nav-item dropdown ms-md-5">
                            <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-flex justify-content-center align-items-center">
                                    <i class="fa-solid fa-right-to-bracket me-2"></i><span class="acc">
                                        @if (Auth::user())
                                        {{ Auth::user()->name }}
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
        <div class="container-fluid bg-dark text-white">
            <div class="row p-md-5">
                <div class="col-12 col-md">
                    <div class="upper p-3 my-5 my-md-3">
                        <small class="text-success">no credit card required.</small>
                        <h3 class="my-3">Start using Iblog today</h3>
                        <div class="row form-group">
                            <div class="col-9 col-md-6">
                                <input type="text" class="form-control form-control-sm rounded-0" placeholder="Your Email" />
                            </div>
                            <div class="col-3 col-md-2">
                                <button class="w-100 btn btn-sm btn-primary rounded-1">
                                    send
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="lower mt-5">
                        <div class="row">
                            <div class="col-12 px-4 px-md-3 col-md-8">
                                <h3 class="text-primary">Iblog</h3>
                                <p>
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                    Iusto libero ullam consectetur nobis autem totam fuga sint.
                                </p>
                            </div>
                            <div class="col-12 d-flex justify-content-evenly d-md-block col-md-4 text-center">
                                <p>About</p>
                                <p>Job</p>
                                <p>Docs</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md text-center">
                    <div class="upper">
                        <div class="col-12 col-md-4 image text-start">
                            <img class="footer_images w-100" src="https://www.shakebugs.com/wp-content/uploads/2022/06/6-benefits-of-pair-programming-for-your-dev-team.png" alt="" />
                        </div>
                    </div>
                    <div class="lower mt-5">
                        <div class="row">
                            <div class="col-12 mx-2 col-md text-start mx-md-5">
                                <p>Teams and Conditions</p>
                                <p>Privacy policy</p>
                                <p>Cookie Policy</p>
                            </div>
                            <div class="col-12 my-4 my-md-0 col-md">
                                <h5>Let's chat!</h5>
                                <small>yamori@mail.com</small>
                                <div class="logo">
                                    <span>F</span>
                                    <span>G</span>
                                    <span>T</span>
                                    <span>U</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @yield('modal')

    <script src="{{ asset('USR/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
