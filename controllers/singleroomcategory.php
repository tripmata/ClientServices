<?php

	$ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Role->Rooms->ReadAccess)
        {
              $ret->status = "success";

              $p = new Property($_REQUEST['property']);

              $ret->data = new Roomcategory(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword));
              $ret->data->Initialize($_REQUEST['roomcategoryid']);
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