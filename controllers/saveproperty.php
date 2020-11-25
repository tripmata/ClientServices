<?php

    $ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Role->Webfront->ReadAccess)
        {
            $property = new Property($_REQUEST['Propertyid']);
            $property->Name = $_REQUEST['Name'];
            $property->Phone1 = $_REQUEST['Phone1'];
            $property->Phone2 = $_REQUEST['Phone2'];
            $property->Email1 = $_REQUEST['Email1'];
            $property->Email2 = $_REQUEST['Email2'];
            $property->Type = $_REQUEST['Type'];
            $property->State = $_REQUEST['State'];
            $property->City = $_REQUEST['City'];
            $property->Description = $_REQUEST['Description'];
            $property->Address = $_REQUEST['Address'];
            $property->Tandc = $_REQUEST['Tandc'];
            $property->Images = [];

            $images = explode(",", $_REQUEST['Images']);
            for($i = 0; $i < count($images); $i++)
            {
                if($images[$i] != "")
                {
                    array_push($property->Images, $images[$i]);
                }
            }

            $property->Wifi = Convert::ToBool($_REQUEST['Wifi']);
            $property->Parking = Convert::ToBool($_REQUEST['Parking']);
            $property->Gym = Convert::ToBool($_REQUEST['Gym']);
            $property->Restaurant = Convert::ToBool($_REQUEST['Restaurant']);
            $property->Bar = Convert::ToBool($_REQUEST['Bar']);
            $property->Security = Convert::ToBool($_REQUEST['Security']);
            $property->Status = Convert::ToBool($_REQUEST['Status']);

            $property->Save();
            $ret->status = "success";
            $ret->data = $property;
            $ret->message= "Property saved succesfully";
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
