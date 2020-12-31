<?php

$ret = new stdClass();
$ret->status = "success";

if (isset($_REQUEST['property'])) :

    $availabiity =  new Availability(new Subscriber());

    $availabiity->Available = Convert::ToInt($_REQUEST['available']);
    $availabiity->Startdate = strtotime($_REQUEST['start']);
    $availabiity->Stopdate = strtotime($_REQUEST['stop']);
    $availabiity->Room = $_REQUEST['category'];

    $availabiity->Save();

    $ret->message = "availability saved";
    $ret->data = $availabiity;


else:

    $ret->status = 'error';
    $ret->message = 'Missing Property in request';

endif;

echo json_encode($ret);