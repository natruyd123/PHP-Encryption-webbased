<?php

    $host = "localhost";
    $dbname = "useraccount";
    $username = "root";
    $password = "";

    
    $conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Something went wrong;");
}

    $mysqli = new mysqli(hostname: $host,
                        username: $username,
                        password: $password,
                        database: $dbname);

    if($mysqli->connect_errno){
        die("Connection error: " . $mysqli->connect_error);
    }

    return $mysqli;
?>