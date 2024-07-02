
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <link rel="icon" href="./assets/img/encrypted-logo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
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


                <!-- navbar-links -->
                <div class="collapse navbar-collapse justify-content-end align-items" id="navbarNav">
                    <hr class="text-light">
                    <ul class="navbar-nav justify-content-center align-items-center ">
                        <li class="nav-item ">
                            <a class="nav-link btn btn-secondary" href="./Index.php">Home</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link btn btn-secondary" href="./register.php">Register</a>
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
                        <button class="nav-link text-dark fw-bold text-muted active" id="nav-home-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                        aria-selected="true">Login</button>
                    </div>
                </nav>

                 <!-- toggle btn for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

                <!-- This is for Login Page -->
                <div class="tab-content" id="nav-tabContent"> 
                    <div class="tab-pane fade show active p-3" id="nav-home" role="tabpanel"
                    aria-labelledby="nav-home-tab">
                        <!-- row -->
                    <div class="row justify-content-center my-5">
                         <!-- column -->
                    <div class="col-md-6">
                        
                    <!-- php main function to login-->
                            <?php
                            session_start();

                                if($_SERVER["REQUEST_METHOD"] === "POST"){

                                    $mysqli = require __DIR__ . "/config/db.php";

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
                            $mysqli = require __DIR__ . "/config/db.php";

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
                                            echo "<div class='alert alert-danger'>You have exceeded the maximum login attempts. Please try again later.</div>";
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


                        <!-- form -->
                        <form method="POST" action="login.php" class="row shadow rounded p-5" method="post">
                            <div class="col-md-12 mb-4">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="usernameInput" name="usernameInput"
                                value="<?= htmlspecialchars($_POST['usernameInput'] ?? "")?>">
                              </div>

                              <div class="col-md-12 mb-4">
                                <label for="Password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="passwordInput" name="passwordInput">
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

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script> -->
  </body>
</html>