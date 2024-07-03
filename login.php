<!-- php main function to login-->
<?php
session_start();

    if($_SERVER["REQUEST_METHOD"] === "POST"){

        $mysqli = require __DIR__ . "../config/db.php";

        $sql = sprintf("SELECT * FROM user_registered
                        WHERE username = '%s'",
                        $mysqli->real_escape_string($_POST["usernameInput"]));

        $result = $mysqli->query($sql);
        
        $user = $result->fetch_assoc();

        if ($user){
            if (password_verify($_POST["passwordInput"], $user["passwordHash"])){
                
                session_regenerate_id();

                $_SESSION["user_id"] = $user["id"];

                $_SESSION["logged_in"] = true;

                header("Location: main.php");
                exit;

            }elseif (empty($_POST["passwordInput"])) {
                echo "<div class='alert alert-danger'>Please Enter your password</div>";
            }else{
                echo "";
            }    
        }else{
            echo "<div class='alert alert-danger'>Username doesn't match</div>";
        }

    }
    
?>



<!-- main php for user attempts -->
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
// Connect to the database (replace with your database connection code)
$mysqli = require __DIR__ . "../config/db.php";

$username = $mysqli->real_escape_string($_POST["usernameInput"]);
$password = $_POST["passwordInput"];

// Check if the username exists in the database
$sql = sprintf("SELECT * FROM user_registered WHERE username = '%s'", $username);
$result = $mysqli->query($sql);
$user = $result->fetch_assoc();

if ($user) {
    if (password_verify($password, $user["passwordHash"])) {
        // Password is correct, reset login attempts
        $_SESSION["login_attempts"] = 0;

        session_regenerate_id();
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["logged_in"] = true;

        header("Location: main.php");
        exit;
    } else {
        if (empty($password)) {
            echo "<div class='alert alert-danger'>Please enter your password</div>";
        } else {
            // Password is incorrect, increment login attempts
            $_SESSION["login_attempts"] = ($_SESSION["login_attempts"] ?? 0) + 1;

            // Check if the user has reached the maximum allowed login attempts (e.g., 3)
            $maxLoginAttempts = 3;
            if ($_SESSION["login_attempts"] >= $maxLoginAttempts) {
                echo( "<div class='alert alert-danger'>You have exceeded the maximum login attempts. Please try again later.</div>");
            } else {
                echo "<div class='alert alert-danger'>Password does not match. Attempt " . $_SESSION["login_attempts"] . " of " . $maxLoginAttempts . "</div>";
            }
        }
    }
} else {
    echo "<div class='alert alert-danger'>Username does not exist</div>";
}
}
?>

<?php
include 'Controllers/loginPage.php'
?>

