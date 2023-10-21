<?php
require_once "../includes/connect.php";

class SignInManager {
    private $con;

    public function __construct($dbConnection) {
        $this->con = $dbConnection;
    }

    public function signIn($username, $password) {
        $enteredUsername = mysqli_real_escape_string($this->con, $username);
        $findGamer = "SELECT * FROM verify WHERE gamer_username = ?";

        if ($stmt = $this->con->prepare($findGamer)) {
            $stmt->bind_param("s", $enteredUsername);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $gamerRow = $result->fetch_assoc();
                $storedPassword = $gamerRow["password"];

                if (password_verify($password, $storedPassword)) {
                    session_start();
                    $_SESSION["data"] = $gamerRow;
                    header("Location: ../homepage.php");
                    exit();
                } else {
                    $error_message = "Incorrect password";
                    header("Location: ../signin.php?error=" . urlencode($error_message));
                    exit();
                }
            } else {
                $error_message = "Incorrect username";
                header("Location: ../signin.php?error=" . urlencode($error_message));
                exit();
            }
        } else {
            // Handle the SQL error
            $error_message = "SQL Error";
            header("Location: ../signin.php?error=" . urlencode($error_message));
            exit();
        }
    }
}

// Usage:
$signInManager = new SignInManager($con);

if (isset($_POST["Signin"])) {
    $signInManager->signIn($_POST["gamer_username"], $_POST["password"]);
} else {
    header("Location: ../signin.php");
    exit();
}
?>
