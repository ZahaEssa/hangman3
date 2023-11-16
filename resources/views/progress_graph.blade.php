<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" defer></script>
    <script src="https://d3js.org/d3.v6.min.js"></script> <!-- Include D3.js library -->

    <title>Pie Chart</title>
    <style>
     
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

        #chart-container {
            display: flex;
            flex-direction: column; /* Stack items vertically */
            align-items: center; /* Center items horizontally */
            margin-top: 20px; /* Adjust the margin to create space between chart and legend */
        }

        #legend {
            display: flex;
            flex-direction: column; /* Stack items vertically */
            align-items: center; /* Center items horizontally */
            margin-bottom: 20px; /* Adjust the margin to create space between chart and legend */
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px; /* Add some space between legend items */
        }

        .legend-color {
            width: 20px;
            height: 20px;
            margin-right: 8px;
        }

        #d3PieChart {
            width: 400px;
            height: 400px;
        }

        .tooltip {
            position: absolute;
            text-align: center;
            padding: 8px;
            font-size: 14px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 5px;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s;
        }
    </style>
</head>
<body>
    <div class="navigation">
        <a href="{{ route('progress') }}">Back to Progress</a>
        <a href="{{ route('progress_chart') }}">View Bar Chart</a>
    </div>

    <!-- Legend for the chart -->
    <div id="legend"></div>

    <!-- Container for the D3.js pie chart -->
    <div id="chart-container">
        <div id="d3PieChart"></div>
    </div>

    <!-- PHP Section -->
    <?php
        use Illuminate\Support\Facades\DB; // Import the DB facade

        // Fetch progress data using a raw SQL query
        $groupedResult = DB::select('SELECT level, category, SUM(score) as total_score FROM games WHERE level IS NOT NULL AND category IS NOT NULL GROUP BY level, category');
    ?>

    <!-- Convert PHP data to JavaScript -->
    <script>
        var groupedData = <?php echo json_encode($groupedResult); ?>;
        
        // Use D3.js to create the pie chart
        var width = 400;
        var height = 400;
        var radius = Math.min(width, height) / 2;

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
            .value(function(d) { return d.total_score; });

        var svg = d3.select("#d3PieChart")
            .append("svg")
            .attr("width", width)
            .attr("height", height)
            .append("g")
            .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

        var data = groupedData.map(function(d) {
            return {
                level: d.level,
                category: d.category,
                total_score: +d.total_score
            };
        });

        var g = svg.selectAll(".arc")
            .data(pie(data))
            .enter().append("g")
            .attr("class", "arc");

        g.append("path")
            .attr("d", arc)
            .style("fill", function(d) { return color(d.data.level + ' - ' + d.data.category); })
            .on("mouseover", function(event, d) {
                // Show tooltip with details on hover
                tooltip.transition()
                    .duration(200)
                    .style("opacity", .9);
                tooltip.html("Total Score: " + d.data.total_score)
                    .style("left", (event.pageX) + "px")
                    .style("top", (event.pageY - 28) + "px");
            })
            .on("mouseout", function(d) {
                // Hide tooltip on mouseout
                tooltip.transition()
                    .duration(500)
                    .style("opacity", 0);
            })
            .transition()  // Apply a transition for the animation effect
            .duration(1000)
            .attrTween("d", function(d) {
                var i = d3.interpolate(d.startAngle, d.endAngle);
                return function(t) {
                    d.endAngle = i(t);
                    return arc(d);
                };
            });

        // Legend
        var legend = d3.select("#legend")
            .selectAll(".legend-item")
            .data(data)
            .enter().append("div")
            .attr("class", "legend-item");

        legend.append("div")
            .attr("class", "legend-color")
            .style("background-color", function(d) { return color(d.level + ' - ' + d.category); });

        legend.append("div")
            .text(function(d) { return d.level + ' - ' + d.category; });

        // Tooltip for hover details
        var tooltip = d3.select("body").append("div")
            .attr("class", "tooltip")
            .style("opacity", 0);
    </script>

</body>
</html>

