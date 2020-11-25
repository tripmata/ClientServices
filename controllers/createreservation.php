<?php

    $ret = new stdClass();

    if(isset($_SESSION['reservation']))
    {
        $booking = new Booking($_SESSION['reservation']);
        
        $subtotal = 0;
        $total = 0;
        $discount = 0;
        $damage = 0;
        $partialpay = 0;
        $roomnumber = 0;
        
        $rooms = [];

        for($i = 0; $i < count($booking->Rooms); $i++)
        {
            $roomcat = new Roomcategory(new Subscriber($booking->Property->Databasename, $booking->Property->DatabaseUser, $booking->Property->DatabasePassword));
            $roomcat->Initialize($booking->Rooms[$i]->Roomcategory);
            $subtotal += (doubleval($roomcat->Price) * doubleval($booking->Rooms[$i]->Number));
            $total += (doubleval($roomcat->Price) * doubleval($booking->Rooms[$i]->Number));
            
            $r = new stdClass();
            $r->room = $booking->Rooms[$i]->Roomcategory;
            $r->number = $booking->Rooms[$i]->Number;
            
            $roomnumber += $r->number;
            
            array_push($rooms, $r);
        }

        if(($booking->Property->Damagedeposit === true) && ($booking->Property->Damagedepositamount > 0))
        {
            $total += $booking->Property->Damagedepositamount;
        }

        if($booking->Property->Partialpayment === true)
        {
            if($booking->Property->Partialpaypercentage === true)
            {
                $partialpay = (($booking->Property->Partialpayamount) / 100.0) * $total;
            }
            else
            {
                $partialpay = $booking->Property->Partialpayamount;
            }
        }

        if(isset($_SESSION['user_token']))
        {
            $sess = Session::Get($_SESSION['user_token']);

            $customer = new Customer($GLOBALS['subscriber']);
            $customer->Initialize($sess->User);

            if ($customer->Id != "")
            {
                $reservation = new Reservation();
                $reservation->Paidamount = $booking->Paidamount;
                $reservation->Paid = $booking->Paid;
                $reservation->Property = $booking->Property;
                $reservation->Total = $total;
                $reservation->Discount = $discount;
                $reservation->Rooms = $rooms;
                $reservation->Request = $booking->Request;
                $reservation->Children = $booking->Children;
                $reservation->Adult = $booking->Adults;
                $reservation->Checkindate = $booking->Checkin;
                $reservation->Checkoutdate = $booking->Checkout;
                $reservation->Customer = $customer;

                $reservation->Save();

                $ret->data = $reservation->Bookingnumber;
                $ret->roomcount = $roomnumber;
                $ret->status = "success";

                unset($_SESSION['reservation']);
            }
            else
            {
                $ret->status = "access denied";
                $ret->message = "You do not have the required privilege to complete the operation";
            }
        }
        else
        {
            $ret->status = "login";
            $ret->data = "login";
        }
    }
    else
    {
        $ret->message = "No reservations were found. Try making the reservations again. We are sorry for any inconveniences this may have caused";
    }
    
    echo json_encode($ret);
