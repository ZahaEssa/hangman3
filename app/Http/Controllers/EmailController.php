<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Mail;

use App\Models\User; 

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

        $user = User::updateOrInsert(
            ['email' => $email],
            ['fullname' => $name, 'token' => $token, 'expiry_time' => $expire]
        );

        $data = [
            'name' => $name,
            'link' => $verificationUrl, 
        ];

        try {
            // Send the email 
            if (Mail::send('email', $data, function ($message) use ($email, $name, $subject) {
                $message->to($email, $name)->subject($subject);
            })) {
                return redirect('/');
            }
            
            return redirect()->back()->with('success', 'Email sent successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Email could not be sent. Try again later.');
        }
    }
}
?>