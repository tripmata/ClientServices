<?php

    $ret = new stdClass();

    $booking = new Booking();
    $booking->Property = new Property($_REQUEST['property']);
    $booking->Checkin = strtotime($_REQUEST['checkin']);
    $booking->Checkout = strtotime($_REQUEST['checkout']);
    $booking->Adults = Convert::ToInt($_REQUEST['adult']);
    $booking->Children = Convert::ToInt($_REQUEST['children']);
    $booking->Rooms = [];
    
    $booking->Total = 0;

    $rooms = explode(",", $_REQUEST['rooms']);

    for($i = 0; $i < count($rooms); $i++)
    {
        $r = explode(":", $rooms[$i]);

        $d = new Roombooking();
        $d->Roomcategory = $r[0];
        $d->Number = Convert::ToInt($r[1]);
        $d->Save();

        array_push($booking->Rooms, $d);
    }

    $booking->Save();
    $_SESSION['reservation'] = $booking->Id;

    $ret->status = "success";
    $ret->data = $booking->Id;
    $ret->message = "Room added successfully";

    echo json_encode($ret);