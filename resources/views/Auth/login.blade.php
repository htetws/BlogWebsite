<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        .form-control:focus {
            box-shadow: none;
        }

        .image {
            width: 45%;
        }

        .belowDiv {
            margin-top: 5rem;
        }

        @media (max-width:550px) {
            a {
                width: 100%;
            }

            .image {
                width: 90%;
            }
        }
    </style>
</head>

<div class="container fixed-top">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('login#page') }}">Login</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('post#home') }}">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('blog#all') }}">Blog</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('register#page') }}">Register</a>
        </li>
    </ul>
</div>

<body>
    <div class="container belowDiv p-3 p-md-5">
        <div class="row d-flex align-items-center justify-content-around">

            <div class="col-6 mt-md-5 col-md-12 text-center col-lg-6">
                <img src="{{ asset('undraw_unlock_re_a558.svg') }}" class="image">
            </div>

            <div class="col-12 offset-sm-0 col-md-12 col-lg-4">
                <h3 class="text-muted d-none d-md-block">Login</h3>
                <form action="{{ route('login') }}" method="post" class="mt-4">
                    @csrf
                    <div class="form-group mt-3">
                        <label class="mb-2">Email</label>
                        <input type="email" name="email" class="form-control rounded-0 @error('email') is-invalid
                        @enderror" placeholder="Enter Email" value="{{old('email')}}">
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label class="mb-2">Password</label>
                        <input type="password" name="password" class="form-control rounded-0 @error('password') is-invalid
                        @enderror" placeholder="Enter Password">
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-md-flex align-items-center justify-content-between mt-4 text-center">
                        <input type="submit" class="btn btn-dark rounded-0 col-12 col-md-3 mb-3 mb-md-0" value="Login">
                        <span class="">You don't have account ? <a href="{{ route('register#page') }}" class=" text-decoration-none">Register Here .</a></span>
                    </div>

                    <div class="bg-light col-12 d-md-flex justify-content-between">
                        <a href="{{ route('login#google') }}" class="btn btn-danger mt-4 rounded-0"><i class="fa-brands fa-google me-4 me-md-3"></i>Login with google</a>
                        <a href="{{ route('login#github') }}" class="btn btn-secondary mt-4 rounded-0"><i class="fa-brands fa-github me-4 me-md-3"></i>Login with github</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
