<?php

$args = [];
$a = explode(",", $_REQUEST['args']);

for($i = 0; $i < count($a); $i++)
{
    if($a[$i] != "")
    {
        array_push($args, $a[$i]);
    }
}

$ret = new stdClass();

if(Customer::EmailExist($_REQUEST['email'], $GLOBALS['subscriber']))
{
    $ret->status = "failed";
    $ret->message = "Email have been used";
}
else if(Customer::PhoneExist($_REQUEST['phone'], $GLOBALS['subscriber']))
{
    $ret->status = "failed";
    $ret->message = "Phone number have been used";
}
else
{
    $customer = new Customer($GLOBALS['subscriber']);

    $names = explode(" ", $_REQUEST['names']);
    $customer->Name = $names[0];
    $customer->Surname = $names[1];
    $customer->Phone = $_REQUEST['phone'];
    $customer->Email = trim(strtolower($_REQUEST['email']));
    $customer->SetPassword(md5($_REQUEST['password']));

    $customer->Save();

    $ret->data = new stdClass();
    $ret->data->url = System::getURL() . (count($args) > 0 ? "/" : "").Writer::Concat($args, "/");
    $ret->data->type = "customer";

    $token = Random::GenerateId(32);
    while(isset($_SESSION[$token]) || Session::Exist($token))
    {
        $token = Random::GenerateId(32);
    }

    Session::Start($token, $customer->Id);
    $_SESSION['user_token'] = $token;

    $ret->status = "success";
    $ret->data->token = $token;
    $ret->message = 'Account creation was successfully';
}

echo json_encode($ret);
