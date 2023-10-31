<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Signup Form</title>
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Your+Selected+Font&display=swap" rel="stylesheet">

    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-size: cover;
            text-align: center;
            color: #000;
        }

        h1 {
            font-size: 36px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            text-align: left;
        }

        h3 {
            font-size: 20px;
            color: salmon;
            font-style: italic;
            font-family: 'Arial', sans-serif;
            text-align: left;
        }

        .container {
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid #000;
            border-radius: 10px;
            padding: 20px;
            margin: 0 auto;
            max-width: 1070px;
            text-align: center;
        }

        .card-header {
    font-size: 28px; 
    font-family: 'Your Selected Font', sans-serif;
}
        .card {
            border: 1px solid #000;
            border-radius: 10px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-control {
            border: 2px solid black;
            border-radius: 5px;
            font-size: 18px;
            background: transparent;
            color: #000;
        }

        .form-control::placeholder {
            color: #ccc;
        }

        .btn-primary {
            background: linear-gradient(to bottom, #FF5746, #FF6F61);
            border: none;
            border-radius: 5px;
            padding: 15px 20px;
            font-size: 20px;
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(to bottom, #FF6F61, #FF5746);
            color: black;
        }

        .form-group label {
            font-weight: bold;
        }

        .left-image {
            float: left;
            width: 25%;
            mix-blend-mode: multiply;
        }

        .text-center {
            color: salmon;
            font-size: 19px;
        }

        .text-bottom {
            color: black;
            font-size: 17px;
        }
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
