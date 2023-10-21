<?php
require_once "../includes/connect.php";

class UserUpdater {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function usernameExists($username) {
        $stmt = $this->con->prepare("SELECT gamer_id FROM verify WHERE gamer_username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function updateUser($gamer_id, $username, $password, $confirmPassword) {
        if ($password === $confirmPassword) {
            if ($this->usernameExists($username)) {
                echo "<div style='background-color: #FF0000; color: white; padding: 10px; text-align: center;'>";
                echo "Username already exists. Please choose a different username.";
                echo "You will be automatically redirected to the sign-up page. ";
                echo "If not, <a href='../signup.php' style='color: white; text-decoration: underline;'>click here</a>.<br><br>";
                echo "</div>";
                header("Refresh: 5; URL=../signup.php"); 
                exit();
            } else {
                $hashpass = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $this->con->prepare("UPDATE verify SET gamer_username=?, password=? WHERE gamer_id=?");
                $stmt->bind_param("ssi", $username, $hashpass, $gamer_id);

                if ($stmt->execute()) {
                    header("Location: ../signin.php");
                    exit();
                } else {
                    echo "<div style='background-color: #FF0000; color: white; padding: 10px; text-align: center;'>";
                    echo "Error updating user: " . $stmt->error;
                    echo "</div>";
                }
            }
        } else {
            echo "<div style='background-color: #FF0000; color: white; padding: 10px; text-align: center;'>";
            echo "Passwords do not match!<br><br> ";
            echo "You will be automatically redirected to the sign-up page. ";
            echo "If not, <a href='../signup.php' style='color: white; text-decoration: underline;'>click here</a>.<br><br>";
            echo "</div>";
            header("Refresh: 5; URL=../signup.php?gamer_id=" . $gamer_id);
            exit();
        }
    }
}

if (isset($_POST["registrationBtn"]) && isset($_GET["gamer_id"])) {
    $gamer_id = $_GET["gamer_id"];
    $username = $_POST["gamer_username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmpass"]; 
    $userUpdater = new UserUpdater($con);
    $userUpdater->updateUser($gamer_id, $username, $password, $confirmPassword);
}
?>
