<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    if ($GLOBALS['user']->Role->Webfront->ReadAccess)
    {
        $r = new stdClass();
        $theme = new Theme($GLOBALS['subscriber']->ClientTheme);
        $r->Config = $theme;
        $r->Banners = Banner::All($GLOBALS['subscriber']);
        $ret->status = "success";
        $ret->data = $r;
    }
    else
    {
        $ret->status = "access denied";
        $ret->message = "You do not have the required privilage to complete the operation";
    }
}
else
{
    $ret->status = "login";
    $ret->data = "login";
}

echo json_encode($ret);