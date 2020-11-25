<?php

	$ret = new stdClass();


        $cart = new Cart($GLOBALS['subscriber']);
        $orderlist = $cart->GetOrderlist();

        $customer = new Customer($GLOBALS['subscriber']);

        if(isset($_REQUEST['custsess']))
        {
            $customer->Initialize($_REQUEST['custsess']);
        }

        if($customer->Id != "")
        {
            $reservation = $orderlist->toReservation($customer);

            if($reservation != null)
            {
                $ret->status = "success";
                $ret->data = new stdClass();
                $ret->data->Reservation = $reservation;
                $ret->data->root = Router::ResolvePath("", $path);
            }
            else
            {
                $ret->status = "failed";
                $ret->message = "Unable to save reservation. Try reloading the page";
            }
        }
        else
        {
            $ret->status = "failed";
            $ret->message ="Unable to find customer's account. Try reloading the page";
        }

	echo json_encode($ret);