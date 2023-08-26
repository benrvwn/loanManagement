<?php
session_start();
require_once('controller/database.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    header("content-type: application/json");
    echo json_encode($_SESSION['user']);
}else{
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $fName = filter_input(INPUT_POST, "fname", FILTER_SANITIZE_SPECIAL_CHARS);
    $lName = filter_input(INPUT_POST, "lname", FILTER_SANITIZE_SPECIAL_CHARS);
    $color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_SPECIAL_CHARS);

    
    if(isset($_POSt['password'])){
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $passEncrypt = password_hash($password, PASSWORD_DEFAULT);
        $conn->query("UPDATE user SET password = '{$passEncrypt}' WHERE id = {$_SESSION['user']['id']}");
    }
    $conn->query("UPDATE user SET username = '{$username}', first_name = '{$fName}', last_name = '{$lName}', fav_color = '{$color}' WHERE id = {$_SESSION['user']['id']} ");
    echo "<div class='alert alert-success' role='alert'>Update succeeded!</div>";
}




?>