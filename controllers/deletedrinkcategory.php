<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    if ($GLOBALS['user']->Role->Bar->ReadAccess)
    {
        $drinkcat = new Drinkcategory($GLOBALS['subscriber']);
        $drinkcat->Initialize($_REQUEST['Drinkcategoryid']);
        $drinkcat->Delete();

        $ret->status = "success";
        $ret->message = "Drink category deleted successfully";
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