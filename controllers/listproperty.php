<?php

    $ret = new stdClass();

    if(isset($_SESSION['user_token']))
    {
        $sess = Session::Get($_SESSION['user_token']);

        $customer = new Customer($GLOBALS['subscriber']);
        $customer->Initialize($sess->User);

        if($customer->Id != "")
        {
            $property = new Property();
            $property->Name = $_REQUEST['name'];
            $property->Phone1 = $_REQUEST['phone1'];
            $property->Phone2 = $_REQUEST['phone2'];
            $property->Email1 = $_REQUEST['email1'];
            $property->Email2 = $_REQUEST['email2'];
            $property->Type = $_REQUEST['type'];
            $property->State = $_REQUEST['state'];
            $property->Statename = $_REQUEST['statename'];
            $property->Cityname = $_REQUEST['cityname'];
            $property->City = $_REQUEST['city'];
            $property->Description = $_REQUEST['description'];
            $property->Address = $_REQUEST['address'];
            $property->Tandc = $_REQUEST['tandc'];

            $property->Cashonly = Convert::ToBool($_REQUEST['cashonly']);
            $property->Formtype = $_REQUEST['formType'];
            $property->Cancellation = Convert::ToBool($_REQUEST['cancellation']);
            $property->Canceldays = Convert::ToInt($_REQUEST['canceldays']);
            $property->Cancelhours = Convert::ToInt($_REQUEST['cancelhour']);
            $property->Damagedeposit = Convert::ToBool($_REQUEST['damagedeposit']);
            $property->Damagedepositamount = doubleval($_REQUEST['damageamount']);
            $property->Earlycheckout = Convert::ToBool($_REQUEST['earlycheckout']);
            $property->Partialpayment = Convert::ToBool($_REQUEST['partialpayment']);
            $property->Partialpayamount = doubleval($_REQUEST['partialpayamount']);
            $property->Partialpaypercentage = Convert::ToBool($_REQUEST['percialpaypercent']);
            $property->Childpolicy = $_REQUEST['childpolicy'];
            $property->Banner = $_REQUEST['banner'];

            $property->Owner = $customer;

            $property->Rules = [];

            $rules = explode(",", $_REQUEST['rules']);

            for($i = 0; $i < count($rules); $i++)
            {
                if($rules[$i] != "")
                {
                    array_push($property->Rules, $rules[$i]);
                }
            }


            $images = explode(",", $_REQUEST['images']);
            $property->Gallery = [];

            if(count($images) > 0)
            {
                $property->Banner = $images[0];
            }

            for($i = 1; $i < count($images); $i++)
            {
                if($images[$i] != "")
                {
                    array_push($property->Gallery, $images[$i]);
                }
            }

            $property->Facilities = [];
            $f = explode(",", $_REQUEST['facilities']);
            for($i = 0; $i < count($f); $i++)
            {
                if($f[$i] !== "")
                {
                    array_push($property->Facilities, $f[$i]);
                }
            }

            $property->Rules = [];
            $r = explode(",", $_REQUEST['rules']);
            for($i = 0; $i < count($r); $i++)
            {
                if($r[$i] !== "")
                {
                    array_push($property->Rules, $r[$i]);
                }
            }

            $property->Checkouth = Convert::ToInt($_REQUEST['checkoutH']);
            $property->Checkoutmin = Convert::ToInt($_REQUEST['checkoutM']);
            $property->Checkinh = Convert::ToInt($_REQUEST['checkinH']);
            $property->Checkinm = Convert::ToInt($_REQUEST['checkinM']);

            $property->Meta = Router::BuildMeta($property->Name."-".$property->Type."-".$property->Cityname."-".$property->Statename);

            $property->Approved = false;

            $property->Save();
            $ret->status = "success";
            $ret->data = $property;
            $ret->message= "Property saved successfully";
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
