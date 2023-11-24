<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserProgressGraphController extends Controller
{
    public function showPieChart()
    {
        // Fetch progress data using a raw SQL query
        $groupedResult = DB::select('SELECT level, category, SUM(score) as total_score FROM games WHERE level IS NOT NULL AND category IS NOT NULL GROUP BY level, category');

        // Pass data to the Blade view
        return view('progress_graph', compact('groupedResult'));
    }
}
