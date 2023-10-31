<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-size: cover;
            text-align: center;
            color: #000; 
        }

        h2 {
            font-size: 36px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .container {
            background: rgba(0, 0, 0, 0.6);
            border-radius: 15px;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto; 
        }

        .card {
            border: 1px solid #000;
            border-radius: 10px;
        }

        .image-blend {
            mix-blend-mode: multiply; 
            width: 200px;
            height: auto;
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
            color:black;
        }

        .form-group label {
            font-weight: bold;
        }

        .text-center {
            color: salmon;
            font-size: 16px;
        }
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
