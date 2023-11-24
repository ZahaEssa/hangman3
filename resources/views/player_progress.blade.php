<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/line.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/html2pdf.js@0.10.1/dist/html2pdf.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

    <title>User Progress</title>
</head>

<body>
    <?php
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\DB;
    ?>

    @if(Session::has('data'))
    <div class="navigation">
        <a href="{{ route('progress') }}">Back to Progress</a>
        <a href="{{ route('progress_graph') }}">View Pie Chart</a>
        <a href="{{ route('progress_chart') }}">View Bar Chart</a>

        <button id="exportPdf">Export as PDF</button>
        <button id="exportExcel">Export to Excel</button>
    </div>

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
    <h1 style="text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $username }}'s Progress Over Time</h1>
    <canvas id="lineChart" width="1000" height="300"></canvas>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const groupedData = <?php echo json_encode($groupedResult); ?>;
            const labels = groupedData.map(item => item.created_at);
            const data = groupedData.map(item => item.total_score);

            const chartCanvas = document.getElementById('lineChart');
            const ctx = chartCanvas.getContext('2d');

            let myChart;

            function createChart() {
                myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Score',
                            data: data,
                            borderColor: 'steelblue',
                            borderWidth: 3,
                            fill: false,
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
                        },
                        animation: {
                            onComplete: function () {
                                chartCanvas.chart = myChart;
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: 'steelblue'
                                }
                            }
                        },
                    }
                });
            }

            createChart();

            async function exportToPdf() {
                var chartContainer = document.getElementById('lineChart');
                var username = "<?php echo $username ?>"; // Adjusted here

                try {
                    await new Promise(resolve => setTimeout(resolve, 2000));

                    const chartImage = chartContainer.toDataURL("image/png");

                    // Create a separate canvas for the heading
                    const headingCanvas = document.createElement('canvas');
                    headingCanvas.width = chartContainer.width;
                    headingCanvas.height = 40;

                    const headingContext = headingCanvas.getContext('2d');
                    headingContext.fillStyle = 'white';
                    headingContext.fillRect(0, 0, headingCanvas.width, headingCanvas.height);

                    headingContext.font = '20px Arial';
                    headingContext.fillStyle = 'black';
                    headingContext.textAlign = 'center';
                    headingContext.fillText(username + "'s Progress Over Time", headingCanvas.width / 2, 30);

                    // Combine the heading canvas and chart image
                    const combinedCanvas = document.createElement('canvas');
                    combinedCanvas.width = chartContainer.width + 50;
                    combinedCanvas.height = chartContainer.height + 40;

                    const combinedContext = combinedCanvas.getContext('2d');
                    combinedContext.drawImage(headingCanvas, 0, 0);
                    combinedContext.drawImage(chartContainer, 0, 40);

                    const combinedImage = combinedCanvas.toDataURL('image/png');

                    const pdfOptions = {
                        margin: 10,
                        filename: 'user_progress.pdf', // Adjusted here
                        image: { type: 'png', data: combinedImage },
                        html2canvas: { scale: 2, width: combinedCanvas.width, height: combinedCanvas.height },
                        jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' },
                    };

                    // Generate the PDF
                    await html2pdf().from(combinedCanvas).set(pdfOptions).save();
                } catch (error) {
                    console.error("Error exporting to PDF:", error);
                }
            }

            function exportToExcel() {
                var wb = XLSX.utils.book_new();
                var ws = XLSX.utils.json_to_sheet(groupedData);
                XLSX.utils.book_append_sheet(wb, ws, 'Progress Data');
                XLSX.writeFile(wb, 'progress_data.xlsx');
            }

            const exportPDFButton = document.getElementById('exportPdf');
            const exportExcelButton = document.getElementById('exportExcel');

            exportPDFButton.addEventListener('click', function () {
                exportToPdf();
            });

            exportExcelButton.addEventListener('click', function () {
                exportToExcel();
            });
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
