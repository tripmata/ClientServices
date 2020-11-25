<?php

$ret = new stdClass();

if (isset($_SESSION['user_token']))
{
    $sess = Session::Get($_SESSION['user_token']);

    $customer = new Customer($GLOBALS['subscriber']);
    $customer->Initialize($sess->User);

    if ($customer->Id != "")
    {
        $req = new Fundingrequest($_REQUEST['request']);
        $req->Delete();

        $ret->status = "success";
        $ret->data = $req;
        $ret->message = "Funding request have been deleted successfully";
    }
    else
    {
        $ret->status = "access denied";
        $ret->message = "You do not have the required privilege to complete the operation";
    }
}
else
{
    $ret->status = "login";
    $ret->data = "login";
}

echo json_encode($ret);