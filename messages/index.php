<?php

include('Message.php');
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('location:/user/login.php');
}
//create a new message object and pass to its constructor the con variable from the connection.php file
$message = new Message();
$messages = $message->index();

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
        <h5>Messages Page</h5>
        <a href="/messages/create.php" style="text-decoration:none">Create a message</a>
    </div>

    <!-- this table will show all the messages and the id column is an anchor tag which will go to a page where i can add replies to this specific comment -->
    <table class="table table-hover" style="width:900px;margin-left:400px">
        <thead>
            <th>ID</th>
            <th>User ID</th>
            <th>Message</th>
            <th>Update</th>
            <th>Delete</th>
        </thead>

        <tbody>
            <?php if ($messages->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($messages)) {
            ?>
                    <tr>
                        <td><a href="/messages/show.php?id=<?php echo $row['id'] ?> "><?php echo $row['id']; ?></a></td>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['message']; ?></td>
                        <td>
                            <?php if ($row['user_id'] == $_SESSION['userid']) : ?>
                                <a href="/messages/update.php?id=<?php echo $row['id'] ?>" class="btn btn-success">Update</a>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if ($row['user_id'] == $_SESSION['userid']) : ?>
                                <a href="/messages/delete.php?id=<?php echo $row['id'] ?>" class="btn btn-danger">Delete</a>
                            <?php endif ?>
                        </td>
                    </tr>

            <?php }
            } ?>
        </tbody>
    </table>
</body>

</html>