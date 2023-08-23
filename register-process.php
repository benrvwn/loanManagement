<?php
    session_start();
    ob_clean();
    require_once("controller/database.php");

    $_SESSION['regError'] = array();

    function valid($input, $name){
        if($input == ''){
            $_SESSION['regError'][] = $name . " can't be blank.";
        }
    }
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);;
    $fName = filter_input(INPUT_POST, "fname", FILTER_SANITIZE_SPECIAL_CHARS);
    $lName = filter_input(INPUT_POST, "lname", FILTER_SANITIZE_SPECIAL_CHARS);

    $passEncrypt = password_hash($password, PASSWORD_DEFAULT);

    valid($username, "Username");
    valid($password, "Password");
    valid($fName, "First Name");
    valid($lName, "Last Name");

    if(strlen($password) < 8 && strlen($password) != 0){
        $_SESSION['regError'][] = "Password too short.";
    }
    else if(strlen($password) > 30){
        $_SESSION['regError'][] = "Password too long.";
    }
    else if(strlen($username) < 6){
        $_SESSION['regError'][] = "Username should atleast longer than 6 characters.";
    }
    else if(strlen($username) > 30){
        $_SESSION['regError'][] = "Username too long.";
    }




    if(empty($_SESSION['regError'])){
        $conn->query("INSERT INTO user(username, password, first_name, last_name, created_at, updated_at)VALUES('{$username}','{$passEncrypt}','{$fName}','{$lName}',now(), now())");
        echo "<div class='alert alert-success' role='alert'>Registered Successfully.</div>";
    }else{

        foreach($_SESSION['regError'] as $message){
?>          <div class="alert alert-danger" role="alert">
                <?= $message ?>
            </div>
<?php       

        }
        $result = ob_get_clean();
        echo $result;
        
    }




?>