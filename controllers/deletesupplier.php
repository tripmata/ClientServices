<?php

$ret = new stdClass();

if($GLOBALS['user']->Id != "")
{
    if($GLOBALS['user']->Role->Messaging->ReadAccess)
    {
        $supplier = new Supplier($GLOBALS['subscriber']);
        $supplier->Initialize($_REQUEST['Supplierid']);
        $supplier->Delete();

        $ret->data = null;
        $ret->status = "success";
        $ret->message = "Supplier was deleted successfully";
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