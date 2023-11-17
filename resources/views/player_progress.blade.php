<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>User Progress</title>
    <style>
        body {
            
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Set to the desired height of the chart container */
            margin: 0;
        }

        #chart-container {
            width: 700px;
            height: 300px;
            border: 1px solid #ccc; /* Set the color of the border to light grey */
        }
    </style>
</head>

<body>

    @php
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\DB;
    @endphp

    {{-- Check if the 'data' key exists in the session --}}
    @if(Session::has('data'))
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
                {{-- Create a container for the line chart --}}
                <canvas id="lineChart" width="1000" height="300"></canvas>
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
        <p>Guest</p>
        @php $userId = null; // In case the user is not logged in, you might not have a user ID. @endphp
    @endif

</body>

</html>
