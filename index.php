<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Hangman Game</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
 
    <style>
       
        body {
            background: linear-gradient(45deg, white);
            color: #333;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center; 
            align-items: center;
            min-height: 100vh; 
            margin: 0; 
        }

        .container {
            text-align: center;
        }

        h1, h2 {
            color: #FF6B6B;
            font-family: 'Cursive', cursive;
            -webkit-text-stroke: 1px #333;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 2rem;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 2rem;
        }

        .nav-links {
            margin: 2rem 0;
        }
        .nav-links span {
    font-size: 1.8rem;
}

        .nav-links a {
            font-size: 1.5rem;
            margin: 0 1rem;
            padding: 0.5rem 1rem;
            text-decoration: none;
            background-color: #FF6B6B;
            color: #F8F8F8;
            border-radius: 25px;
        }

        .nav-links a:hover {
            background-color: #FF5733;
        }

        .hangman-image {
            max-width: 70%;
            height: auto;
            mix-blend-mode: multiply; 
        }
       
    </style>
</head>
<body>
    <div class="container">
        <img class="hangman-image" src="images/hangman.jpg" alt="Hangman Image"> 
        <h1 class="display-4">Welcome to </h1>
        <img class="letter-image" src="images/H.png" alt="H">
        <img class="letter-image" src="images/A.png" alt="A">
        <img class="letter-image" src="images/N.png" alt="N">
        <img class="letter-image" src="images/G.png" alt="G">
        <img class="letter-image" src="images/M.png" alt="M">
        <img class="letter-image" src="images/A.png" alt="A">
        <img class="letter-image" src="images/N.png" alt="N">
        <h2>Get ready to play!</h2>
        <div class="nav-links">
            <a href="email_verification.php">Create an Account</a>
            <span>or</span>
            <a href="signin.php">Log In</a>
        </div>
    </div>
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
