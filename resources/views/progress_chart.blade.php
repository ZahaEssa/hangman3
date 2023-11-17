<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/progress_css.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.js"></script>

    <title>Progress Chart</title>

    <style>
        #chartContainer {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0 auto;
        }

        #chartWrapper {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: relative;
    width: 500px;
    height: 500px;
}

#username {
    text-align: center;
    white-space: nowrap; /* Ensures the text stays on one line */
    margin-top: 20px; /* Add margin to separate the username from the chart */
}




        .navigation {
            display: flex;
            justify-content: space-around;
            background-color: #333;
            padding: 10px;
            margin-bottom: 20px;
        }

        .navigation a {
            color: white;
            text-decoration: none;
            font-size: 1.2em;
            padding: 8px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .navigation a:hover {
            background-color: #555;
        }

        .login-message {
            background-color: #f8d7da; /* Light red background color */
            color: #721c24; /* Dark red text color */
            padding: 15px; /* Padding around the message */
            border: 1px solid #f5c6cb; /* Border color */
            border-radius: 5px; /* Rounded corners */
            margin-top: 20px; /* Top margin */
            text-align: center; /* Center text */
        }

        .login-link {
            color: #721c24; /* Dark red text color for the link */
            font-weight: bold; /* Bold text for the link */
            text-decoration: underline; /* Underline for the link */
        }
    </style>
</head>

<body>
<?php
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\DB;
    ?>



    <div class="navigation">
        <a href="{{ route('progress') }}">Back to Progress</a>
        <a href="{{ route('progress_graph') }}">View Pie Chart</a>
        <a href="{{ route('player_progress') }}">View Line Chart</a>
    </div>

    @if(Session::has('data'))
    <?php
        $username = Session::get('data');
        $userId = Session::get('gamer_id');

        if($userId !== null) {
            $groupedResult = DB::select('SELECT level, category, SUM(score) as total_score FROM games WHERE player_id = ? GROUP BY level, category', [$userId]);
    ?>
           

            <div id="chartContainer">
                <div id="chartWrapper">
                    <h1 id="username"></h1>
                    <canvas id="myChart" width="500" height="500"></canvas>
                </div>
            </div>

            <script>
                var groupedData = <?php echo json_encode($groupedResult); ?>;
                var username = "<?php echo $username; ?>";
                var labels = groupedData.map(item => item.level + ' - ' + item.category);
                var data = groupedData.map(item => item.total_score);

                document.getElementById('username').innerText = username + "'s Progress Chart";

                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Score',
                            data: data,
                            backgroundColor: 'rgba(75, 192, 192, 0.8)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            onComplete: function (animation) {
                                // Animation completed, handle any post-animation tasks here
                            },
                            onProgress: function (animation) {
                                // Animation in progress, handle any progress-related tasks here
                            },
                            easing: 'easeInOutCubic',
                            duration: 2000
                        }
                    }
                });

                
            </script>
    <?php
        } else {
            echo "<p>No results found for this user.</p>";
        }
    ?>
    @else
        <div class="login-message">You are not logged in. Please <a href="{{ route('signin') }}">sign in</a> to view your progress.</div>
    @endif
</body>

</html>
