<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User; // Assuming you have a User model

class UserController extends Controller
{
    public function showUpdateForm($gamer_id)
{
    // Load the user's information for the update form
    $user = User::find($gamer_id);

    if (!$user) {
        // Handle the case where the user is not found
        return redirect('/')->with('error', 'User not found');
    }

    return view('signup', ['user' => $user, 'gamer_id' => $gamer_id]);
}

    

public function updateUser(Request $request, $gamer_id)
{
    // Debugging: Check if the method is called and the gamer_id
    //dd('updateUser method called with gamer_id: ' . $gamer_id);
    
    $request->validate([
        'gamer_username' => 'required',
        'password' => 'required|confirmed',
    ]);
    
    // Debugging: Check if validation passed
    //dd('Validation passed');
    
    $user = User::find($gamer_id);

    if (!$user) {
        // Debugging: Check if user is not found
        dd('User not found');
        return redirect()->route('signin')->with('error', 'User not found.');
    }

    // Update the user's data
    $user->gamer_username = $request->input('gamer_username');
    $user->password = bcrypt($request->input('password')); // You should hash the password before saving it.
    
    // Debugging: Check the data before saving
    //dd('Data before saving:', $user);

    $user->save();

    // Debugging: Check if the user is saved
    //dd('User saved successfully');
    
    return redirect()->route('signin')->with('success', 'User updated successfully.');
}

    
    
    
    
}



