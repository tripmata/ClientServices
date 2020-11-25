<?php

	$ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Role->Discount->WriteAccess)
        {
            $p = new Property($_REQUEST['property']);

            $discount = new Discount(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword));
            $discount->Initialize($_REQUEST['id']);
            $discount->Bypercentage = Convert::ToBool($_REQUEST['bypercent']);
            $discount->Value = floatval($_REQUEST['value']);
            $discount->Name = $_REQUEST['name'];

            $discount->Booking = array();
            $ar = explode(",", $_REQUEST['lodging']);
            for($i = 0; $i < count($ar); $i++)
            {
                if($ar[$i] != "")
                {
                    array_push($discount->Booking, $ar[$i]);
                }
            }

            $discount->Food = array();
            $ar = explode(",", $_REQUEST['food']);
            for($i = 0; $i < count($ar); $i++)
            {
                if($ar[$i] != "")
                {
                    array_push($discount->Food, $ar[$i]);
                }
            }

            $discount->Pastries = array();
            $ar = explode(",", $_REQUEST['bakery']);
            for($i = 0; $i < count($ar); $i++)
            {
                if($ar[$i] != "")
                {
                    array_push($discount->Pastries, $ar[$i]);
                }
            }

            $discount->Drinks = array();
            $ar = explode(",", $_REQUEST['bar']);
            for($i = 0; $i < count($ar); $i++)
            {
                if($ar[$i] != "")
                {
                    array_push($discount->Drinks, $ar[$i]);
                }
            }

            $discount->Laundry = array();
            $ar = explode(",", $_REQUEST['laundry']);
            for($i = 0; $i < count($ar); $i++)
            {
                if($ar[$i] != "")
                {
                    array_push($discount->Laundry, $ar[$i]);
                }
            }

            $discount->Pool = array();
            $ar = explode(",", $_REQUEST['pool']);
            for($i = 0; $i < count($ar); $i++)
            {
                if($ar[$i] != "")
                {
                    array_push($discount->Pool, $ar[$i]);
                }
            }

            $discount->Services = array();
            $ar = explode(",", $_REQUEST['services']);
            for($i = 0; $i < count($ar); $i++)
            {
                if($ar[$i] != "")
                {
                    array_push($discount->Services, $ar[$i]);
                }
            }

            $discount->Status = Convert::ToBool($_REQUEST['status']);
            $discount->Autoapply = Convert::ToBool($_REQUEST['autoapply']);
            $discount->Fromamount = floatval($_REQUEST['fromamount']);
            $discount->Toamount = floatval($_REQUEST['toamount']);
            $discount->Fromcount = Convert::ToInt($_REQUEST['fromcount']);
            $discount->Tocount =Convert::ToInt($_REQUEST['tocount']);
            $discount->Fromhour = Convert::ToInt($_REQUEST['fromhour']);
            $discount->Tohour = Convert::ToInt($_REQUEST['tohour']);
            $discount->Fromminuite = Convert::ToInt($_REQUEST['fromminuite']);
            $discount->Tominuite = Convert::ToInt($_REQUEST['tominuite']);
            $discount->Fromday = Convert::ToInt($_REQUEST['fromday']);
            $discount->Today = Convert::ToInt($_REQUEST['today']);
            $discount->Frommonth = $_REQUEST['frommonth'];
            $discount->Tomonth = $_REQUEST['tomonth'];
            $discount->Frommeridean = $_REQUEST['frommeridean'];
            $discount->Tomeridean = $_REQUEST['tomeridean'];
            $discount->Isstaff = Convert::ToBool($_REQUEST['isstaff']);
            $discount->Periodic = Convert::ToBool($_REQUEST['periodic']);
            $discount->Timebased = Convert::ToBool($_REQUEST['timebased']);
            $discount->Bookingcount = Convert::ToBool($_REQUEST['bookingcount']);
            $discount->Formerorder = Convert::ToBool($_REQUEST['formerorder']);
            $discount->Onlineorder = Convert::ToBool($_REQUEST['onlineorder']);
            $discount->Offlineorder = Convert::ToBool($_REQUEST['offlineorder']);
            $discount->Quantity = Convert::ToBool($_REQUEST['quantity']);
            $discount->Bookedroom = Convert::ToBool($_REQUEST['bookedroom']);
            $discount->Bookeddays = Convert::ToBool($_REQUEST['bookeddays']);
            $discount->Amountbased = Convert::ToBool($_REQUEST['amountbased']);

            $discount->Ontotal = Convert::ToBool($_REQUEST['ontotal']);


            $discount->Save();

            $ret->status = "success";
            $ret->message = "Discount saved successfully";
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