<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Include html2pdf library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.js"></script>
    <title>User Progress</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh; /* Set to the desired height of the chart container */
            box-sizing: border-box;

        }

        .navigation {
            display: flex;
            justify-content: space-around;
            background-color: #333;
            padding: 10px;
            margin-bottom: 20px;
            width: 100%;
            box-sizing: border-box;
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

        #chartContainer {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0 auto;
        }
        .login-message {
        background-color: #f8d7da; /* Light red background color */
        color: #721c24; /* Dark red text color */
        padding: 15px; /* Padding around the message */
        border: 1px solid #f5c6cb; /* Border color */
        border-radius: 5px; /* Rounded corners */
        margin-top: 20px; /* Top margin */
        text-align: center; /* Center text */
        width:100%;
        box-sizing: border-box;
    }

    .login-link {
        color: #721c24; /* Dark red text color for the link */
        font-weight: bold; /* Bold text for the link */
        text-decoration: underline; /* Underline for the link */
    }

        #chart-container {
            width: 700px;
            height: 300px;
            border: 1px solid #ccc; /* Set the color of the border to light grey */
        }
    </style>
</head>

<body>
    <?php
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\DB;
    ?>

    {{-- Check if the 'data' key exists in the session --}}
    @if(Session::has('data'))
    <div class="navigation">
        <a href="{{ route('progress') }}">Back to Progress</a>
        <a href="{{ route('progress_graph') }}">View Pie Chart</a>
        <a href="{{ route('progress_chart') }}">View Bar Chart</a>
    </div>
    {{-- Get the username from the session --}}
    @php $username = Session::get('data'); @endphp

    {{-- Get the user ID from the session if it's stored there --}}
    @php $userId = Session::get('gamer_id'); @endphp

    {{-- If the user is logged in --}}
    @if($userId !== null)
    {{-- Query to retrieve the grouped data --}}
    @php
        $groupedResult = DB::table('games')
            ->select('created_at', DB::raw('SUM(score) as total_score'))
            ->where('player_id', $userId)
            ->groupBy('created_at')
            ->get();
    @endphp

    {{-- If there are results, display a line chart --}}
    @if(count($groupedResult) > 0)
    <h1 style="text-align: center;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $username }}'s Progress Over Time</h1>
    <canvas id="lineChart" width="1000" height="300" <h1 style="text-align: center;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $username }}'s Progress Over Time</h1>></canvas>
    <script>
        var groupedData = <?php echo json_encode($groupedResult); ?>;
        var labels = groupedData.map(item => item.created_at);
        var data = groupedData.map(item => item.total_score);

        // Create a line chart
        var ctx = document.getElementById('lineChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Score',
                    data: data,
                    borderColor: 'steelblue',
                    borderWidth: 3,
                    fill: false
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'category',
                        title: {
                            display: true,
                            text: 'Created At'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Score'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    @else
    <p>No results found for this user.</p>
    @endif
    @endif
    @else
    <div class="login-message">You are not logged in. Please <a href="{{ route('signin') }}">sign in</a> to view your progress.</div>
    @endif

</body>

</html>
