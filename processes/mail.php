<?php
date_default_timezone_set('Africa/Nairobi');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../PHPMailer/vendor/autoload.php";
require_once "../includes/connect.php";

class Mail {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer();
    }

    public function sendEmail($email, $fullname, $subject, $token) {
        try {
            $this->mail->isSMTP();
            $this->mail->Host = "smtp.gmail.com";
            $this->mail->SMTPAuth = true;
            $this->mail->Username = "noreplyunique123@gmail.com";
            $this->mail->Password = "lvxbvjweyoxcqsrv";
            $this->mail->SMTPSecure = "tls";
            $this->mail->Port = 587;

            $this->mail->setFrom("noreplyunique123@gmail.com", "No Reply");
            $this->mail->addAddress($email, $fullname);

            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $link = "https://localhost/hangman3/processes/verify.php?token=$token";
            
            $this->mail->Body = "
                Hello $fullname,<br><br>
                
                Welcome to Hangman! We're thrilled to have you on board.<br><br>
                
                To complete your registration, please click on the following link: <a href='$link'>Complete Registration</a>.<br><br>
                
                Please note that this link will expire within two hours. If you do not complete the registration process within this time frame, you will be redirected to the email verification page to re-enter your credentials.<br><br>
                
                If you encounter any issues or have questions, feel free to contact us.<br><br>
                
                Kind regards,<br>
                Hangman Game Admin
            ";

            if ($this->mail->send()) {
                return true; // Email sent successfully
            } else {
                return false; // Email sending failed
            }
            
        } catch (Exception $e) {
            return false; // Email sending failed
        }
    }
}

if (isset($_POST["send"])) {
    $subject = "Complete Registration";
    $email = $_POST["email"];
    $fullname = $_POST["fullname"];
    $token = bin2hex(random_bytes(32));
    $expire = date("Y-m-d H:i:s", strtotime("+2 hours"));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div style='background-color: #FF0000; color: white; padding: 10px; text-align: center;'>";
        echo "The email provided is invalid. <br><br>";
        echo "You will be redirected back to the previous page once again to enter your details <br>";
        echo "If not, <a href='../email_verification.php' style='color: white; text-decoration: underline;'>click here</a>.<br><br>";
        header("refresh:7;url=../email_verification.php");
        echo "</div>";
    } else {
        $checkStmt = $con->prepare("SELECT gamer_id FROM verify WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            // Display an error message and redirect to the email verification page
            echo "<div style='background-color: #FF0000; color: white; padding: 10px; text-align: center;'>";
            echo "Email already exists. Please use a different email. <br><br>";
            echo "You will be automatically redirected to the email verification page. ";
            echo "If not, <a href='../email_verification.php' style='color: white; text-decoration: underline;'>click here</a>.<br><br>";
            echo "</div>";
            header("Refresh: 5; URL=../email_verification.php");
            exit();
        } else {
            // If the email doesn't exist, insert the new record
            $sql = "INSERT INTO verify (fullname, token, email, expiry_time) VALUES (?, ?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssss", $fullname, $token, $email, $expire);

            if ($stmt->execute()) {
                $send = new Mail();
                if ($send->sendEmail($email, $fullname, $subject, $token)) {
                    echo "<div style='background-color: #4CAF50; color: white; padding: 10px; text-align: center;'>";
                    echo "Email sent successfully.<br><br>";
                    echo "You will be redirected back to the dashboard. If you were not redirected back to the dashboard, <a href='../index.php' style='color: white; text-decoration: underline;'>click here</a>.<br><br><br>";
                    echo "If you did not receive the verification email click <a href='../email_verification.php' style='color: white; text-decoration: underline;'>here</a>.";
                    echo "</div>";
                    header("refresh:8;url=../index.php");
                } else {
                    echo "Failed to send email.";
                }
            } else {
                echo "Failed to insert user data.";
            }
        }
    }
}
?>
