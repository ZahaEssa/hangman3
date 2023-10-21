<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-size: cover;
            text-align: left;
            color: #000;
        }

        h1 {
            font-size: 36px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        h3 {
            font-size: 20px;
            color: salmon;
            font-style: italic;
            font-family: 'Arial', sans-serif;
        }

        .container {
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid #000;
            border-radius: 10px;
            padding: 15px;
            margin: 0 auto;
            max-width: 650px;
            text-align: center;
        }

        .card {
            border: 1px solid #000;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-group {
            margin: 10px 0;
            text-align: center;
        }

        .form-control {
            border: 2px solid black;
            border-radius: 5px;
            font-size: 18px;
            background: transparent;
            color: #000;
            width: 100%;
            max-width: 400px; 
        }

        .form-control::placeholder {
            color: #ccc;
        }

        .btn-primary {
            background: linear-gradient(to bottom, #FF5746, #FF6F61);
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 20px;
            color: white;
            width: 100%;
        }

        .btn-primary:hover {
            background: linear-gradient(to bottom, #FF6F61, #FF5746);
            color: black;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            text-align: left;
        }

        .right-image {
            max-width: 100%;
            height: auto;
            object-fit: cover;
            mix-blend-mode: multiply; 
        }

        .image-container {
            width: 30%;
            display: flex;
            justify-content: center; 
            align-items: center; 
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
        <div class="card">
            <div class="image-container">
                <img src="images/heart.jpg" alt="Image" class="right-image">
            </div>
            <h1>Login to your Hangman account</h1>
            <h3 class="text-center">Welcome back! Please sign-in to play</h3>
            <form action="processes/signinprocess.php" method="POST" autocomplete="off">
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
            <p class="text-center">Don't have an account? <a href="email_verification.php">Sign Up Here</a></p>
            <p class="text-bottom">Forgot your password? <a href="#">Reset Password</a></p>
        </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"></script>
</body>
</html>
