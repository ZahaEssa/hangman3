<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/progress_css.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>User Progress</title>
</head>
<body>

    {{-- Add navigation section --}}
        <div class="navigation">
            <a href="{{ route('progress_graph') }}">View Pie Chart</a>
            <a href="{{ route('progress_chart') }}">View Bar Chart</a>
            <a href="{{ route('player_progress') }}">View Line Chart</a>

           
        </div>

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

        {{-- Display a link to redirect to the chart page --}}
       
       
        {{-- Display a greeting --}}
        <div class="session-container">Hello, {{ $username }}</div>

        {{-- If the user is logged in --}}
        @if($userId !== null)
            {{-- Query to retrieve the grouped data --}}
            @php
                $groupedResult = DB::table('games')
                    ->select('level', 'category', DB::raw('SUM(score) as total_score'))
                    ->where('player_id', $userId)
                    ->groupBy('level', 'category')
                    ->get();

                // Query to retrieve the total score
                $totalScoreResult = DB::table('games')
                    ->select(DB::raw('SUM(score) as total_score'))
                    ->where('player_id', $userId)
                    ->get();
            @endphp

            {{-- If there are results, display a table --}}
            @if(count($groupedResult) > 0)
                <table>
                    <tr><th>Level</th><th>Category</th><th>Total Score</th></tr>
                    {{-- Loop through the results and display the table rows --}}
                    @foreach($groupedResult as $row)
                        <tr><td>{{ $row->level }}</td><td>{{ $row->category }}</td><td>{{ $row->total_score }}</td></tr>
                    @endforeach

                    {{-- Display the row for the total score --}}
                    @if(count($totalScoreResult) > 0)
                        @php $totalRow = $totalScoreResult[0]; @endphp
                        <tr><td colspan="2"><b>Total Score</b></td><td><b>{{ $totalRow->total_score }}</b></td></tr>
                    @endif
                </table>
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