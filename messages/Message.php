<?php

include('../connection.php');
include('../traits/errorsTrait.php');

//here i am extending the Connection class so that i ca use its connect method to connect to the database.
class Message extends Connection
{
    //here i am using the errors trait to be able to use its addError method
    use Errors;

    public $con;

    public function __construct()
    {
        //get the returned con variable from the connection.php file
        $this->con = $this->connect();
    }

    public function index()
    {
        //get all the messages from the messages table
        $sql = " SELECT * FROM messages ";
        $result = mysqli_query($this->con, $sql);
        return $result;
    }

    public function store($messageBody, $userId)
    {
        //first i check if the message body is empty then add an error to the errors array in the errorsTrait
        if (empty($messageBody)) {
            $this->addError('Message is required');
            return false;
        }

        // get the message from the form and user_id is from the session 
        $message = $_POST['message'];

        // To protect MySQL injection
        $message = mysqli_real_escape_string($this->con, $message);

        $sql = " INSERT INTO messages (user_id , message) VALUES ('$userId', '$messageBody') ";
        mysqli_query($this->con, $sql);

        //after finish storing a new message redirect back to the all messages page
        header('location:/messages/index.php');
    }

    public function show($messageId)
    {
        $sql = " SELECT * FROM messages where id = '$messageId' ";
        $result = mysqli_query($this->con, $sql);
        $data = mysqli_fetch_assoc($result);
        return $data;
    }

    public function update($messageId, $messageBody)
    {
        //first i check if the message body is empty then add an error to the errors array in the errorsTrait
        if (empty($messageBody)) {
            $this->addError('Message body is required');
            return false;
        }

        //if the message body is not empty then store the reply in the replies table and redirect back to the messages page
        $sql = "UPDATE messages SET message = '$messageBody' where id = '$messageId' ";
        mysqli_query($this->con, $sql);
        header('location:/messages/index.php');
    }

    public function delete($id)
    {
        //delete a specific message based on its id and delete its related replies then redirect back to the messages page
        $sql = " Delete FROM messages WHERE id = '$id' ";
        $repliesSql = " SELECT * FROM replies where message_id = '$id' ";
        $repliesResult = mysqli_query($this->con, $repliesSql);
        if ($repliesResult->num_rows > 0) {
            while ($data = mysqli_fetch_assoc($repliesResult)) {
                $deleteReplySql =  " Delete FROM replies WHERE id = '$data[id]' ";
                mysqli_query($this->con, $deleteReplySql);
            }
        }

        mysqli_query($this->con, $sql);
        header('location:/messages/index.php');
    }

    public function getReplies($messageId)
    {
        //get all the replies associated with this message;
        $sqlreplies = " SELECT * FROM replies where message_id = '$messageId' ";
        $repliesresult = mysqli_query($this->con, $sqlreplies);
        return $repliesresult;
    }

    public function store_reply($reply, $messageId, $userId)
    {
        //first i check if the reply body is empty then add an error to the errors array in the errorsTrait
        if (empty($reply)) {
            $this->addError('Reply body is required');
            return false;
        }

        //if the reply body is not empty then store the reply in the replies table and redirect back to the message page
        $sql = "INSERT INTO replies (reply, message_id, user_id) VALUES('$reply', '$messageId', '$userId')";
        mysqli_query($this->con, $sql);

        header('location:/messages/show.php?id=' . $messageId);
    }
}
