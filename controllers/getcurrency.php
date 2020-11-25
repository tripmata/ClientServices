<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    if ($GLOBALS['user']->Role->Webconfig->ReadAccess)
    {
        $site = new Site($GLOBALS['subscriber']);
        $ret->data = $GLOBALS['subscriber']->Currency;
        $ret->Gateway = new Paygateway($GLOBALS['subscriber']);
        $ret->Webpay = $site->Payonline;
        $ret->Nopayreservation = $site->Nopayreservation;
        $ret->status = "success";
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