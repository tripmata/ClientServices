<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    

    if ($GLOBALS['user']->Role->Webfront->WriteAccess)
    {
        $gallery = new Gallery($GLOBALS['subscriber']);
        $gallery->Initialize($_REQUEST['galleryId']);

        $gallery->Delete();

        $ret->status = "success";
        $ret->message = "Gallery item have been deleted";
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