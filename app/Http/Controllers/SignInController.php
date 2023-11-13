<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class SignInController extends Controller
{
    public function showSignInForm()
    {
        return view('signin'); // Load the sign-in form view
    }

    public function signIn(Request $request)
    {
        $username = $request->input('gamer_username');
        $password = $request->input('password');

        // Use Eloquent to fetch the user from the database
        $user = User::where('gamer_username', $username)->first();

        if ($user) {
            if (password_verify($password, $user->password)) {
                $request->session()->put('data', $user->fullname);
                $request->session()->put('gamer_id', $user->gamer_id);

                // Debugging: Display the 'fullname' and 'gamer_id' when successful
                // dd($request->session()->get('data')); // Debug the 'fullname'
                // dd($request->session()->get('gamer_id')); // Debug the 'gamer_id'

                $request->session()->regenerate();
                return redirect()->route('homepage');
            } else {
                // Invalid password
                return redirect()->route('signin')->with('error', 'Invalid username or password');
            }
        } else {
            // User not found
            return redirect()->route('signin')->with('error', 'Invalid username or password');
        }
    }
}
