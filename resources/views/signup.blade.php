<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Signup Form</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Your+Selected+Font&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/signup_css.css') }}">

    <style>
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <img src="../images/index/thumbsUp.png" alt="Image" class="left-image">

                        <h1 class="card-title">Create your Hangman Account!</h1>
                        <h3>Already have an account? <a href="{{ route('signin') }}">Log in here</a>.<h3>
                    </div>
                    <div class="card-body">

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <h4 class="text-center">You're almost there! Complete your registration to start playing!</h4>

                        <form method="POST" action="{{ route('updateUser', ['gamer_id' => $gamer_id]) }}">
                            @csrf

                            <div class="form-group">
                                <label for="gamer_username">Username</label>
                                <input type="text" class="form-control" id="gamer_username" placeholder="Please enter your username" name="gamer_username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Please enter your password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirmpass">Password Confirmation</label>
                                <input type="password" class="form-control" id="confirmpass" placeholder="Please enter your password again" name="password_confirmation" required>
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" name="registrationBtn" class="btn btn-primary btn-block">Sign Up</button>
                            </div>
                        </form>
                        <p class="text-bottom">
                            By clicking on the Sign Up button, you agree to our<br />
                            <a href="#">Terms and Conditions</a> and <a href="#">Policy And Privacy</a>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
