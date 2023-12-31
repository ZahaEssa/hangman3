<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Hangman</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Inconsolata|Homemade+Apple" rel="stylesheet">
  </head>
  <body>
  <div id="startScreen">

<div class="container-fluid">
    <h1 class="mainTitle">Hangman</h1>

    @if (session()->has('data'))
        <h2 class="session-container">Hello, {{ session('data') }}</h2>
        @php
            // Get the user ID from the session if it's stored there
            $userId = session()->has('gamer_id') ? session('gamer_id') : null;
        @endphp
        <h2>Start Game - Pick a Category</h2>
<div class="button-container">
    <div class="category easy">
        <h2>Easy</h2>
        <button onclick="startGame('Easy', 'Animals');">Animals</button>
        <button onclick="startGame('Easy', 'Fruits');">Fruits</button>
    </div>

    <div class="category medium">
        <h2>Medium</h2>
        <button onclick="startGame('Medium', 'Capital_Cities');">Capital Cities</button>
        <button onclick="startGame('Medium', 'Colors');">Colors</button>
    </div>

    <div class="category hard">
        <h2>Hard</h2>
        <button onclick="startGame('Hard', 'Difficult');">Random Word</button>
    </div>
    <div class="category hard">
        <h2>Progress</h2>
        <a class="progress-link" href="{{ route('progress') }}">View Progress</a>
    </div>
   
</div>
      {{-- logout --}}
      <form method="POST" action="{{ route('logout') }}"class="logout-form-homepage">
        @csrf
        <button type="submit" >Logout</button>
      </form>

    @else
        <div class="session-container">
            <h2>You are not logged in. Please <a href="{{ route('signin') }}">sign in</a> to play Hangman.</h2>
        </div>
        @php
            $userId = null;
        @endphp
    @endif
</div>
<footer>
  &copy; <?php echo date("Y"); ?> Hangman. All rights reserved.
</footer>
</div>

    <div id="helpScreen" style="visibility: hidden;">
      <div class="container">
        <button onclick="helpHide();">Help</button>
        <div class="jumbotron">
          <h1>Rules of the game</h1>
          <p>Guess the word correctly by guessing the letters in the word. You only have a limited number of guesses before you lose the game.</p>
          <p>Easy Difficulty: Win: +10 points | Bonus points: If the word is guessed within 30 seconds, the bonus points awarded are 20 points and if answered any time after 30 seconds no bonus point is awarded | 10 Incorrect Guesses Allowed</p>
          <p>Medium Difficulty: Win: +25 points | Bonus points: If the word is guessed within 45 seconds, the bonus points awarded are 50 points and if answered any time after 45 seconds no bonus point is awarded | 8 Incorrect Guesses Allowed</p>
          <p>Hard Difficulty: Win: +50 points | Bonus points: If the word is guessed within 60 seconds, the bonus points awarded are 70 points and if answered any time after 60 seconds no bonus point is awarded | 6 Incorrect Guesses Allowed</p>
          <p>Restarting the Game will reset all stats</p>

        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-lg-offset-1 col-md-3 col-md-offset-1 hidden-sm hidden-xs visible-md visible-lg visible-xl sectionBorder">
          <div id="scoreboard">


          <div class="row">
              <div class="col-md-6">
                <p>Time Left</p>
              </div>
              <div class="col-md-5 scoreboardScore">
                <p id="timerDisplay">30</p>
              </div>
              <div class="col-md-12">
                <div class="col-md-12">

                  </div>
            <div class="row">
              <div class="col-md-6">
                <p>Score</p>
              </div>
              <div class="col-md-5 scoreboardScore">
                <p id="score">0</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <p>Wins</p>
              </div>
              <div class="col-md-5 scoreboardScore">
                <p id="wins">0</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <p>Losses</p>
              </div>
              <div class="col-md-5 scoreboardScore">
                <p id="losses">0</p>
              </div>
            </div>
            <div class="row">
    <div class="col-md-6">
        <p>Level</p>
    </div>
    <div class="col-md-6">
        <p id="level"></p>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <p>Category</p>
    </div>
    <div class="col-md-6">
        <p id="categoryValue"></p>
    </div>
