<?php
session_start(); // Start a PHP session

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Page</title>
    <link rel="icon" href="./assets/img/encrypted-logo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
    <style>
        section{
            padding: 60px 0;
        }

          body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background-color: #e7ece5;
        }
       
    </style>
</head>
  <body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-md navbar-light bg-dark p-3" data-bs-theme="dark">
            <div class="container">
                <a class="navbar-brand display-5 fw-bold" href="#">LuweSypher</a>
                <div class="collapse navbar-collapse justify-content-end align-items" id="navbarNav">
                    <hr class="text-light">
                    <ul class="navbar-nav justify-content-center align-items-center ">
                        <li class="nav-item ">
                            <a class="nav-link btn btn-secondary" href="./Index.php">Home</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link btn btn-secondary" href="./login.php">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- main Transaction & intro text and form -->
        <section class="intro">
           <div class="container-lg">
            <div class="container my-5">
                 <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link text-dark fw-bold text-muted active" id="nav-register-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-register" type="button" role="tab" aria-controls="nav-register"
                        aria-selected="true">Register</button>
                    </div>
                </nav>

                <!-- This is for Registration Page -->
                <div class="tab-content" id="nav-tabContent"> 
                        <!-- row -->
                    <div class="row justify-content-center my-5">
                         <!-- column -->
                    <div class="col-md-6">
                    <?php
                        if ($_SERVER["REQUEST_METHOD"] === "POST") {
                            // Connect to the database (replace with your database connection code)
                            $mysqli = require __DIR__ . "/config/db.php";

                            $username = $mysqli->real_escape_string($_POST["registerUname"]);
                            $password = $_POST["registerPassword"];
                            $cpassword = $_POST["cpassword"];

                            // Check if the username already exists
                            $sql = sprintf("SELECT * FROM user_registered WHERE username = '%s'", $username);
                            $result = $mysqli->query($sql);
                            $user = $result->fetch_assoc();

                            if ($user) {
                                echo "<div class='alert alert-danger'>Username already exists. Please use a different username.</div>";
                            } elseif (empty($username)) {
                                echo "<div class='alert alert-danger'>Fields Required.</div>";
                            } elseif (strlen($username) < 6) {
                                    echo "<div class='alert alert-danger'>Username must be at least 6 characters.</div>";
                            } elseif (empty($password)) {
                                echo "<div class='alert alert-danger'>Please enter your password.</div>";
                            } elseif (strlen($password) < 8) {
                                echo "<div class='alert alert-danger'>Password must be at least 8 characters.</div>";
                            } elseif (!preg_match("/[a-z]/i", $password)) {
                                echo "<div class='alert alert-danger'>Password must contain at least one letter.</div>";
                            } elseif (!preg_match("/[0-9]/i", $password)) {
                                echo "<div class='alert alert-danger'>Password must contain at least one number.</div>";
                            } elseif ($password !== $cpassword) {
                                echo "<div class='alert alert-danger'>Passwords doesn't match.</div>";
                            } else {
                                // Hash the password
                                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                                // Insert the new user into the database
                                $insertSql = "INSERT INTO user_registered (username, passwordHash) VALUES (?, ?)";
                                $stmt = $mysqli->prepare($insertSql);

                                if (!$stmt) {
                                    echo "<div class='alert alert-danger'>SQL error: " . $mysqli->error . "</div>";
                                } else {
                                    $stmt->bind_param("ss", $username, $password_hash);
                                    if ($stmt->execute()) {
                                        header("Location: registeredform.php");
                                        exit;
                                    } else {
                                        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
                                    }
                                    $stmt->close();
                                }
                            }

                            // Close the database connection
                            $mysqli->close();
                        }
                    ?>
                        <!-- form -->
                        <form class="row shadow rounded p-5" action="./register.php" method="post" id="signup" novalidate>
                              <div class="col-md-12 mb-4">
                                <label for="registerUname" class="form-label">Username</label>
                                <input type="text" class="form-control" id="registerUname" name="registerUname" 
                                value="<?= htmlspecialchars($_POST['registerUname'] ?? "")?>">
                              </div>

                              <div class="col-md-12 mb-4">
                                <label for="registerPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="registerPassword" name="registerPassword">
                              </div>

                              <div class="col-md-12 mb-4">
                                <label for="cPassword" class="form-label">Confirm Passord</label>
                                <input type="password" class="form-control" id="cpassword" name="cpassword">
                              </div>

                              <div class="col-md-6 p-3">
                              <button class="btn btn-dark">Submit</button>
                              </div>
                        </form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>    
  </body>
</html>