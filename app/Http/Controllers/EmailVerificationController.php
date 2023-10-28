<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class EmailVerificationController extends Controller
{
    public function sendVerificationEmail(Request $request)
    {
        $email = $request->input('email');
        $fullname = $request->input('fullname');
        $token = Str::random(32);

        // Calculate the expiration time
        $expire = Carbon::now()->addMinutes(2);

        // Save email, fullname, token, and expiration time to your database
        $verificationRecord = [
            'email' => $email,
            'fullname' => $fullname,
            'token' => $token,
            'expiry_time' => $expire,
        ];

        DB::table('verify')->insert($verificationRecord);

        // Send the verification email
        Mail::to($email)->send(new VerificationEmail($fullname, $token));

        return redirect('/email_Verification')->with('email', $email);
    }

    public function verifyEmail($token)
    {
        $currentTime = Carbon::now(); // Use Carbon for working with date and time

        $verificationRecord = DB::table('verify')
            ->where('token', $token)
            ->first();

        if ($verificationRecord && $verificationRecord->expiry_time >= $currentTime) {
            // Generate a new token
            $newToken = Str::random(16);

            // Update the token in the database
            DB::table('verify')
                ->where('gamer_id', $verificationRecord->gamer_id)
                ->update(['token' => $newToken]);

            // Redirect to the signup page with necessary data
            return redirect('/signup')
                ->with('email', $verificationRecord->email)
                ->with('gamer_id', $verificationRecord->gamer_id);
        } else {
            return redirect('/email_Verification');
        }
    }
}

