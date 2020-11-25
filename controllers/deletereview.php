<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    if($GLOBALS['user']->Role->Messaging->ReadAccess)
    {
        $review = new Review($GLOBALS['subscriber']);
        $review->Initialize($_REQUEST['Reviewid']);
        $review->Delete();

        $ret->status = "success";
        $ret->data = null;
        $ret->message = "Review has been deleted successfully";
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
    $ret->data = "login & try again";
}

echo json_encode($ret);