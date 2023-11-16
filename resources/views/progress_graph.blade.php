
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.css">
    <script src="https://unpkg.com/htm12pdf.js/dist/htm12pdf.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    <title>Pie chart</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: lavender;
            font-family: 'Arial', sans-serif;
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
        <a href="{{ route('progress_chart') }}">View Bar Chart</a>
    </div>
    
    <!-- Canvas element for the pie chart with increased width and height -->
    <canvas id="pieChart" width="600" height="500"></canvas>

    <?php
        use Illuminate\Support\Facades\DB; // Importing DB facade

        // Fetching progress data using a raw SQL
        $groupedResult = DB::select('SELECT level, category, SUM(score) as total_score FROM games WHERE level IS NOT NULL AND category IS NOT NULL GROUP BY level, category');
    ?>

    <!-- Converting PHP data to JavaScript -->
    <script>
        var groupedData = <?php echo json_encode($groupedResult); ?>;
        var labels = groupedData.map(item => item.level + ' - ' + item.category);
        var data = groupedData.map(item => item.total_score);

        var ctx = document.getElementById('pieChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Score',
                    data: data,
                    backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 159, 64, 0.8)',
                    'rgba(120, 120, 120, 0.8)', // Add more colors as needed
                    'rgba(200, 50, 200, 0.8)',
                    'rgba(50, 200, 50, 0.8)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(120, 120, 120, 1)', // Matching border colors
                    'rgba(200, 50, 200, 1)',
                    'rgba(50, 200, 50, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                aspectRatio: 1,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                },
                animation: {
                    animateRotate: true, // enabling rotation animation
                    animateScale: true, // enabling scaling animation
                    duration: 1500, // setting the animation duration in milliseconds
                },
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 20,
                        bottom: 20,
                    },
                },
            }
        });
    </script>

    <!-- JavaScript section -->
    <script>
        const exportChart = () => {
            const chartE1 = document.getElementById('pieChart');
            const image = chartE1.toDataURL('image/png', 1.0);

            const pdf = new jsPDF('landscape');
            pdf.addImage(image, 'PNG', 5, 30, 300, 150);
            pdf.save('chart.pdf');
        }

        const exportToExcel = () => {
            const wb =XLSX.utils.book_new();
            const wsData = [['Level - Category', 'Total Score']];

            // adding data to worksheet
            groupedData.forEach(item => {
                wsData.push([item.level + ' - ' + item.category, item.total_score]);
            });

            const ws = XLSX.utils.aoa_to_sheet(wsData);
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

            // saving the workbook
            XLSX.writeFile(wb, 'chart.xlsx');
        }
    </script>
</body>
</html>
