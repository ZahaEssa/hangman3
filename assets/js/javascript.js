var alphabet = "abcdefghijklmnopqrstuvwxyz".toUpperCase().split('');
var alphabetDisplay = "";

var hangmanGame = {
  numWins: 0,
  numLosses: 0,
  totalScore: 0,
  
  pointValue: {
    easy: 10,
    medium: 25,
    hard: 50,
  },

  
}

var timer;
var timerDuration;

var timer; // Declare a timer variable

var remainingTime; // Remove this line
var startTime; // Add this line
function handleTimeout() {
  alphabet = [];
  hangmanGame.numLosses++;
  document.getElementById("wordDisplay").innerHTML = "<p>" + hangmanGame.currentWord + "</p> <h4>Time's up! You Lose...New Game starting soon...";
  setTimeout(function () {
    displayNewWord();
  }, 3000);
}

function startTimer() {
  clearInterval(timer);
  var timerDisplay = document.getElementById("timerDisplay");
  
  startTime = Date.now(); // Store the current timestamp as the start time
  remainingTime = timerDuration; // Set the remainingTime here
  timerDisplay.textContent = remainingTime;

  timer = setInterval(function () {
    var elapsedTime = Math.floor((Date.now() - startTime) / 1000); // Calculate elapsed time in seconds
    remainingTime = timerDuration - elapsedTime; // Calculate remaining time
    if (remainingTime >= 0) {
      timerDisplay.textContent = remainingTime;
    } else {
      clearInterval(timer);
      handleTimeout();
    }
  }, 1000);
}



function startGame(chosenLevel, chosenCategory) {
  hangmanGame.gameLevel = chosenLevel;
  hangmanGame.currentCategory = chosenCategory; // Set the chosen category
  if (chosenLevel === "easy") {
    timerDuration = 120; // Set the timer duration for the easy level (30 seconds)
  } else if (chosenLevel === "medium") {
    timerDuration = 180; // Set the timer duration for the medium level (45 seconds)
  } else {
    timerDuration = 300; // Set the timer duration for the hard level (60 seconds)
  }
  gameStart();
}


for (var i = 0; i < alphabet.length; i++) {
  alphabetDisplay = alphabetDisplay + ' <button id="' + alphabet[i] + '" onclick=keyPressed("' + alphabet[i] + '");>' + alphabet[i] + "</button>";
}
document.getElementById("usedLetters").innerHTML = alphabetDisplay;
alphabet = [];

document.onkeyup = function (event) {
  keyPressed(event.key.toUpperCase());
}

function keyPressed(press) {
  if (alphabet.includes(press)) {
    checkCurrentWord(press);
    displayScore();
    alphabet[alphabet.indexOf(press)] = 0;
    lastLetter.textContent = press;
  }
}

function checkCurrentWord(press) {
  var correct = false;
  for (var i = 0; i < hangmanGame.currentWordArray.length; i++) {
    if (hangmanGame.currentWordArray[i] === press) {
      hangmanGame.guesses.push(press);
      correct = true;
      document.getElementById(press).style.textShadow = "0 0 1.5vh rgba(14,181,53,0.5)";
    }
  }
  if (!correct) {
    hangmanGame.mistakes++;
    hangmanGame.numChancesLeft--;
    document.getElementById(press).style.textShadow = "0 0 1.5vh rgba(196,23,23,0.5)";
  }
  displayWord();
  document.getElementById(press).style.color = "transparent";
  document.getElementById("hangman").src = "assets/images/" + hangmanGame.gameLevel + "/" + hangmanGame.mistakes + ".png";
}

function displayWord() {
  var wordDisplay = "<p>";
  for (var i = 0; i < hangmanGame.currentWordArray.length; i++) {
    if (hangmanGame.guesses.includes(hangmanGame.currentWordArray[i])) {
      wordDisplay += hangmanGame.currentWordArray[i];
    }
    else if (hangmanGame.currentWordArray[i] === " ") {
      wordDisplay += "</p> <p>";
    } else {
      wordDisplay += "_";
    }
  }
  wordDisplay += "</p>";
  document.getElementById("wordDisplay").innerHTML = wordDisplay;
  checkWin(wordDisplay);
}



