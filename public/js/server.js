const express = require('express');
const mysql = require('mysql');
const app = express();
const port = 3000;
const winston = require('winston');
const cors = require('cors');

// Initialize the logger
const logger = winston.createLogger({
  transports: [
    new winston.transports.File({ filename: 'game_results.log' }),
  ],
});

// Create a MySQL connection
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'MainaWanjiru1980?',
  database: 'hangman',
});

// Connect to the database
db.connect((err) => {
  if (err) {
    logger.error('Database connection failed: ' + err.stack);
    process.exit(1); // Terminate the application if the database connection fails.
  } else {
    logger.info('Connected to the database');
  }
});
app.use(cors());

// Middleware to parse JSON in request body
app.use(express.json());

// Handle POST requests to log and store game results
app.post('/logGameResult', (req, res) => {
  // Parse the incoming JSON data
  const { userId, result,level,category } = req.body;

  // Insert the game result into your database (use your MySQL code here)
  const sql = 'INSERT INTO games (player_id, score,level,category) VALUES (?, ?,?,?)';
  db.query(sql, [userId, result,level,category], (error, results) => {
    if (error) {
      logger.error('Error inserting game result: ' + error.message);
      res.status(500).json({ message: 'Error logging game result' });
    } else {
      logger.info(`Game result logged: User ID ${userId}, Result ${result}, Level ${level}, Category ${category}`);

      res.status(200).json({ message: 'Game result logged successfully' });
    }
  });
});

// Start the server
app.listen(port, () => {
  logger.info(`Server is running on port ${port}`);
});
