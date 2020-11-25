<?php

if (isset($_POST['user']) && isset($_POST['password'])) :

    $cred = strtolower(trim($_POST['user']));
    $password = $_POST['password'];
    $platform = $_REQUEST['platform'];

    $ret = new stdClass();

    if (User::isSuperAdmin($cred, $password))
    {
        $token = Random::GenerateId(32);
        while(isset($_SESSION[$token]) || Session::Exist($token))
        {
            $token = Random::GenerateId(32);
        }
        $_SESSION[$token] = "adxc0";
        Session::Start($token, "adxc0");

        $ret->status = "success";
        $ret->data = $token;
        $ret->type = "super admin";
        $ret->message = 'login was successfull';
    }
    else
    {
        $user ="";
        if ($customer->GetPassword() == $password)
        {
            $cUser = new stdClass();

            $ret = new stdClass();
            $ret->Status = "success";
            $ret->data = "super admin";
            $ret->Message = "Customer logged in successfully";

            $context = Context::Create($customer);
            $event = new Event(Event::CustomerLoggedIn, $context);
            Event::Fire($event);
        }
        else
        {
            $ret = ["status" => "failed", "message" => "Invalid credential"];
        }

        $ret = ["status" => "failed", "message" => "Invalid credential"];
    }

    echo json_encode($ret);

endif;