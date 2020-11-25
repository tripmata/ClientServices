<?php

    $ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Role->Webfront->ReadAccess)
        {

            $partner = new Partner($_REQUEST['Partnerid']);
            $partner->Salutation = $_REQUEST['Salutation'];
            $partner->Name = $_REQUEST['Name'];
            $partner->Surname = $_REQUEST['Surname'];
            $partner->Phone = $_REQUEST['Phone'];
            $partner->Email = $_REQUEST['Email'];
            $partner->Profilepic = $_REQUEST['Profilepic'];
            $partner->Gender = $_REQUEST['Gender'];
            $partner->Country = $_REQUEST['Country'];
            $partner->State = $_REQUEST['State'];
            //$partner->City = $_REQUEST['City'];
            $partner->Address = $_REQUEST['Address'];
            $partner->Status = Convert::ToBool($_REQUEST['Status']);


            $partner->Save();
            $ret->status = "success";
            $ret->data = $partner;
            $ret->message= "Partner saved successfully";
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



