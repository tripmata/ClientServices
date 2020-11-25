<?php

$ret = new stdClass();

$customer = new Customer($GLOBALS['subscriber']);

if(isset($_REQUEST['custsess']))
{
    $customer->Initialize($_REQUEST['custsess']);
}

if($customer->Id != "")
{
    $reservation = new Reservation($GLOBALS['subscriber']);
    $reservation->Initialize($_REQUEST['reservation']);

    if($reservation->Id != "")
    {
        if($reservation->Customer->Id == $customer->Id)
        {
            $reservation->Delete();
            $ret->status = "success";
            $ret->message = "Reservation deleted";

            $context = Context::Create($customer);
            $event = new Event($GLOBALS['subscriber'], Event::CustomerCancelsReservation, $context);
            Event::Fire($event);
        }
        else
        {
            $ret->status = "failed";
            $ret->message = "You do not have the required access to delete the reservation";
            Fraudlog::Log($GLOBALS['subscriber'], "Fraud detected", "User account",
                "Anonymous trying to delete ".$reservation->Customer->Name." ".$reservation->Customer->Surname."' reservation");
        }
    }
    else
    {
        $ret->status = "failed";
        $ret->message = "Invalid reservation. Try reloading the page to fix error";
    }
}

echo json_encode($ret);