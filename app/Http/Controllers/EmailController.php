<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Mail;

use App\Models\User; // Assuming you have a User model

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        date_default_timezone_set('Africa/Nairobi');

        $email = $request->input('email');
        $name = $request->input('fullname');
        $subject = "Complete Registration";
        $token = bin2hex(random_bytes(32));
        $verificationUrl = route('emailverification', ['token' => $token]);
        $expire = date("Y-m-d H:i:s", strtotime("+2 hours"));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'The email provided is invalid.');
        }

        // Insert or update the user data into the database
        $user = User::updateOrInsert(
            ['email' => $email],
            ['fullname' => $name, 'token' => $token, 'expiry_time' => $expire]
        );

        $data = [
            'name' => $name,
            'link' => $verificationUrl, // Use the $verificationUrl here
        ];

        try {
            // Send the email using Laravel's Mail facade
            Mail::send('email', $data, function ($message) use ($email, $name, $subject) {
                $message->to($email, $name)->subject($subject);
            });

            return redirect()->back()->with('success', 'Email sent successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Email could not be sent. Try again later.');
        }
    }
}
?>