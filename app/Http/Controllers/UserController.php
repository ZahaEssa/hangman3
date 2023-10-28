<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Update the user
    public function updateUser(Request $request, $gamer_id)
    {
        $request->validate([
            'gamer_username' => 'required|unique:verify,gamer_username,' . $gamer_id,
            'password' => 'required|confirmed',
        ]);

        $affected = DB::table('verify')
            ->where('gamer_id', $gamer_id)
            ->update([
                'gamer_username' => $request->input('gamer_username'),
                'password' => Hash::make($request->input('password')),
            ]);

        if ($affected) {
            return redirect()->route('signin')->with('success', 'User updated successfully.');
        } else {
            // Handle the case where the update operation fails
            return back()->with('error', 'User update failed.');
        }
    }
}


