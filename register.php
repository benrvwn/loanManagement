<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <title>Document</title>
    <style>
        
    </style>
    <script>
        $(document).ready(function(){
            $('#register').submit(function(event){
                event.preventDefault()
                
                let formData = $(this).serialize();
                $.post('register-process.php', formData, function(response){
                    $('#messages').empty();
                    $('#messages').append(response);
                })
            })
        });
    </script>
</head>
<body>
    
    <form id="register" class="register">
        <h1>SIGN UP</h1>
        <div class="container">
            <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" placeholder="Enter username">
            <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" placeholder="Enter password">
            <label for="fname">First Name:</label>
                <input type="text" class="form-control" name="fname" placeholder="Enter first name">
            <label for="lname">Last Name:</label>
                <input type="text" class="form-control" name="lname" placeholder="Enter last name">
            <label for="color">What is your favorite color?</label>
                <input type="text" class="form-control" name="color" placeholder="Enter your answer">
            <input type="submit" value="REGISTER" class="btn btn-success">
            <div id="messages"></div>
            <a href="/"><i class="bi bi-box-arrow-left"></i>Back to login</a>
        </div>
        
    </form>
</body>
</html>