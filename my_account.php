<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/pages.css">
    <link rel="stylesheet" href="styles/styles.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script>
        $(document).ready(function(){
            $.get('my_account-prcess.php', function(response){
                console.log(response);
                $('input:eq(0)').val(response.username);
                $('input:eq(2)').val(response.first_name);
                $('input:eq(3)').val(response.last_name);
                $('input:eq(4)').val(response.fav_color);
            })
            $('span').click(function(){
                $('input').removeAttr('disabled');
            })
            $('#update').submit(function(event){
                event.preventDefault();
                let formData = $(this).serialize();
                $.post('my_account-prcess.php', formData, function(response){
                    console.log(response);
                    $('#messages').append(response);
                })
                $('input').attr('disabled', 'TRUE');
            })
        })
    </script>
    <style>
        span{
            width:100%;
            margin-bottom:10px;
        }
    </style>
    <title>My account</title>

</head>
<body>
<?php
    include("nav.php");
?>
    <div class="content">
        <div class="container">
            <form id="update" class="register">
            <h1>MY ACCOUNT</h1>
                <div class="container">
                    <label for="username">Username:</label>
                        <input type="text" class="form-control" name="username" disabled>
                    <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" disabled>
                    <label for="fname">First Name:</label>
                        <input type="text" class="form-control" name="fname" disabled>
                    <label for="lname">Last Name:</label>
                        <input type="text" class="form-control" name="lname" disabled>
                    <label for="color">Your favorite color:</label>
                        <input type="text" class="form-control" name="color" disabled>
                    <span class="btn btn-primary">EDIT</span>
                    <input type="submit" value="SAVE" class="btn btn-success" disabled>
                    <div id="messages"></div>
                </div>
            
            </form>
        </div>
    </div>
</body>
</html>