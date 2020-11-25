<?php

$ret = new stdClass();
$ret->status = "failed";

if (isset($_SESSION['reservation']))
{
    $booking = new Booking($_SESSION['reservation']);

    $subtotal = 0;
    $total = 0;
    $discount = 0;
    $damage = 0;
    $partialpay = 0;

    for ($i = 0; $i < count($booking->Rooms); $i++)
    {
        $roomcat = new Roomcategory(new Subscriber($booking->Property->Databasename, $booking->Property->DatabaseUser, $booking->Property->DatabasePassword));
        $roomcat->Initialize($booking->Rooms[$i]->Roomcategory);
        $subtotal += (doubleval($roomcat->Price) * doubleval($booking->Rooms[$i]->Number));
        $total += (doubleval($roomcat->Price) * doubleval($booking->Rooms[$i]->Number));
    }

    if (($booking->Property->Damagedeposit === true) && ($booking->Property->Damagedepositamount > 0))
    {
        $total += $booking->Property->Damagedepositamount;
    }

    if ($booking->Property->Partialpayment === true)
    {
        if ($booking->Property->Partialpaypercentage === true)
        {
            $partialpay = (($booking->Property->Partialpayamount) / 100.0) * $total;
        }
        else
        {
            $partialpay = $booking->Property->Partialpayamount;
        }
    }

    $ret->status = "success";
    $ret->subtotal = $subtotal;
    $ret->total = $total;
    $ret->partial = $partialpay;
    $ret->rooms = $booking->Rooms;
    $ret->property = $booking->Property;
}
else
{
    $ret->message = "No reservations were found. Try making the reservations again. We are sorry for any inconveniences this may have caused";
}


echo json_encode($ret);