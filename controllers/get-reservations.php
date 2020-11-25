<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    if ($GLOBALS['user']->Role->Booking->ReadAccess)
    {
        $property = new Property($_REQUEST['property']);

        $page = $_REQUEST['Page'];
        $perpage = $_REQUEST['Perpage'];
        $filter = $_REQUEST['Filter'];
        $filtervalue = $_REQUEST['Filtervalue'];

        $store = [];
        $ret->data = [];

        $ret->Page = $page;
        $ret->Perpage = $perpage;

        if($filtervalue != "")
        {
            $store = Reservation::Search($property, $filtervalue);
        }
        else
        {
            if($_REQUEST['tab'] == "all")
            {
                $store = Reservation::ByProperty($property);
            }
            else if($_REQUEST['tab'] == "paid")
            {
                $store = Reservation::PaidReservation($property);
            }
            else if($_REQUEST['tab'] == "unpaid")
            {
                $store = Reservation::UnpaidReservation($property);
            }
            else if($_REQUEST['tab'] == "abandoned")
            {
                $store = Reservation::Abandoned($property);
            }
        }
        $ret->today = count(Reservation::DueToday($property));
        $ret->abandoned = count(Reservation::Abandoned($property));
        $ret->Total = count($store);

        $start = (($ret->Page - 1) * $ret->Perpage);
        $stop = (($start + $ret->Perpage) - 1);

        $x = 0;
        for ($i = $start; $i < count($store); $i++)
        {
            $ret->data[$x] = $store[$i];
            if ($i == $stop){break;}
            $x++;
        }
        $ret->status = "success";
        $ret->message = "All reservations gotten successfully";
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