function displayNewWord() {
  // Retrieve the selected category array
  const category = categories[hangmanGame.gameLevel][hangmanGame.currentCategory];
  
  // Select a random word from the category
  hangmanGame.currentWord = category[Math.floor(Math.random() * category.length)];
  hangmanGame.currentWordArray = hangmanGame.currentWord.split('');
  hangmanGame.guesses = ["'", "-"];
  
  var wordDisplay = "<p>";
  wordDisplay = wordDisplay + "</p>";
  document.getElementById("wordDisplay").innerHTML = wordDisplay;
  hangmanGame.gameComplete = false;

  alphabet = "abcdefghijklmnopqrstuvwxyz".toUpperCase().split('');
  for (var i = 0; i < alphabet.length; i++) {
    document.getElementById(alphabet[i]).style.color = "black";
    document.getElementById(alphabet[i]).style.textShadow = "";
  }
  
  hangmanGame.numChancesLeft = hangmanGame.maxNumChances;
  displayWord();
  displayScore();
  lastLetter.textContent = "-";
  lastLetterPhone.textContent = "-";
  hangmanGame.mistakes = 0;
  document.getElementById("hangman").src = "assets/images/" + hangmanGame.gameLevel + "/0.png";
  isWin = false;
  startTimer(); // Start the timer for the new game
}


function displayScore() {
  wins.textContent = hangmanGame.numWins;
  winsPhone.textContent = hangmanGame.numWins;
  losses.textContent = hangmanGame.numLosses;
  lossesPhone.textContent = hangmanGame.numLosses;
  score.textContent = hangmanGame.totalScore;
  scorePhone.textContent = hangmanGame.totalScore;
  chancesLeft.textContent = hangmanGame.numChancesLeft;
  chancesLeftPhone.textContent = hangmanGame.numChancesLeft;
  if (hangmanGame.totalScore > 0) {
    document.getElementById("score").style.color = "green";
  }
  else if (hangmanGame.totalScore < 0) {
    document.getElementById("score").style.color = "red";
  }
  else {
    document.getElementById("score").style.color = "white";
  }
}

function changeLevel(newLevel) {
  if (checkChangeLevel()) {
    startGame(newLevel);
  }
}

// Set the base points based on the level
function startGame(chosenLevel) {
  hangmanGame.gameLevel = chosenLevel;
  if (chosenLevel === "easy") {
    document.getElementById("level").style.color = "green";
    hangmanGame.maxNumChances = 10;
    hangmanGame.pointValue = 10;
    hangmanGame.bonusPoints = 20;
    timerDuration = 120; // Set a 30-second timer for the easy level
  } else if (chosenLevel === "medium") {
    document.getElementById("level").style.color = "gold";
    hangmanGame.maxNumChances = 8;
    hangmanGame.pointValue = 25;
    timerDuration = 180; // Set a 45-second timer for the medium level
  } else {
    document.getElementById("level").style.color = "red";
    hangmanGame.maxNumChances = 6;
    hangmanGame.pointValue = 50;
    timerDuration = 300; // Set a 60-second timer for the hard level
  }
  resetGame();
  gameStart();
}

function resetGame() {
  alphabet = "abcdefghijklmnopqrstuvwxyz".toUpperCase().split('');
  for (var i = 0; i < alphabet.length; i++) {
    document.getElementById(alphabet[i]).style.color = "black";
    document.getElementById(alphabet[i]).style.textShadow = "";
  }
  hangmanGame.totalScore = 0;
  hangmanGame.numWins = 0;
  hangmanGame.numLosses = 0;
  hangmanGame.numChancesLeft = hangmanGame.maxNumChances;
  lastLetter.textContent = "-";
  lastLetterPhone.textContent = "-";
  hangmanGame.mistakes = 0;
  document.getElementById("hangman").src = "assets/images/" + hangmanGame.gameLevel + "/0.png";
  displayNewWord();
}

function changeLevel(newLevel,newCategory) {
  if (checkChangeLevel()) {
    startGame(newLevel,newCategory);
  }
}

function restart() {
  if (confirm("Are you sure you would like to restart the game? All stats will reset.")) {
    resetGame();
    startScreen.style.visibility = "visible";
  }
}




