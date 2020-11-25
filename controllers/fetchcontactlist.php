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
                    $list = Customer::All($GLOBALS['subscriber']);

                    for ($j = 0; $j < count($list); $j++)
                    {
                        $con = new stdClass();
                        $con->id = $list[$j]->Id;
                        $con->name = $list[$j]->Name;
                        $con->surname = $list[$j]->Surname;
                        $con->phone = $list[$j]->Phone;
                        $con->email = $list[$j]->Email;
                        $con->type = $list[$j]->Type;

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

                        array_push($ret->data, $con);
                    }
                }
                if($contacts[$i] == "guests")
                {
                    $list = Guest::All($GLOBALS['subscriber']);

                    for($j = 0; $j < count($list); $j++)
                    {
                        $con = new stdClass();
                        $con->id = $list[$j]->Id;
                        $con->name = $list[$j]->Name;
                        $con->surname = $list[$j]->Surname;
                        $con->phone = $list[$j]->Phone;
                        $con->email = $list[$j]->Email;
                        $con->type = $list[$j]->Type;

                        array_push($ret->data, $con);
                    }

                    $list = Subguest::All($GLOBALS['subscriber']);
                    for($j = 0; $j < count($list); $j++)
                    {
                        $con = new stdClass();
                        $con->id = $list[$j]->Id;
                        $con->name = $list[$j]->Name;
                        $con->surname = $list[$j]->Surname;
                        $con->phone = $list[$j]->Phone;
                        $con->email = $list[$j]->Email;
                        $con->type = $list[$j]->Type;

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

                        array_push($ret->data, $con);
                    }
                }

                if(($contacts[$i] != "customers") && ($contacts[$i] != "staff") &&
                    ($contacts[$i] != "guests") && ($contacts[$i] != "subscribers") &&
                    ($contacts[$i] != "contactus"))
                {
                    $c = new Contactcollection($GLOBALS['subscriber']);
                    $c->Initialize($contacts[$i]);

                    $list = $c->Getitems();

                    for($j = 0; $j < count($list); $j++)
                    {
                        $con = new stdClass();
                        $con->id = $list[$j]->Id;
                        $con->name = $list[$j]->Type != "supplier" ?  $list[$j]->Name :
                            ($list[$j]->Company == "" ? $list[$j]->Contactperson : $list[$j]->Company);
                        $con->surname = $list[$j]->Type != "supplier" ?  $list[$j]->Surname : "";
                        $con->phone = $list[$j]->Phone;
                        $con->email = $list[$j]->Email;
                        $con->type = $list[$j]->Type;

                        array_push($ret->data, $con);
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