<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmailVerificationController extends Controller
{
    public function emailVerification(Request $request, $token)
    {
        $currentTime = now()->setTimezone('Africa/Nairobi');

        $result = DB::table('verify')
            ->select('gamer_id', 'email')
            ->where('token', $token)
            ->where('expiry_time', '>=', $currentTime)
            ->first();

        if ($result) {
            $newToken = bin2hex(random_bytes(16));
            DB::table('verify')
                ->where('gamer_id', $result->gamer_id)
                ->update(['token' => $newToken]);

            // Validate password and confirm_password match
            $validator = Validator::make($request->all(), [
                'password' => 'sometimes|required|confirmed',
            ]);
            
            if ($validator->fails()) {
                return redirect()->route('update', ['gamer_id' => $result->gamer_id])
                    ->withErrors($validator)
                    ->with('email', urlencode($result->email));
            }
            

            // Redirect the user after signup to a "welcome" route, assuming it exists
            return redirect()->route('update', ['gamer_id' => $result->gamer_id])
                ->with('email', urlencode($result->email));
        } else {
            return redirect('/');
        }
    }
}