function resetCurrentLevel() {
  alphabet = "abcdefghijklmnopqrstuvwxyz".toUpperCase().split('');
  for (var i = 0; i < alphabet.length; i++) {
    document.getElementById(alphabet[i]).style.color = "black";
    document.getElementById(alphabet[i]).style.textShadow = "";
  }
  // Reset game-related variables, including timerDuration
  hangmanGame.totalScore = 0;
  hangmanGame.numWins = 0;
  hangmanGame.numLosses = 0;
  hangmanGame.numChancesLeft = hangmanGame.maxNumChances;
  lastLetter.textContent = "-";
  lastLetterPhone.textContent = "-";
  hangmanGame.mistakes = 0;
  document.getElementById("hangman").src = "assets/images/" + hangmanGame.gameLevel + "/0.png";
  timerDuration = 0; // Reset timerDuration
}





function checkWin(display) {
  var isWin = true;

  if (hangmanGame.numChancesLeft <= 0) {
    // Handle the case when the game is lost
    alphabet = [];
    hangmanGame.numLosses++;
    document.getElementById("wordDisplay").innerHTML = "<p>" + hangmanGame.currentWord + "</p> <h4>You Lose...New Game starting soon...";
    setTimeout(function () {
      displayNewWord();
    }, 3000);
    clearInterval(timer);
    
  } 

  
  
  
  
  else {
    // Check if the game is won
    for (var i = 0; i < hangmanGame.currentWordArray.length; i++) {
      if (!(hangmanGame.guesses.includes(hangmanGame.currentWordArray[i]) || hangmanGame.currentWordArray[i] === " ")) {
        isWin = false;
        break;
      }
    }

    if (isWin) {
      // Calculate time bonus based on the remaining time
      var timeBonus = 0;
      if (remainingTime >= 90 && hangmanGame.gameLevel === "easy") {
        timeBonus = 20;
      } else if (remainingTime >= 135 && hangmanGame.gameLevel === "medium") {
        timeBonus = 50;
      } else if (remainingTime >= 210 && hangmanGame.gameLevel === "hard") {
        timeBonus = 70;
      }
      
      var totalPoints = hangmanGame.pointValue + timeBonus;
      hangmanGame.totalScore += totalPoints;

      alphabet = [];
      hangmanGame.numWins++;
      clearInterval(timer);
      document.getElementById("wordDisplay").innerHTML = "<p>" + display + "</p> <h4>You Win! New Game starting soon...";

      // Start a new game after a delay
      setTimeout(function () {
        displayNewWord();
      }, 3000);
    }
  }
  displayScore();
}






function startNewGame() {
  resetCurrentLevel(); // Reset the current level
  displayNewWord(); // Start a new game
}


function gameStart() {
  startScreen.style.visibility = "hidden";
  document.body.style.backgroundImage = "url('assets/images/" + hangmanGame.gameLevel + ".png')";
  level.textContent = hangmanGame.gameLevel;
  displayNewWord();
}

function checkChangeLevel() {
  if (hangmanGame.numChancesLeft === hangmanGame.maxNumChances) {
    return true;
  }
  else if (confirm("Are you sure you want to change the category? You will lose the current game.")) {
    hangmanGame.numLosses++;
    hangmanGame.totalScore -= hangmanGame.pointValue;
    displayScore();
    return true;
  }
  else {
    return false;
  }
}

function restart() {
  if (confirm("Are you sure you would like to restart the game? All stats will reset.")) {
    alphabet = "abcdefghijklmnopqrstuvwxyz".toUpperCase().split('');
    for (var i = 0; i < alphabet.length; i++) {
      document.getElementById(alphabet[i]).style.color = "black";
      document.getElementById(alphabet[i]).style.textShadow = "";
    }
    hangmanGame.totalScore = 0;
    hangmanGame.numWins = 0;
    hangmanGame.numLosses = 0;
    hangmanGame.numChancesLeft = hangmanGame.maxNumChances;
    lastLetter.textContent = "-";
    lastLetterPhone.textContent = "-";
    hangmanGame.mistakes = 0;
    document.getElementById("hangman").src = "assets/images/" + hangmanGame.gameLevel + "/0.png";
    startScreen.style.visibility = "visible";
  }
}

function help() {
  helpScreen.style.visibility = "visible";
}

function helpHide() {
  helpScreen.style.visibility = "hidden";
}