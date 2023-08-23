<?php
session_start();
require("database.php");
$_SESSION['error'] = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $query = "select * from user where username = '{$_POST['username']}'";

    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = $_POST['password'];


    $data = fetch_record($query);


    if(empty($username) || empty($password)){
        $_SESSION['error'][] = "<div class='alert alert-danger' role='alert'>Username or Password can't be blank.</div>";
        header("location: /");
    }
    else if(!empty($data)){

        if(!password_verify($password, $data['password'])){
            $_SESSION['error'][] = "<div class='alert alert-danger' role='alert'>Incorrect Password.</div>";
            header("location: /");
        }else{
            $_SESSION['user'] = $data;
            header("location: ../dashboard");
        }
    }else{
        $_SESSION['error'][] = "<div class='alert alert-danger' role='alert'>Account doesn't exist.</div>";
        header("location: /");
    }

}else{
    session_destroy();
    header('location: /');
}








?>