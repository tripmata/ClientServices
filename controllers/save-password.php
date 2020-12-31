<?php

$ret = new stdClass();

// load customer info
$customer = new Customer($GLOBALS['subscriber']);
$customer->Initialize($_REQUEST['customerid']);

if($customer->Email != '')
{
    if($customer->hasPassword() === false)
    {
        // compare password
        if ($_REQUEST['password'] == $_REQUEST['password_again'])
        {
            $db = DB::GetDB();

            // get password
            $password = md5($_REQUEST['password']);

            // add password
            $db->query("UPDATE customer SET `password` = '$password' WHERE customerid = '$customer->Id'");


            $ret->status = "success";
            $ret->message = "Customer password has been added successfully. Now you can login.";
            $ret->link = rtrim(Configuration::url()->host, '/') . '/login';

        }
        else 
        {
            $ret->status = 'error';
            $ret->message = 'Your passwords does not match. Please check and try again';
        }
    }
    else
    {
        $ret->status = "error";
        $ret->message = "You already have a password. Please try using the reset password screen if you have forgotten your password.";
    }
}
else
{
    $ret->status = "error";
    $ret->message = "Account does not exists.";
}


echo json_encode($ret);