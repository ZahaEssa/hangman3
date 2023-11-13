<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/progress_css.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Progress Chart</title>
</head>
<body>
    <?php
    use Illuminate\Support\Facades\DB; // Import the DB facade

    // Fetch progress data using a raw SQL query
    $groupedResult = DB::select('SELECT level, category, SUM(score) as total_score FROM games WHERE level IS NOT NULL AND category IS NOT NULL GROUP BY level, category');
    
    ?>

    <!-- Canvas element for the chart -->
    <canvas id="progressChart" width="300" height="200"></canvas>

    <!-- Script to generate the chart -->
    <script>
        var groupedData = <?php echo json_encode($groupedResult); ?>;

        var labels = groupedData.map(item => item.level + ' - ' + item.category);
        var data = groupedData.map(item => item.total_score);

        var ctx = document.getElementById('progressChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Score',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
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
                responsive: true, // Enable responsiveness
                maintainAspectRatio: false, // Disable aspect ratio to adjust size freely
            }
        });
    </script>
</body>
</html>