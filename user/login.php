<?php

include('./auth.php');
session_start();

//check if the user is already logged in then redirect him to the messages pages
if (isset($_SESSION['loggedin'])) {
    header('location:/messages/index.php');
}

//create a new Auth object and pass to its constructor the con variable that is returned from the connection.php file
$auth = new Auth();
$errors = [];

//if condition to check if there is a post method and if so fire the login method in the Auth class
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $auth->login($email, $password);
    //the errors array will be populated with errors in the Auth class
    $errors = $auth->errors;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <title>Document</title>
</head>

<body>

    <div class="text-center" style="margin-top:100px">
        <h5>Login Page</h5>
    </div>
    <form action="/user/login.php" method="POST" style="border:3px solid black;width:600px;margin-left:auto;margin-right:auto">
        <?php include('../errors.php') ?>
        <label for="email">Email</label>
        <div class="form-group">
            <input id="email" name="email" placeholder="Email" type="text" class="form-control">
        </div>

        <label for="password">Password</label>
        <div class="form-group">
            <input type="password" name="password" placeholder="Password" class="form-control">

        </div>

        <div class="form-group text-center">
            <button class="btn btn-success">Login</button>
        </div>

        <a href="register.php" style="text-decoration:none">Don't have an account!</a>
    </form>
</body>

</html>