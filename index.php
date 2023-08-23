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
    <title>Loan Management System</title>
</head>
<body>
    <h1>SIGN IN</h1>
    <form action="controller/process.php" method="post" class="index border m-auto p-5">
        <label>
            Username: <input type="text" name="username" class="form-control">
        </label>
        <label>
            Password: <input type="password" name="password" class="form-control">
        </label>
        <input type="submit" value="LOGIN" class="btn btn-primary">
        

<?php   if(!empty($_SESSION['error'])){
            foreach($_SESSION['error'] as $message){
?>              <?= "<p>{$message}</p>" ?>
<?php
            }
            unset($_SESSION['error']);
}
?>
    <a href="register.php">Create an account</a>
    </form>
</body>
</html>


