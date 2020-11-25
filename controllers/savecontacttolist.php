<?php

	$ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Role->Messaging->ReadAccess)
        {
            $list = explode(",", $_REQUEST['data']);

            for($i = 0; $i < count($list); $i++)
            {
                if($list[$i] != "")
                {
                    $cnt = explode(":", $list[$i]);

                    if(count($cnt) == 3)
                    {
                        $p = new Property($_REQUEST['property']);

                        $customlist = new Contactcollection(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword));
                        $customlist->Initialize($cnt[2]);
                        $customlist->Additem($cnt[0], $cnt[1]);
                    }
                }
            }

            $ret->data = $list;

            $ret->status = "success";
            $ret->message = "Custom list retrieved successfully";
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