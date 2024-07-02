<?php
session_start(); // Start a PHP session

// Check if the user is not logged in, then redirect to the login page
if (!isset($_SESSION["logged_in"])) {
    header("Location: login.php");
    exit();
}
?>

<?php

     if(isset($_SESSION["user_id"])){
        
        $mysqli = require __DIR__ . "/config/db.php";
        
        $sql = "SELECT * FROM `user_registered` 
                WHERE id = {$_SESSION["user_id"]}";

        $result = $mysqli->query($sql);

        $user = $result->fetch_assoc();

     }  


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LuweSypher Main Page</title>
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

        #btnsub{
            margin: 0;
            padding: 0;
            margin: 5px;
            padding: 2.5px;
            padding-left: 8px;
            padding-right: 8px;
        }

       
    </style>
</head>
  <body>
        <!-- main navbar -->
    <nav class="navbar navbar-expand-md navbar-light bg-dark p-3" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand display-5 fw-bold" href="#">LuweSypher</a>

            <!-- toggle btn for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- navbar-links -->
            <div class="collapse navbar-collapse justify-content-end align-items" id="navbarNav">
                <hr class="text-light">
                <ul class="navbar-nav justify-content-center align-items-center ">
                    <li class="nav-item ">
                        <a class="nav-link btn btn-danger fw-bold text-light" href="./logout.php">Log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

                <?php if(isset($user))?>
                
                <!-- emojis for style -->
                <?php $smilingFace = "\u{1F604}";
                        $keyEmoji = "\u{1F511}"; ?>
                
        <!-- main Transaction & intro text and form -->
        <section class="intro">
           <div class="container-lg">
            <div class="container my-5">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <!-- display username and emoji display -->
                    <h2 class=" fw-bold text-success">Welcome back, <?= htmlspecialchars($user["username"]) ." ". $keyEmoji ?></h2>
                    </div>
                </nav>
                <!-- EandD Content -->
                <div class="tab-content" id="nav-tabContent"> 
                    <div class="tab-pane fade show active p-3" id="nav-home" role="tabpanel"
                    aria-labelledby="nav-home-tab">
                        <!-- row -->
                    <div class="row justify-content-center my-5">
                         <!-- column -->
                         <div class="col-md-12">
                            <div class="col-md-12 mb-4 justify-content-center text-center">
                                <h2 class=" fw-bold mb-4">ATBASH Encryption | Decryption </h2>

                             <!-- input  -->
                                    <label for="inputText">Enter Text:</label>
                                        <textarea class="col-md-12" id="inputText" rows="8"></textarea>
                                        
                                        <label  for="cipherSelect">Select Action:</label>
                                        <select class="p-1 bg-dark text-light pe " id="cipherSelect">
                                            <option value="encrypt">Encrypt</option>
                                            <option value="decrypt">Decrypt</option>
                                        </select>

                                        <button class="bg-dark text-light" onclick="performAction()" id="btnsub">Submit</button>
                              </div>
                            
                              <!-- //Output -->
                              <div class="col-md-12 mb-4 mt-4 justify-content-center text-center">
                                        <label for="outputText">Result:</label>
                                        <textarea class="col-md-12" id="outputText" rows="8"  readonly></textarea>
                              </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- conneted to js for atbash functionality   -->
    <script src="./js/index.js"></script>
  </body>
</html>