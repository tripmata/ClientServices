<?php

	$ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Role->Discount->WriteAccess)
        {
            $p = new Property($_REQUEST['property']);

            $coupon = new Coupon(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword));

            $coupon->Initialize($_REQUEST['id']);
            $coupon->Bypercentage = Convert::ToBool($_REQUEST['bypercent']);
            $coupon->Value = floatval($_REQUEST['value']);
            $coupon->Usecount = Convert::ToInt($_REQUEST['use']);
            $coupon->Title = $_REQUEST['name'];
            $coupon->Code = $_REQUEST['code'];
            $coupon->Expirydate = new WixDate($_REQUEST['expires']);

            if($_REQUEST['expires'] != "")
            {
                $coupon->Expires = true;
            }

            $coupon->Booking = array();
            $ar = explode(",", $_REQUEST['lodging']);
            for($i = 0; $i < count($ar); $i++)
            {
                if($ar[$i] != "")
                {
                    array_push($coupon->Booking, $ar[$i]);
                }
            }

            $coupon->Food = array();
            $ar = explode(",", $_REQUEST['food']);
            for($i = 0; $i < count($ar); $i++)
            {
                if($ar[$i] != "")
                {
                    array_push($coupon->Food, $ar[$i]);
                }
            }

            $coupon->Pastries = array();
            $ar = explode(",", $_REQUEST['bakery']);
            for($i = 0; $i < count($ar); $i++)
            {
                if($ar[$i] != "")
                {
                    array_push($coupon->Pastries, $ar[$i]);
                }
            }

            $coupon->Drinks = array();
            $ar = explode(",", $_REQUEST['bar']);
            for($i = 0; $i < count($ar); $i++)
            {
                if($ar[$i] != "")
                {
                    array_push($coupon->Drinks, $ar[$i]);
                }
            }

            $coupon->Laundry = array();
            $ar = explode(",", $_REQUEST['laundry']);
            for($i = 0; $i < count($ar); $i++)
            {
                if($ar[$i] != "")
                {
                    array_push($coupon->Laundry, $ar[$i]);
                }
            }

            $coupon->Pool = array();
            $ar = explode(",", $_REQUEST['pool']);
            for($i = 0; $i < count($ar); $i++)
            {
                if($ar[$i] != "")
                {
                    array_push($coupon->Pool, $ar[$i]);
                }
            }

            $coupon->Services = array();
            $ar = explode(",", $_REQUEST['services']);
            for($i = 0; $i < count($ar); $i++)
            {
                if($ar[$i] != "")
                {
                    array_push($coupon->Services, $ar[$i]);
                }
            }
            $coupon->Save();

            $ret->status = "success";
            $ret->message = "Coupon saved successfully";

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