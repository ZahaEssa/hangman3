<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import the database facade

class EmailVerificationController extends Controller
{
    public function emailVerification(Request $request,$token)
{
   
    $currentTime = now()->setTimezone('Africa/Nairobi');

    // Debug: Check the token
    //dd($token);

    $result = DB::table('verify')
        ->select('gamer_id', 'email')
        ->where('token', $token)
        ->where('expiry_time', '>=', $currentTime)
        ->first();

    // Debug: Check the result
    //dd($result);

    if ($result) {
        $newToken = bin2hex(random_bytes(16));
        DB::table('verify')
            ->where('gamer_id', $result->gamer_id)
            ->update(['token' => $newToken]);

        // Debug: Check the newToken and gamer_id
        //dd($newToken, $result->gamer_id);

     // Redirect the user after signup to a "welcome" route, assuming it exists
     return redirect()->route('update', ['gamer_id' => $result->gamer_id])
     ->with('email', urlencode($result->email));
 

    } else {
        return redirect('/');
    }
}

}