</div>


            
            <div class="row" style="margin-top: 20px;">
              <div class="col-md-6">
                <p>Chances Left</p>
              </div>
              <div class="col-md-5 scoreboardScore">
                <p id="chancesLeft">10</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <p>Last Guess</p>
              </div>
              <div class="col-md-5 scoreboardScore">
                <p id="lastLetter">-</p>
              </div>
            </div>
         

              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 sectionBorder">
          <div class="row">
            <div class="col-xs-4">
              <h1 class="mainTitle">Hangman</h1>
            </div>
            <div class="col-xs-8">
              <nav class="navbar">
                <div class="container-fluid">
                  <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                      <span class="icon-bar" style="background-color: black"></span>
                      <span class="icon-bar" style="background-color: black"></span>
                      <span class="icon-bar" style="background-color: black"></span>
                    </button>
                  </div>
                  <div class="collapse navbar-collapse" id="navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Category</a>
                        <ul class="dropdown-menu">
                          <li id="easyGame"><a href="#" onclick="changeLevel('Easy','Animals');">Easy-Animals</a></li>
                          <li id="easyGame"><a href="#" onclick="changeLevel('Easy','Fruits');">Easy-Fruits</a></li>


                          <li id="mediumGame"><a href="#" onclick="changeLevel('Medium','Capital_Cities');">Medium-Capital Cities</a></li>
                          <li id="mediumGame"><a href="#" onclick="changeLevel('Medium','Colors');">Medium-Colors</a></li>

                          <li id="hardGame"><a href="#" onclick="changeLevel('Hard','Difficult');">Hard- Random word</a></li>

                        </ul>
                      </li>
                      <li><a class="helpButton" href="#" onclick="help();">Help</a></li>

                      <li><a href="#" onclick="pauseGame();">Pause</a></li>
                    <li><a href="#" onclick="resumeGame();">Resume</a></li>
                    <li><a href="#" onclick="restart();">Restart</a></li>
                    <li><a href="{{ route('progress') }}">View Progress</a>
                    <li><a href="{{route('homepage')}}">Quit</a>

                      <li class="visible-sm visible-xs invisible-md invisible-lg invisible-xl"><p>Score: <span id="scorePhone">0</span></p></li>
                      <li class="visible-sm visible-xs invisible-md invisible-lg invisible-xl"><p>Wins: <span id="winsPhone">0</span></p></li>
                      <li class="visible-sm visible-xs invisible-md invisible-lg invisible-xl"><p>Losses: <span id="lossesPhone">0</span></p></li>
                      <li class="visible-sm visible-xs invisible-md invisible-lg invisible-xl"><p>Level: <span id="levelPhone">Easy</span></p></li>
                      <li class="visible-sm visible-xs invisible-md invisible-lg invisible-xl"><p>Chances Left: <span id="chancesLeftPhone">10</span></p></li>
                      <li class="visible-sm visible-xs invisible-md invisible-lg invisible-xl"><p>Last Guess: <span id="lastLetterPhone">-</span></p></li>
                    </ul>
                  </div>
                </div>
              </nav>
            </div>
          </div>
          <div class="row gameArea">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 hangmanPerson">
              <div class="hanging">
                <img class="bellImg" id="hangman">
              </div>
              <img src="images/hanger.png">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 wordArea">
              <h1 id="wordDisplay"></h1>
            </div>
          </div>
          <div class="row">
            <div id="usedLetters"></div>
          </div>
        </div>
      </div>
    </div>

    <script src="js/words.js"></script>
    <script src="js/javascript.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
    // Pass the user ID to your JavaScript code
    var userId = @json($userId); // This will convert the PHP variable to a JavaScript variable
    console.log("User ID: " + userId);
    var pauseButton = document.getElementById("pauseButton");
    var resumeButton = document.getElementById("resumeButton");
    pauseButton.addEventListener("click", function () {
  if (!isGamePaused) {
    pauseGame(); // Pause the game
    pauseButton.disabled = true; // Disable the "Pause" button
    resumeButton.disabled = false; // Enable the "Resume" button
  }
});

document.addEventListener("keyup", function (event) {
  if (!isGamePaused) { // Check if the game is not paused
    keyPressed(event.key.toUpperCase());
  }
});

function keyPressed(press) {
    if (!isGamePaused) { // Check if the game is not paused
      if (alphabet.includes(press)) {
        checkCurrentWord(press);
        displayScore();
        alphabet[alphabet.indexOf(press)] = 0;
        lastLetter.textContent = press;
      }
    }
  }
</script>


  </body>
</html>