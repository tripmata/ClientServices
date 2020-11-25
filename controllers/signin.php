<?php

    $user = trim(strtolower($_REQUEST['user']));
    $password = md5($_REQUEST['password']);

    $args = [];
    $a = explode(",", $_REQUEST['args']);
    for($i = 0; $i < count($a); $i++)
    {
        if($a[$i] != "")
        {
            array_push($args, $a[$i]);
        }
    }

    $customer = Customer::ByEmail($GLOBALS['subscriber'], $user);

    $ret = new stdClass();

    if($customer->Id != "")
    {
        if($customer->GetPassword() == $password)
        {
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
            $ret->message = 'signing in was successful';
        }
        else
        {
            $ret->status = "failed";
            $ret->message = "Invalid credentials";
        }
    }
    else
    {
        $ret->status = "failed";
        $ret->message = "Invalid credentials";
    }
    echo json_encode($ret);
