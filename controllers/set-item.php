<?php

    $ret = new stdClass();

    if (isset($_REQUEST['customer']))
    {
        $sess = Session::Get($_REQUEST['customer']);

        $customer = new Customer($GLOBALS['subscriber']);
        $customer->Initialize($sess->User);

        if ($customer->Id != "")
        {
            $sess->Itemname = $_REQUEST['itemname'];
            $sess->Currentitem = $_REQUEST['itemvalue'];
            $sess->Save();

            $ret->status = "success";
            $ret->message = "";
            $ret->data = "";
        }
        else
        {
            $ret->status = "failed";
            $ret->message = "";
            $ret->data = null;
        }
    }
    else
    {
        $ret->status = "failed";
        $ret->data = null;
        $ret->message = "";
    }
    echo json_encode($ret);