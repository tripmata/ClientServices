<?php

$ret = new stdClass();
$ret->status = 'error';
$ret->message = 'Please login & try again';

if ($GLOBALS['user']->Id != "")
{
    if ($GLOBALS['user']->Role->Booking->ReadAccess && isset($_REQUEST['id']))
    {
        // load reservation
        $reservation = new Reservation($_REQUEST['id']);

        if ($reservation->Id != "")
        {
            // change status
            $ret->status = 'success';

            // Load DB
            $db = DB::GetDB();

            // fetch reservation info
            $query = $db->query("SELECT * FROM reservation WHERE reservationid = '{$reservation->Id}'")->fetch_assoc();

            // complete no show process
            if ($reservation->IsOnline)
            {
                // wait for super admin
                $db->query("UPDATE reservation SET isApprovedByPartnerAdmin = 1 WHERE reservationid = '{$reservation->Id}'");

                // good
                $ret->message = 'Waiting for Confirmation';
            }
            else
            {
                if (intval($query['isConfirmedByGuest']) == 1)
                {
                    // complete no show
                    $db->query("UPDATE reservation SET noshow = 1, isApprovedByPartnerAdmin = 1 WHERE reservationid = '{$reservation->Id}'");

                    // good
                    $ret->message = 'No Show Approved';
                }
                else
                {
                    // wait for guest
                    $db->query("UPDATE reservation SET isApprovedByPartnerAdmin = 1 WHERE reservationid = '{$reservation->Id}'");

                    // good
                    $ret->message = 'Waiting for Confirmation';
                }
            }
        }
        else
        {
            $ret->status = "failed";
            $ret->message = "Invalid reservation.";
        }
    }
}

// print
echo json_encode($ret);