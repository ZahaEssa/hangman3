<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/line.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Include html2pdf library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
    <title>User Progress</title>

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
        <button onclick="exportToPDF()">Export to PDF</button>
        <button onclick="exportToExcel()">Export to Excel</button>
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
        function exportToPDF() {
    // Hide navigation buttons before exporting
    var navigationButtons = document.querySelector('.navigation');
    navigationButtons.style.display = 'none';

    // Get the chart container for export
    var chartContainer = document.getElementById('lineChart').parentElement;

    // Use html2pdf to export the chart container
    html2pdf(chartContainer, {
        margin: 10,
        filename: 'user_progress.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
        onBeforeDownload: function () {
            // Restore visibility of navigation buttons after export
            navigationButtons.style.display = 'block';
        }
    });
}


        function exportToExcel() {
            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.json_to_sheet(groupedData);

            XLSX.utils.book_append_sheet(wb, ws, 'Progress Data');
            XLSX.writeFile(wb, 'progress_data.xlsx');
        }
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
