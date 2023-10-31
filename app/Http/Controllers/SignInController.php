<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User; // Assuming you have an Eloquent model for users

class SignInController extends Controller {
    public function showSignInForm()
    {
        return view('signin'); // Load the sign-in form view
    }


    public function signIn(Request $request) {
        $username = $request->input('gamer_username');
        $password = $request->input('password');

        // Use Eloquent to fetch the user from the database
        $user = User::where('gamer_username', $username)->first();

        if ($user) {
    
            if (password_verify($password, $user->password)) {
                return redirect()->route('homepage');
                exit;
              
              
                
            } 
        }
    }
}
?>

