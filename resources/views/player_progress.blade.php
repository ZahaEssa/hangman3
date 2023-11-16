<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.css">
    <script src="https://unpkg.com/html2pdf.js/dist/html2pdf.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    <title>Player Progress Over Time</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: lavender;
            font-family: 'Arial', sans-serif;
        }
    </style>
</head>
<body>
    <!-- Canvas element for the line chart with increased width and height -->
    <canvas id="lineChart" width="800" height="500"></canvas>

    <?php
        use Illuminate\Support\Facades\DB;

        // Fetching progress data using raw SQL
        $playerIds = DB::table('games')->select('player_id')->distinct()->pluck('player_id');
        $playerData = [];

        foreach ($playerIds as $playerId) {
            $playerGames = DB::table('games')->where('player_id', $playerId)->orderBy('created_at')->get();
            $playerScores = $playerGames->pluck('score')->toArray();
            $timestamps = $playerGames->pluck('created_at')->toArray();

            $playerData[] = [
                'playerId' => $playerId,
                'playerName' => "Player {$playerId}", // Adjust player name as per your setup
                'scores' => $playerScores,
                'timestamps' => $timestamps,
            ];
        }
    ?>

    <!-- Converting PHP data to JavaScript -->
    <script>
        var playerData = <?php echo json_encode($playerData); ?>;
        var ctx = document.getElementById('lineChart').getContext('2d');

        var datasets = playerData.map(player => ({
            label: player.playerName,
            data: player.scores,
            borderColor: getRandomColor(), // Function to get a random color for each player
            fill: false,
        }));

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: playerData[0].timestamps, // Assuming timestamps are the same for all players
                datasets: datasets,
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                aspectRatio: 1.5, // Adjusted aspect ratio
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1500,
                },
            }
        });

        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script>

    <!-- JavaScript section -->
    <script>
        const exportChart = () => {
            const chartE1 = document.getElementById('lineChart');
            const image = chartE1.toDataURL('image/png', 1.0);

            const pdf = new jsPDF('landscape');
            pdf.addImage(image, 'PNG', 5, 30, 300, 150);
            pdf.save('chart.pdf');
        }

        const exportToExcel = () => {
            const wb = XLSX.utils.book_new();
            const wsData = [['Timestamp', ...playerData.map(player => player.playerName)]];

            // Assuming timestamps are the same for all players
            playerData[0].timestamps.forEach((timestamp, index) => {
                const rowData = [timestamp, ...playerData.map(player => player.scores[index])];
                wsData.push(rowData);
            });

            const ws = XLSX.utils.aoa_to_sheet(wsData);
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

            // Saving the workbook
            XLSX.writeFile(wb, 'chart.xlsx');
        }
    </script>
</body>
</html>
