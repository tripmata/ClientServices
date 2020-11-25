<?php

    $ret = new stdClass();

        $d = explode(" ", $_REQUEST['names']);

        $driver = new Driver();
        $driver->Name = $d[0];
        $driver->Surname = count($d) > 1 ? $d[1] : "";
        $driver->Phone = $_REQUEST['phone'];
        $driver->Email = $_REQUEST['email'];
        $driver->Password = '';
        $driver->Profilepic = "";
        $driver->Gender = $_REQUEST['sex'];
        $driver->Dob = strtotime($_REQUEST['dob']);
        $driver->Address = $_REQUEST['address'];
        $driver->City = $_REQUEST['city'];
        $driver->State = $_REQUEST['state'];
        $driver->Available = false;
        $driver->Status = true;
        $driver->Save();

        $ret->status = "success";
        $ret->data = $driver->Id;
        $ret->message= "driver saved";

    echo json_encode($ret);
