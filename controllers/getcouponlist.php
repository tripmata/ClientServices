<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    if ($GLOBALS['user']->Role->Discount->ReadAccess)
    {
        $ret->status = "success";
        $ret->data = array();

        $page = $_REQUEST['Page'];
        $perpage = $_REQUEST['Perpage'];
        $filter = $_REQUEST['Filter'];
        $filtervalue = $_REQUEST['Filtervalue'];

        $store = array();

        $ret->Page = $page;
        $ret->Perpage = $perpage;

        $p = new Property($_REQUEST['property']);

        if($_REQUEST['usestatus'] == "expired")
        {
            $store = Coupon::Expiredcoupon(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword), $filtervalue);
        }
        else if($_REQUEST['usestatus'] == "used")
        {
            $store = Coupon::Usedcoupon(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword), $filtervalue);
        }
        else if($_REQUEST['usestatus'] == "unused")
        {
            $store = Coupon::Unusedcoupon(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword), $filtervalue);
        }
        else
        {
            $store = Coupon::Search(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword), $filtervalue);
        }

        $ret->Total = count($store);

        $ret->Usedcount = Coupon::Usedcount(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword));
        $ret->Expiredcount = Coupon::Expiredcount(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword));
        $ret->Unusedcount = Coupon::Unusedcount(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword));
        $ret->Allcount = Coupon::Countall(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword));

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
        $ret->message = "You do not have the required privilege to complete the operation";
    }
}
else
{
    $ret->status = "login";
    $ret->data = "login & try again";
}

echo json_encode($ret);