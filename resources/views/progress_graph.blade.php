<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/graph.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" defer></script>
    <script src="https://d3js.org/d3.v6.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.js"></script>
    <title>Pie Chart</title>
    
</head>

<body>
    <?php
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\DB;
    ?>

    @if(Session::has('data'))
    <script>
        
    </script>

    <div class="navigation">
        <a href="{{ route('progress') }}">Back to Progress</a>
        <a href="{{ route('progress_chart') }}">View Bar Chart</a>
        <a href="{{ route('player_progress') }}">View Line Chart</a>
    </div>

    @php $username = Session::get('data'); @endphp
    @php $userId = Session::get('gamer_id'); @endphp

    @if($userId !== null)
    @php
    // Pie chart data
    $groupedResult = DB::table('games')
        ->select('level', 'category', DB::raw('SUM(score) as total_score'))
        ->where('player_id', $userId)
        ->groupBy('level', 'category')
        ->get();
    @endphp
    
    <!-- Container for the D3.js pie chart and legend -->
   <!-- ... (previous HTML code) -->

<!-- Container for the D3.js pie chart and legend -->
<div id="chart-container">
    <h1 id="username" style="text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"></h1>
    <div id="d3PieChart"></div>
    <div id="legend" class="legend-container"></div>
</div>

<!-- Tooltip -->
<div class="tooltip" id="tooltip"></div>

<script>
    var groupedData = <?php echo json_encode($groupedResult); ?>;
    var username = "<?php echo $username; ?>"; // Get the username
    var width = 400;
    var height = 400;
    var radius = Math.min(width, height) / 2;

    // Your existing D3.js code for the pie chart
    var color = d3.scaleOrdinal()
        .range([
            'rgba(255, 99, 132, 0.8)',
            'rgba(255, 205, 86, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)',
        ]);

    var arc = d3.arc()
        .outerRadius(radius - 10)
        .innerRadius(0);

    var pie = d3.pie()
        .sort(null)
        .value(function (d) {
            return d.total_score;
        });

    var svg = d3.select("#d3PieChart")
        .append("svg")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

    var data = groupedData.map(function (d) {
        return {
            level: d.level,
            category: d.category,
            total_score: +d.total_score
        };
    });

    // Display the username on top of the graph
    d3.select("#username").text(username + "'s Progress Chart");

    var g = svg.selectAll(".arc")
        .data(pie(data))
        .enter().append("g")
        .attr("class", "arc")
        .on("mouseover", function (event, d) {
            // Show tooltip on hover
            d3.select("#tooltip")
                .style("opacity", 1)
                .html(d.data.level + ' - ' + d.data.category + '<br>' + d.data.total_score)
                .style("left", event.pageX + "px")
                .style("top", event.pageY + "px");
        })
        .on("mouseout", function () {
            // Hide tooltip on mouseout
            d3.select("#tooltip").style("opacity", 0);
        });

    g.append("path")
        .attr("d", arc)
        .style("fill", function (d) {
            return color(d.data.level + ' - ' + d.data.category);
        })
        .transition()
        .duration(1000)
        .attrTween("d", function (d) {
            var interpolate = d3.interpolate({ startAngle: 0, endAngle: 0 }, d);
            return function (t) {
                return arc(interpolate(t));
            };
        });

    // Updated Legend
    var legendContainer = d3.select("#legend");

    var legend = legendContainer.selectAll(".legend-item")
        .data(data)
        .enter().append("div")
        .attr("class", "legend-item");

    legend.append("div")
        .attr("class", "legend-color")
        .style("background-color", function (d) {
            return color(d.level + ' - ' + d.category);
        });

    legend.append("div")
        .text(function (d) {
            return d.level + ' - ' + d.category;
        });
</script>

<!-- ... (remaining HTML code) -->


    @endif
    @else
    <div class="login-message">You are not logged in. Please <a href="{{ route('signin') }}">sign in</a> to view your progress.</div>
    @endif

</body>

</html>
