<?php

	$ret = new stdClass();

        $ret->data = array();

        if($GLOBALS['user']->Id != "")
        {
            if($GLOBALS['user']->Id == "adxc0")
            {
                $ret->status = "success";

                $page = $_REQUEST['Page'];
                $perpage = $_REQUEST['Perpage'];
                $filter = $_REQUEST['Filter'];
                $filtervalue = $_REQUEST['Filtervalue'];

                $store = array();

                $ret->Page = $page;
                $ret->Perpage = $perpage;

                if($filter == "search list")
                {
                    $store = Role::ByProperty($_REQUEST['property'], $filtervalue);
                }
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