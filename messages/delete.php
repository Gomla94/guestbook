<?php

include('Message.php');
session_start();

$id = $_GET['id'];
$userId = $_SESSION['userid'];


//create a new message object and pass to its constructor the con variable from the connection.php file
$message = new Message();

//firing the delete method to delete the message based on its id
$message->delete($id);
