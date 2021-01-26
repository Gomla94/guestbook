<?php

class Connection
{
    private $host = "127.0.0.1"; // Host name 
    private $db_username = "root"; // Mysql username 
    private $db_password = "root"; // Mysql password 
    private $db_name = "guestbook"; // Database name 

    // the connect method will connect to the database then i will return the variable con,
    //so that i can use this method in every class that needs a database connection.
    public function connect()
    {
        $con = mysqli_connect("$this->host", "$this->db_username", "$this->db_password", $this->db_name);
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
            exit();
        }

        return $con;
    }
}
