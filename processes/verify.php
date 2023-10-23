<?php
require_once "../includes/connect.php";

class Verify {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function emailVerification($token) {
        // Get the current time
        $currentTime = date("Y-m-d H:i:s");

        // Check if a valid token exists with a future expiry time
        $stmt = $this->con->prepare("SELECT gamer_id, email FROM verify WHERE token=? AND expiry_time>=?");
        $stmt->bind_param("ss", $token, $currentTime);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($gamer_id, $email);
            $stmt->fetch();
            $newToken = bin2hex(random_bytes(16));

            // Update the token for future verification
            $updateStmt = $this->con->prepare("UPDATE verify SET token=? WHERE gamer_id=?");
            $updateStmt->bind_param("si", $newToken, $gamer_id);

            if ($updateStmt->execute()) {
                // Redirect to the sign-up page with email and gamer_id as parameters
                header("Location: ../signup.php?email=" . urlencode($email) . "&gamer_id=" . $gamer_id);
            } else {
                echo "Update failed";
            }
        } else {
            // Redirect back to the email verification page if the token is invalid or expired
            header("Location: ../email_verification.php");
        }
    }
}

if (isset($_GET["token"])) {
    $tokenToVerify = $_GET["token"];
    $object = new Verify($con);
    $object->emailVerification($tokenToVerify);
} else {
    echo "No token provided";
}
?>