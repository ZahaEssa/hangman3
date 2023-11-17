<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/chart.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.js"></script>

    <title>Progress Chart</title>

    
</head>

<body>
<?php
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\DB;
    ?>



   

    @if(Session::has('data'))
    <?php
        $username = Session::get('data');
        $userId = Session::get('gamer_id');

        if($userId !== null) {
            $groupedResult = DB::select('SELECT level, category, SUM(score) as total_score FROM games WHERE player_id = ? GROUP BY level, category', [$userId]);
    ?>
            <div class="navigation">
        <a href="{{ route('progress') }}">Back to Progress</a>
        <a href="{{ route('progress_graph') }}">View Pie Chart</a>
        <a href="{{ route('player_progress') }}">View Line Chart</a>
    </div>

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
