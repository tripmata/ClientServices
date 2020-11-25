<?php

$ret = new stdClass();

if (isset($_SESSION['user_token']))
{
    $sess = Session::Get($_SESSION['user_token']);

    $customer = new Customer($GLOBALS['subscriber']);
    $customer->Initialize($sess->User);

    if ($customer->Id != "")
    {
        $month = $_REQUEST['month'];
        $year = $_REQUEST['year'];

        $item = $_REQUEST['item'];
        $item_type = $_REQUEST['item_type'];

        if ($item_type === "property")
        {
            $trans  = Propertytransaction::spanTransaction($month, $year, $item);
            $ret->data = Transactions::Breakdown($trans);

            $payment = new Withdrawal();
            $payment->Amount = $ret->data->Unpaid;
            $payment->Item = $item;
            $payment->Itemtype = "property";
            $payment->Month = $month;
            $payment->Year = $year;
            $payment->Save();
        }
        else if($item_type === "vehicle")
        {
            $trans  = Vehicletransaction::spanTransaction($month, $year, $item);
            $ret->data = Transactions::Breakdown($trans);

            $payment = new Withdrawal();
            $payment->Amount = $ret->data->Unpaid;
            $payment->Item = $item;
            $payment->Itemtype = "vehicle";
            $payment->Month = $month;
            $payment->Year = $year;
            $payment->Save();
        }
        else
        {
            $trans  = Leasetransaction::spanTransaction($month, $year, $item);
            $ret->data = Transactions::Breakdown($trans);

            $payment = new Withdrawal();
            $payment->Amount = $ret->data->Unpaid;
            $payment->Item = $item;
            $payment->Itemtype = "leased-property";
            $payment->Month = $month;
            $payment->Year = $year;
            $payment->Save();
        }
        $ret->status = "success";
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

echo json_encode($ret);