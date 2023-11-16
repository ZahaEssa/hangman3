<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserProgressChartController extends Controller
{
    public function showBarChart()
{
    // Fetch progress data using a raw SQL query
    $groupedResult = DB::select('SELECT level, category, SUM(score) as total_score FROM games WHERE level IS NOT NULL AND category IS NOT NULL GROUP BY level, category');

    // Convert level to lowercase for consistent formatting
    foreach ($groupedResult as $item) {
        $item->level = strtolower($item->level);
    }

    // Pass data to the Blade view
    return view('progress_chart', compact('groupedResult'));
}

}
