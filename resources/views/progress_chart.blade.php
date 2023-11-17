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
        margin: 0 auto; /* Add this line to center the container horizontally */
        }
        
        /* Add navigation styles */
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
    </style>
</head>
<body>

 <!-- Add navigation section -->
 <div class="navigation">
        <a href="{{ route('progress') }}">Back to Progress</a>
        <a href="{{ route('progress_graph') }}">View Pie Chart</a>
        <a href="{{ route('player_progress') }}">View Line Chart</a>
    </div>

    <?php
    // Assuming you are using Laravel or a similar framework
    use Illuminate\Support\Facades\DB;

    // Fetch progress data using a raw SQL query
    $groupedResult = DB::select('SELECT level, category, SUM(score) as total_score FROM games WHERE level IS NOT NULL AND category IS NOT NULL GROUP BY level, category');
    ?>

    <!-- Placeholder for the chart image -->
    <div id="chartContainer" style="width: 500px; height: 500px;"></div>

    <script>
    var groupedData = <?php echo json_encode($groupedResult); ?>;
    var labels = groupedData.map(item => item.level + ' - ' + item.category);
    var data = groupedData.map(item => item.total_score);

    // Create a canvas element for rendering the chart
    var canvas = document.createElement('canvas');
    canvas.width = 500;
    canvas.height = 500;
    document.getElementById('chartContainer').appendChild(canvas);

    var ctx = canvas.getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Score',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.8)', // Set a single background color for all bars
                borderColor: 'rgba(75, 192, 192, 1)', // Border color for the bars
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
                onComplete: function(animation) {
                    // Animation completed, handle any post-animation tasks here
                },
                onProgress: function(animation) {
                    // Animation in progress, handle any progress-related tasks here
                },
                easing: 'easeInOutCubic', // Set the easing function for the animation
                duration: 2000 // Set the duration of the animation in milliseconds
            }
        }
    });

   
</script>

</body>
</html>
