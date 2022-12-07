<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        .form-control:focus {
            box-shadow: none;
        }

        .belowDiv {
            margin-top: 5rem;
        }
    </style>
</head>

<body>

    <div class="container fixed-top">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('register#page') }}">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('post#home') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('blog#all') }}">Blog</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login#page') }}">Login</a>
            </li>
        </ul>
    </div>


    <div class="container belowDiv p-3 p-md-5">
        <div class="row d-flex align-items-center justify-content-around">

            <div class="col-6 mt-md-5 col-md-12 text-center col-lg-6">
                <img src="{{ asset('undraw_access_account_re_8spm.svg') }}" style="width:100%;object-fit:cover">
            </div>

            <div class="col-12 offset-sm-0 col-md-12 col-lg-4">
                <h3 class="my-4 text-muted d-none d-md-block">Register</h3>
                <form action="{{ route('register') }}" method="post" class="mt-5 mt-md-4">
                    @csrf
                    <div class="form-group">
                        <label class="mb-2">Name</label>
                        <input type="text" name="name" class="form-control rounded-0 @error('name') is-invalid
                        @enderror" placeholder="Enter Name" value="{{old('name')}}">
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
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
                    <div class="form-group mt-3">
                        <label class="mb-2">password Confirmation</label>
                        <input type="password" name="password_confirmation" class="form-control rounded-0 @error('password_confirmation') is-invalid
                        @enderror" placeholder="Enter Password">
                        @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-md-flex align-items-center justify-content-between mt-4 text-center">
                        <input type="submit" class="btn btn-dark rounded-0 col-12 col-md-3 mb-3 mb-md-0" value="Register">
                        <span class="">You have already account ? <a href="{{ route('login#page') }}" class=" text-decoration-none">Login Here .</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
