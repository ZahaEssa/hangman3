<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/signin_css.css') }}">


    <style>
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="image-container">
                <img src="images/index/heart.jpg" alt="Image" class="right-image">
            </div>
            <h1>Login to your Hangman account</h1>
            <h3 class="text-center">Welcome back! Please sign-in to play</h3>
            <form method="POST" action="{{ route('signin') }}" autocomplete="off">
                @csrf 
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="gamer_username" placeholder="Username" required>
                </div>
                <div class ="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password" id="password" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="Signin" value="Sign In" class="btn btn-primary">
                </div>
            </form>
            <p class="text-center">Don't have an account? <a href="/email_Verification">Sign Up Here</a></p>
            <p class="text-bottom">Forgot your password? <a href="#">Reset Password</a></p>
        </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
