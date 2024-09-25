<?php

session_start();
include 'db_connect.php';

$error = '';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_id = $_POST["id"];
    $password = $_POST["password"];

    if(empty($login_id) || empty($password)){
        $error = "Please fill in all fields.";
    }
    else{
        $query = "SELECT * from tenants WHERE login_id = '$login_id' AND password = '$password'";
        $result = mysqli_query($conn,$query);

        if(mysqli_num_rows($result) == 1){

            $tenant = mysqli_fetch_assoc($result);

            /*echo "<pre>";
            print_r($tenant);
            echo "</pre>";*/

            $_SESSION['tenant_id'] = $tenant['tenant_id'];
            $_SESSION['login_id'] = $tenant['login_id'];
            $_SESSION['tenant_name'] = $tenant['tenant_name'];
            header("Location: dashboard.php");
            exit();
        }
        else{
            $error = "Invalid login ID or password.";
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="login.css">

    <style>
    .formbox{
    margin: 0 auto;
    border: 3px solid black;
    border-radius: 10px;
    padding: 40px;
    width: 270px;
    }

    input[type="text"],
    input[type="password"]{
        width: 100%;
        font-size: 15px;
    }

    .logo{
        font-family: 'Poppins',sans-serif;
        font-size: 65px;
        letter-spacing: 1px;
        margin: 0;
        padding: 10px;
        text-align: center;
        text-transform: uppercase;
        border: 4px solid transparent;
        background-color: #003366; 
        color: white;
        transition: all 0.4s ease;
    }

    </style>
</head>
<body style="background-color:#f0f3f5;background-image:url(fpbg.jpg);background-repeat:no-repeat;background-size:cover">
    <h1 class="logo" style="text-align: center; font-size:65px;">The Urban Heights</h1>
    <br><br><br><br>
    <div class="formbox">
    <form method="POST">
        <label for="id">Login ID: </label><br>
        <input type="text" name="id" id="id">

        <br><br>

        <label for="pwd">Password: </label><br>
        <input type="password" name="password" id="pwd">

        <br><br>

        <input type="submit" value="Login">
    </form>
    </div> 

</body>
</html>