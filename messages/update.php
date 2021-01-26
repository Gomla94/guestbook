<?php

include('Message.php');
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('location:/user/login.php');
}

$errors = [];

// the messageId is from the url
$messageId = $_GET['id'];

//create a new message object and pass to its constructor the con variable from the connection.php file
$message = new Message();

//getting the specific message
$singleMessage = $message->show($messageId);
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $messageBody = $_POST['message'];
    $message->update($messageId, $messageBody);

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

    <div class="text-center" style="margin-top:100px">
        <h5>Update Message</h5>
    </div>
    <form action="" method="POST" style="border:3px solid black;width:600px;margin-left:auto;margin-right:auto">
        <?php include('../errors.php') ?>
        <label for="body">Message</label>
        <div class="form-group">
            <input id="body" name="message" value="<?php echo $singleMessage['message'] ?>" placeholder="Message Body" type="text" class="form-control">
        </div>

        <div class="form-group text-center">
            <button class="btn btn-success">Update Message</button>
        </div>

    </form>

</body>

</html>