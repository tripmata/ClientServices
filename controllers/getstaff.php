<?php

	$ret = new stdClass();


    $ret->data = array();
    $ret->Currency = $GLOBALS['subscriber']->Currency;

    if($GLOBALS['user']->Id != "")
    {
        if ($GLOBALS['user']->Role->Staff->ReadAccess)
        {
            $page = $_REQUEST['Page'];
            $perpage = $_REQUEST['Perpage'];
            $filter = $_REQUEST['Filter'];
            $filtervalue = $_REQUEST['Filtervalue'];

            $ret->data = array();
            $ret->status = "success";
            $ret->message = "Staff list created";

            $store = array();

            $ret->Page = $page;
            $ret->Perpage = $perpage;

            if ($filter == "sort by")
            {
                $store = Staff::Order($GLOBALS['subscriber'], $filtervalue);
            }

            if ($filter == "search list")
            {
                $store = Staff::Search($GLOBALS['subscriber'], $filtervalue);
            }

            $field = "";

            if ($filter == "filter by department")
            {
                $store = Staff::Filter($GLOBALS['subscriber'], $filtervalue, "department");
            }
            if ($filter == "filter by shift")
            {
                $store = Staff::Filter($GLOBALS['subscriber'], $filtervalue, "shift");
            }
            if ($filter == "filter by status")
            {
                $store = Staff::Filter($GLOBALS['subscriber'], $filtervalue, "status");
            }
            if ($filter == "filter by suspended")
            {
                $store = Staff::Filter($GLOBALS['subscriber'], $filtervalue, "suspended");
            }

            $ret->Total = count($store);
            $start = (($ret->Page - 1) * $ret->Perpage);
            $stop = (($start + $ret->Perpage) - 1);

            $x = 0;

            for ($i = $start; $i < count($store); $i++)
            {
                $r = new stdClass();
                $r->Staff = $store[$i];

                //// TODO:
                //To be changed when attendace is completed
                $r->Onduty = false;
                $r->Surcharge = mt_rand(400, 20000);

                $ret->data[$x] = $r;
                if ($i == $stop)
                {
                }
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