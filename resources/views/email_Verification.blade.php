<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/email_Ver_css.css') }}">
    <style>
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
            <h2>Email Verification</h2>
    </div>
            <div class="card-body">
                    <img src="images/index/happy.jpg" alt="Image" class="image-blend">
                <p class="text-center">
                A verification email will be sent to your provided email address. Please click the verification link in the email to activate your account and complete the registration process.
            </p>
            @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
            @endif
                <form action="{{ route('send-email') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="fullname">Full Name:</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required>
                    </div>
                    <div class="form-group">
                        <label for= "email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" value="Send" name="send" class="btn btn-primary">
                    </div>
                </form>
                <p class="text-center">Already have an account? <a href="/signin">Sign In Here</a></p>
            </div>
        </div>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
