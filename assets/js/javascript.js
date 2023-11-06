var isGamePaused = false;
var savedRemainingTime = 0;
var startTime;
var timer;
var timerDuration;

// Initialize the timer with the initial duration
function initializeTimer(initialDuration) {
  timerDuration = initialDuration;
  startTime = Date.now();
  updateTimerDisplay(timerDuration);

  // Start the initial timer
  timer = setInterval(updateTimer, 1000);
}

function updateTimer() {
  var elapsedTime = Math.floor((Date.now() - startTime) / 1000);
  savedRemainingTime = timerDuration - elapsedTime;
  updateTimerDisplay(savedRemainingTime);

  if (savedRemainingTime <= 0) {
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

    // Calculate and store the remaining time accurately
    var elapsedTime = Math.floor((Date.now() - startTime) / 1000);
    savedRemainingTime = timerDuration - elapsedTime;

    console.log("Game is paused. Saved remaining time: " + savedRemainingTime + " seconds");
  }
}

function resumeGame() {
  if (isGamePaused) {
    isGamePaused = false;

    // Update the start time to account for the pause duration
    startTime = Date.now() - (timerDuration - savedRemainingTime) * 1000;

    // Start a new timer with the updated remaining time
    if (savedRemainingTime > 0) {
      timer = setInterval(updateTimer, 1000);
    } else {
      handleTimeout(); // Player has lost immediately
    }
  }
}

// Initialize the timer with the initial duration
initializeTimer(60); // Replace 60 with your desired initial timer duration in seconds
