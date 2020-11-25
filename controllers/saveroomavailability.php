<?php

    $p = new Property($_REQUEST['property']);

    $availabiity =  new Availability(new Subscriber($p->Databasename, $p->DatabaseUser, $p->DatabasePassword));

    $availabiity->Available = Convert::ToInt($_REQUEST['available']);
    $availabiity->Startdate = strtotime($_REQUEST['start']);
    $availabiity->Stopdate = strtotime($_REQUEST['stop']);
    $availabiity->Room = $_REQUEST['category'];

    $availabiity->Save();

    $ret = new stdClass();
    $ret->status = "success";
    $ret->message = "availability saved";
    $ret->data = $availabiity;

    echo json_encode($ret);