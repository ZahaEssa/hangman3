<?php
// app/Http/Controllers/ProgressController.php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ProgressController extends Controller
{
    public function getUserProgress()
    {
        $userId = auth()->id();

        $groupedResult = DB::table('games')
            ->select('level', DB::raw('SUM(score) as total_score'))
            ->where('player_id', $userId)
            ->groupBy('level')
            ->get();

        return response()->json($groupedResult);
    }
}
