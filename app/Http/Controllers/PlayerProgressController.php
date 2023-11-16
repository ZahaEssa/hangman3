<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerProgressController extends Controller
{
    public function playerProgressChart()
    {
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

        return view('player_progress', compact('playerData'));
    }
}
