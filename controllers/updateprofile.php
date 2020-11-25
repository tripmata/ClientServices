<?php

	$ret = new stdClass();

	echo json_encode($_REQUEST['token']);
	die();


    $customer = new Customer($GLOBALS['subscriber']);

    if(isset($_REQUEST['custsess']))
    {
        $customer->Initialize($_REQUEST['custsess']);
    }

    if($customer->Id != "")
    {
        if($_REQUEST['name'] != "")
        {
            $customer->Name = $_REQUEST['name'];
        }
        if($_REQUEST['sname'] != "")
        {
            $customer->Surname = $_REQUEST['sname'];
        }
        if($_REQUEST['dob'] != "")
        {
            $d = new WixDate($_REQUEST['dob']);

            $customer->Dateofbirth = $d;
            $customer->Monthofbirth = $d->Month;
            $customer->Dayofbirth = $d->Day;
        }
        if($_REQUEST['state'] != "")
        {
            $customer->State = $_REQUEST['state'];
        }
        if($_REQUEST['country'] != "")
        {
            $customer->Country = $_REQUEST['country'];
        }
        if($_REQUEST['street'] != "")
        {
            $customer->Street = $_REQUEST['street'];
        }
        if($_REQUEST['occupation'] != "")
        {
            $customer->Occupation = $_REQUEST['occupation'];
        }
        if($_REQUEST['kin_name'] != "")
        {
            $customer->Kinname = $_REQUEST['kin_name'];
        }
        if($_REQUEST['kin_address'] != "")
        {
            $customer->Kinaddress = $_REQUEST['kin_address'];
        }
        $customer->Save();

        $ret->status = "success";
        $ret->message = "Profile saved successfully";

        $context = Context::Create($customer);
        $event = new Event($GLOBALS['subscriber'], Event::CustomerUpdatesInfo, $context);
        Event::Fire($event);
    }
    else
    {
        $ret->status = "failed";
        $ret->message = "Invalid customer account";
        Fraudlog::Log($GLOBALS['subscriber'], "Fraud detected", "User Account", "Attempt to update user profile image");
    }

	echo json_encode($ret);