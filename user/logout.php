<?php

include('./auth.php');
session_start();

//unset all the sessions and redirect the user to the login page
$auth = new Auth();
$auth->logout();
