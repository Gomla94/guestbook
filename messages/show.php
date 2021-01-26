<?php

include('Message.php');

session_start();
if (!isset($_SESSION['loggedin'])) {
    header('location:/user/ogin.php');
}


// getting the user_id from the session and message_id from the url
$user_id = $_SESSION['userid'];
$messageid = $_GET['id'];

//create a new message object and pass to its constructor the con variable from the connection.php file
$message = new Message();
$errors = [];
//getting the specific message and its replies
$singleMessage = $message->show($messageid);
$messageReplies = $message->getReplies($messageid);


//if a post request is fired then go and store a new reply to this message
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reply = $_POST['reply'];
    $message->store_reply($reply, $messageid, $user_id);
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

    <a href="/user/logout.php" class="btn btn-danger">Logout</a>

    <div class="text-center" style="margin-top:100px">
        <h5>Single Message Page</h5>
        <a href="/messages/index.php" style="text-decoration:none">Messages Page</a>
    </div>


    <!-- this is the form which will create the reply -->
    <form action="" method="POST" style="border:3px solid black;width:600px;margin-left:auto;margin-right:auto">
        <?php include('../errors.php') ?>
        <label for="email" style="">Message:<strong><?php echo $singleMessage['message'] ?></strong></label>
        <br />
        <label for="email">Reply To This Message:</label>
        <div class="form-group">
            <input id="reply" name="reply" placeholder="Enter Reply" type="text" class="form-control">
        </div>

        <div class="form-group text-center">
            <button class="btn btn-success">Reply</button>
        </div>
    </form>


    <!-- this table will show the replies associated with this comment -->
    <h5 class="text-center" style="margin-top:10px">This is the replies table associated with this message</h5>
    <table class="table table-hover" style="width:900px;margin-left:400px;margin-top:10px">
        <thead>
            <th>ID</th>
            <th>User ID</th>
            <th>Reply</th>
            <th>Message ID</th>

        </thead>

        <tbody>
            <?php if ($messageReplies->num_rows > 0) {

                while ($data = mysqli_fetch_assoc($messageReplies)) {
            ?>
                    <tr>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['user_id']; ?></td>
                        <td><?php echo $data['reply']; ?></td>
                        <td><?php echo $data['message_id']; ?></td>

                    </tr>

            <?php }
            } ?>
        </tbody>
    </table>
</body>

</html>