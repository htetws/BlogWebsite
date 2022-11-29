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
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-4 mt-5">
                <h3 class="my-5">Register Form</h3>
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control rounded-0 @error('name') is-invalid
                        @enderror" placeholder="Enter Name" value="{{old('name')}}">
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control rounded-0 @error('email') is-invalid
                        @enderror" placeholder="Enter Email" value="{{old('email')}}">
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control rounded-0 @error('password') is-invalid
                        @enderror" placeholder="Enter Password">
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label>password Confirmation</label>
                        <input type="password" name="password_confirmation" class="form-control rounded-0 @error('password_confirmation') is-invalid
                        @enderror" placeholder="Enter Password">
                        @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <input type="submit" class="btn btn-dark rounded-0 mt-4" value="Register">
                </form>
            </div>
        </div>
    </div>
</body>

</html>
