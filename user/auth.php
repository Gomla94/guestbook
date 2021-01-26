<?php

include('../traits/errorsTrait.php');
include('../connection.php');


//here i am extending the Connection class so that i ca use its connect method to connect to the database.
class Auth extends Connection
{
    //here i am using the errors trait to be able to use its addError method
    use Errors;

    public $con;

    public function __construct()
    {
        //get the returned con variable from the connection.php file
        $this->con = $this->connect();
    }

    public function login($email, $password)
    {

        //first i am running some conditions to check if the email or password are empty, and if so add a new error to the errors array in the 
        //errorsTrait by firing the addError method
        if (empty($email) && empty($password)) {
            $this->addError('Email is required');
            $this->addError('Password is required');
            return false;
        }

        if (empty($email)) {
            $this->addError('Email is required');
            return false;
        }

        if (empty($password)) {
            $this->addError('Password is required');
            return false;
        }


        // To protect against MySQL injection
        $username = mysqli_real_escape_string($this->con, $email);
        $password = mysqli_real_escape_string($this->con, sha1($password));

        $sql = " SELECT * FROM users WHERE email = '$username' AND password = '$password' ";
        $result = mysqli_query($this->con, $sql);
        $data = mysqli_fetch_assoc($result);

        // Mysql_num_rows is counting table row
        $count = mysqli_num_rows($result);

        // If result matched $username and $password, count value must be 1
        if ($count == 1) {
            session_start();
            $_SESSION['loggedin'] = "your are logged in";
            $_SESSION['username'] = $data['name'];
            $_SESSION['userid'] = $data['id'];
            header('location:/messages/index.php');
        } elseif ($count == 0) {
            // $count is not 1 , this means that there is a problem with the username or password
            array_push($this->errors, 'Invalid email or password');
        }
    }

    public function register($name, $email, $password)
    {
        //first i am running some condition to check if the email or password are empty, and if so add a new error to the errors array in the 
        //errorsTrait by firing the addError method
        if (empty($name)) {
            $this->addError('Name is required');
        }

        if (empty($email)) {
            $this->addError('Email is required');
        }

        if (empty($password)) {
            $this->addError('Password is required');
        } else {

            // To protect against MySQL injection
            $name = mysqli_real_escape_string($this->con, $name);
            $username = mysqli_real_escape_string($this->con, $email);
            $password = mysqli_real_escape_string($this->con, sha1($password));

            $selectsql = " SELECT * FROM users WHERE email = '$username' ";
            $result = mysqli_query($this->con, $selectsql);

            // Mysql_num_row is counting table row
            $count = mysqli_num_rows($result);
            if ($count == 1) {
                // count value is 1 then this means that the email already exist
                array_push($errors, 'Email Already exists');
            } else {
                //if the email is not matched with any email in the users table then create the user an create a new session to store his id
                //and to make sure he is logged in and redirect him to the messages page
                $insertsql = "INSERT INTO users (name, email, password) VALUES ('$name', '$username', '$password')";
                if ($this->con->query($insertsql) === TRUE) {
                    $last_id = $this->con->insert_id;
                    var_dump($last_id);
                    $_SESSION['loggedin'] = "your are logged in";
                    $_SESSION['userid'] = $this->con->insert_id;
                    header('location:/messages/index.php');
                }
            }
        }
    }

    public function logout()
    {
        unset($_SESSION['userid']);
        unset($_SESSION['loggedin']);
        unset($_SESSION['username']);
        header('location:/user/login.php');
    }
}
