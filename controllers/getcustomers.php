<?php

	$ret = new stdClass();


    $ret->data = array();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Role->Customers->ReadAccess)
        {
            $page = $_REQUEST['Page'];
            $perpage = $_REQUEST['Perpage'];
            $filter = $_REQUEST['Filter'];
            $filtervalue = $_REQUEST['Filtervalue'];


            $ret->data = array();
            $ret->status = "ACCESS_DENIED";
            $ret->message = "Please login again";

            $property = new Property($_REQUEST['property']);

            $ret->Page = $page;
            $ret->Perpage = $perpage;
            $ret->data = [];
            $store = [];

            $store = Guest::Search(new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword), $filtervalue);
            $ret->Total = count(Guest::All(new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword)));

            $ret->status = "success";
            $ret->Total = count($store);
            $start = (($ret->Page - 1) * $ret->Perpage);
            $stop = (($start + $ret->Perpage) - 1);

            $x = 0;

            for($i = $start; $i < count($store); $i++)
            {
                $ret->data[$x] = $store[$i];
                if($i == $stop){break;}
                $x++;
            }
            
            $ret->message= "DONE";
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