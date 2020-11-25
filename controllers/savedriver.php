<?php

    $ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Role->Webfront->ReadAccess)
        {
            $driver = new Driver($_REQUEST['Driverid']);
            $driver->Name = $_REQUEST['Name'];
            $driver->Surname = $_REQUEST['Surname'];
            $driver->Phone = $_REQUEST['Phone'];
            $driver->Email = $_REQUEST['Email'];
            $driver->Password = $_REQUEST['Password'];
            $driver->Profilepic = $_REQUEST['Profilepic'];
            $driver->Gender = $_REQUEST['Gender'];
            $driver->Dob = strtotime($_REQUEST['Dob']);
            $driver->Address = $_REQUEST['Address'];
            $driver->City = $_REQUEST['City'];
            $driver->State = $_REQUEST['State'];
            $driver->Available = Convert::ToBool($_REQUEST['Available']);
            $driver->Status = Convert::ToBool($_REQUEST['Status']);
            $driver->Save();

            $ret->status = "success";
            $ret->data = $driver;
            $ret->message= "driver saved";
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
