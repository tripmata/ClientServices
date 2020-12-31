<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    if ($GLOBALS['user']->Role->Messaging->ReadAccess)
    {
        $ret->data = [];

        $list = [];

        $contacts = explode(",", $_REQUEST['primers']);

        for($i = 0; $i < count($contacts); $i++)
        {
            if ($contacts[$i] != "")
            {
                if ($contacts[$i] == "customers")
                {
                    $list = CustomerByProperty::All($GLOBALS['subscriber']);

                    for ($j = 0; $j < count($list); $j++)
                    {
                        $con = new stdClass();
                        $con->id = $list[$j]->Id;
                        $con->name = $list[$j]->Name;
                        $con->surname = $list[$j]->Surname;
                        $con->phone = $list[$j]->Phone;
                        $con->email = $list[$j]->InternalEmail;
                        $con->type = $list[$j]->Type;
                        $con->messageType = 'internal';

                        array_push($ret->data, $con);
                    }
                }

                if ($contacts[$i] == "staff")
                {
                    $list = Staff::All($GLOBALS['subscriber']);

                    for ($j = 0; $j < count($list); $j++)
                    {
                        $con = new stdClass();
                        $con->id = $list[$j]->Id;
                        $con->name = $list[$j]->Name;
                        $con->surname = $list[$j]->Surname;
                        $con->phone = $list[$j]->Phone;
                        $con->email = $list[$j]->Email;
                        $con->type = $list[$j]->Type; 
                        $con->messageType = 'external';

                        array_push($ret->data, $con);
                    }
                }

                if($contacts[$i] == "guests")
                {
                    $list = CustomerByProperty::All($GLOBALS['subscriber']);

                    for($j = 0; $j < count($list); $j++)
                    {
                        $con = new stdClass();
                        $con->id = $list[$j]->Id;
                        $con->name = $list[$j]->Name;
                        $con->surname = $list[$j]->Surname;
                        $con->phone = $list[$j]->Phone;
                        $con->email = $list[$j]->InternalEmail;
                        $con->type = $list[$j]->Type;
                        $con->messageType = 'internal';

                        array_push($ret->data, $con);
                    }
                }
                
                if($contacts[$i] == "subscribers")
                {
                    $list = Contact::All($GLOBALS['subscriber']);

                    for($j = 0; $j < count($list); $j++)
                    {
                        $con = new stdClass();
                        $con->id = $list[$j]->Id;
                        $con->name = $list[$j]->Name;
                        $con->surname = $list[$j]->Surname;
                        $con->phone = $list[$j]->Phone;
                        $con->email = $list[$j]->Email;
                        $con->type = $list[$j]->Type;
                        $con->messageType = 'external';

                        array_push($ret->data, $con);
                    }
                }

                if($contacts[$i] == "contactus")
                {
                    $list = Message::All($GLOBALS['subscriber']);

                    for($j = 0; $j < count($list); $j++)
                    {
                        $con = new stdClass();
                        $con->id = $list[$j]->Id;
                        $con->name = $list[$j]->Name;
                        $con->surname = $list[$j]->Surname;
                        $con->phone = $list[$j]->Phone;
                        $con->email = $list[$j]->Email;
                        $con->type = $list[$j]->Type;
                        $con->messageType = 'external';

                        array_push($ret->data, $con);
                    }
                }

                if($contacts[$i] == "in-house-guest")
                {
                    $list = Lodging::All($GLOBALS['subscriber'], true);

                    for($j = 0; $j < count($list); $j++)
                    {
                        if (count($list[$j]->Checkouts) == 0) :

                            $con = new stdClass();
                            $customer = $list[$j]->Guest;
                            $con->id = $customer->Id;
                            $con->name = $customer->Name;
                            $con->surname = $customer->Surname;
                            $con->phone = $customer->Phone;
                            $con->email = $customer->InternalEmail;
                            $con->type = $customer->Type;
                            $con->messageType = 'internal';

                            array_push($ret->data, $con);

                        endif;
                    }
                }

                if(($contacts[$i] != "customers") && ($contacts[$i] != "staff") &&
                    ($contacts[$i] != "guests") && ($contacts[$i] != "subscribers") &&
                    ($contacts[$i] != "contactus") &&
                    ($contacts[$i] != "in-house-guest"))
                {
                    $c = new Contactcollection($GLOBALS['subscriber']);
                    $c->Initialize($contacts[$i]);

                    $list = $c->Getitems();

                    for($j = 0; $j < count($list); $j++)
                    {
                        if (isset($list[$j])) :

                            $con = new stdClass();
                            $con->id = $list[$j]->Id;
                            $con->name = $list[$j]->Type != "supplier" ?  $list[$j]->Name :
                                ($list[$j]->Company == "" ? $list[$j]->Contactperson : $list[$j]->Company);
                            $con->surname = $list[$j]->Type != "supplier" ?  $list[$j]->Surname : "";
                            $con->phone = $list[$j]->Phone;
                            $con->email = $list[$j]->Email;
                            $con->type = $list[$j]->Type;
                            $con->messageType = 'external';

                            array_push($ret->data, $con);

                        endif;
                    }
                }
            }
        }

        $ret->status = "success";
        $ret->message = "Custom list retrieved successfully";
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