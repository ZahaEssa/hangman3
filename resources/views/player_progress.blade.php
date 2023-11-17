<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>User Progress</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }

        .navigation {
            display: flex;
            justify-content: space-around;
            background-color: #333;
            padding: 10px;
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

        #chart-container {
            width: 700px;
            height: 300px;
            border: 1px solid #ccc;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="navigation">
        <a href="{{ route('progress') }}">Back to Progress</a>
        <a href="{{ route('progress_graph') }}">View Pie Chart</a>
        <a href="{{ route('progress_chart') }}">View Bar Chart</a>
    </div>

    @php
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\DB;
    @endphp

    @if(Session::has('data'))
        @php $username = Session::get('data'); @endphp
        @php $userId = Session::get('gamer_id'); @endphp

        @if($userId !== null)
            @php
                $groupedResult = DB::table('games')
                    ->select('created_at', DB::raw('SUM(score) as total_score'))
                    ->where('player_id', $userId)
                    ->groupBy('created_at')
                    ->get();
            @endphp

            @if(count($groupedResult) > 0)
                <canvas id="lineChart" width="1000" height="300"></canvas>
                <script>
                    var groupedData = <?php echo json_encode($groupedResult); ?>;
                    var labels = groupedData.map(item => item.created_at);
                    var data = groupedData.map(item => item.total_score);

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
        @php $userId = null; @endphp
    @endif

</body>

</html>
