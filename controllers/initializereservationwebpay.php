<?php

	$ret = new stdClass();

    $booking = new Booking($_SESSION['reservation']);
    $booking->Paidamount = doubleval($_REQUEST['amount']);
    $booking->Save();

    $customer = new Customer($GLOBALS['subscriber']);

    if(isset($_SESSION['customer_res']))
    {
        $sess = Session::Get($_SESSION['customer_res']);

        if($sess != null)
        {
            $customer->Initialize($sess->User);
        }
    }
    $payment = new Paygateway($GLOBALS['subscriber']);


    $ret->status = "success";
    $ret->data = new stdClass();
    $ret->data->Currency = $GLOBALS['subscriber']->Currency->Code;
    $ret->data->Amount = (($_REQUEST['amount']) * 100);
    $ret->data->Email = $customer->Email;
    $ret->data->Key = $payment->Paystackpublic;
    $ret->Method = "PAYSTACK";
    $ret->data->Ref = $booking->Id."-".Random::GenerateId(10);

    if($ret->data->Amount == 0)
    {
        $ret->status = null;
        $ret->status = "failed";
        $ret->message = "Invalid payment";
        Fraudlog::Log($GLOBALS['subscriber'], "Fraud detect", "Web front", "Payment initialization attempt on empty cart");
    }
    else if($customer->Id == "")
    {
        $ret->data = null;
        $ret->status = "failed";
        $ret->message = "Invalid payment";
        Fraudlog::Log($GLOBALS['subscriber'], "Fraud detect", "Web front", "Payment initialization attempt on unidentified account");
    }
    else
    {
        $ret->status = "success";
        $ret->message = "Payment initialization success";
    }

	echo json_encode($ret);