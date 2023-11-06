<!DOCTYPE html>
<html>
<head>
<style>
  table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-family: Arial, sans-serif;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
  }

  th, td {
    border: 1px solid #e1e1e1;
    padding: 10px;
    text-align: center;
  }

  tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  th {
    background-color: #4CAF50;
    color: white;
  }

  tr:hover {
    background-color: #ddd;
  }

  /* Additional styles for a more beautiful table */
  th, td {
    transition: background-color 0.3s, color 0.3s;
  }

  tr:hover td {
    background-color: #ddd;
  }

  th {
    text-transform: uppercase;
  }

  caption {
    text-align: left;
    font-weight: bold;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border-radius: 5px 5px 0 0;
  }

  .session-container {
    background-color:pink;
    color: black;
    text-align: center;
    padding: 30px;
    font-size:1.6em;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
  }
</style>
</head>
<body>
@php
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

if (Session::has('data')) {
    $username = Session::get('data');
    echo "<div class='session-container'>Hello, $username</div>";

    // Get the user ID from the session if it's stored there
    $userId = Session::get('gamer_id');

    if ($userId !== null) {
        // Query to retrieve the grouped data
        $groupedResult = DB::table('games')
            ->select('level', 'category', DB::raw('SUM(score) as total_score'))
            ->where('player_id', $userId)
            ->groupBy('level', 'category')
            ->get();

        // Query to retrieve the total score
        $totalScoreResult = DB::table('games')
            ->select(DB::raw('SUM(score) as total_score'))
            ->where('player_id', $userId)
            ->get();

        if (count($groupedResult) > 0) {
            echo "<table>";
            echo "<tr><th>Level</th><th>Category</th><th>Total Score</th></tr>";
            foreach ($groupedResult as $row) {
                echo "<tr><td>" . $row->level . "</td><td>" . $row->category . "</td><td>" . $row->total_score . "</td></tr>";
            }
            // Display the row for the total score
            if (count($totalScoreResult) > 0) {
                $totalRow = $totalScoreResult[0];
                echo "<tr><td colspan='2'><b>Total Score</b></td><td><b>" . $totalRow->total_score . "</b></td></tr>";
            }
            echo "</table>";
        } else {
            echo "No results found for this user.";
        }
    }
} else {
    echo "Guest";
    $userId = null; // In case the user is not logged in, you might not have a user ID.
}
@endphp
</body>
</html>
