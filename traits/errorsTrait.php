<?php

trait Errors
{
    public $errors = [];

    public function addError($error)
    {
        //this method will add a new error to the errors array
        array_push($this->errors, $error);
    }
}
