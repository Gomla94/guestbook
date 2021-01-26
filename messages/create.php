<?php

include('Message.php');
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('location:/user/login.php');
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //when a post request is fired then store a new message
    $messageBody = $_POST['message'];
    $userId = $_SESSION['userid'];

    //create a new message object and pass to its constructor the con variable that is returned from the connection.php file
    $message = new Message();
    $message->store($messageBody, $userId);

    //the errors array will be populated with errors in the Message class
    $errors = $message->errors;
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

    <div class="form-group" style="">
        <a href="/user/logout.php" class="btn btn-danger">Logout</a>
    </div>
    <div class="text-center" style="margin-top:100px">
        <h5>Creating new message page</h5>
    </div>

    <!-- this is the form which will create the message -->
    <form action="/messages/create.php" method="POST" style="border:3px solid black;width:600px;margin-left:auto;margin-right:auto">
        <?php include('../errors.php') ?>
        <label for="body">Message</label>
        <div class="form-group">
            <input id="body" name="message" placeholder="Message Body" type="text" class="form-control">
        </div>

        <div class="form-group text-center">
            <button class="btn btn-success">Create Message</button>
        </div>

    </form>

</body>

</html>