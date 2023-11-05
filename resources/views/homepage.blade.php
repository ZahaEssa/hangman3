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
        <h2>Start Game - Pick a Category</h2>
        <div class="button-container">
        <button onclick="startGame('easy', 'Animals');">Easy - Animals</button>
        <button onclick="startGame('easy', 'Fruits');">Easy - Fruits</button>
        <button onclick="startGame('medium', 'Capital_cities');">Medium - Capital Cities</button>
        <button onclick="startGame('medium', 'Colors');">Medium - Colors</button>
        <button onclick="startGame('hard');">Hard</button>
       </div>
      </div>
    </div>
    <div id="helpScreen">
      <div class="container">
        <button onclick="helpHide();"></button>
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
              <div class="col-md-5">
                <p id="level"></p>
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
                          <li id="easyGame"><a href="#" onclick="changeLevel('easy','Animals');">Easy-Animals</a></li>
                          <li id="easyGame"><a href="#" onclick="changeLevel('easy','Fruits');">Easy-Fruits</a></li


                          <li id="mediumGame"><a href="#" onclick="changeLevel('medium','Capital_cities');">Medium-Capital Cities</a></li>
                          <li id="mediumGame"><a href="#" onclick="changeLevel('medium','Colors');">Medium-Colors</a></li>

                          <li id="hardGame"><a href="#" onclick="changeLevel('hard','FamousNovels');">Hard- famous novels</a></li>

                        </ul>
                      </li>
                      <li><a class="helpButton" href="#" onclick="help();">Help</a></li>

                      <li><a href="#" onclick="pauseGame();">Pause</a></li>
                    <li><a href="#" onclick="resumeGame();">Resume</a></li>
                    <li><a href="#" onclick="restart();">Restart</a></li>

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
    var isGamePaused = false;
    var startTime;
    var timer;
    var timerDuration;
    var savedRemainingTime = 0;

    // Initialize the timer with the initial duration
    function initializeTimer(initialDuration) {
      timerDuration = initialDuration;
      updateTimerDisplay(timerDuration);
      startTimer();
    }

    function startTimer() {
      startTime = Date.now() - (savedRemainingTime * 1000);

      // Clear the existing timer (if any)
      if (timer) {
        clearInterval(timer);
      }

      // Start a new timer
      timer = setInterval(updateTimer, 1000);
    }

    function updateTimer() {
      var elapsedTime = Math.floor((Date.now() - startTime) / 1000);
      var remainingTime = timerDuration - elapsedTime;

      // Ensure that remainingTime doesn't go below 0
      if (remainingTime < 0) {
        remainingTime = 0;
      }

      updateTimerDisplay(remainingTime);

      if (remainingTime <= 0) {
        handleTimeout();
        clearInterval(timer);
      }
    }

    function updateTimerDisplay(time) {
      var timerDisplay = document.getElementById("timerDisplay");
      timerDisplay.textContent = Math.round(time);
    }

    function pauseGame() {
      if (!isGamePaused) {
        isGamePaused = true;
        clearInterval(timer); // Pause the timer
        savedRemainingTime = timerDuration - Math.floor((Date.now() - startTime) / 1000);
        console.log("Game is paused. Saved remaining time: " + savedRemainingTime + " seconds");
      }
    }

    function resumeGame() {
      if (isGamePaused) {
        isGamePaused = false;

        // Calculate the new start time based on the savedRemainingTime
        startTime = Date.now() - (savedRemainingTime * 1000);

        // Restart the timer with the saved remaining time
        startTimer();
      }
    }

    // Initialize the timer with the initial duration
    initializeTimer(120); // Replace 60 with your desired initial timer duration in seconds



    </script>


  </body>
</html>
