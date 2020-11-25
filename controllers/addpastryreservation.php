<?php

$ret = new stdClass();

$customer = new Customer($GLOBALS['subscriber']);

$pastry = new Pastry($GLOBALS['subscriber']);
$pastry->Initialize($_REQUEST['pastry']);

$cart = new Cart($GLOBALS['subscriber']);

$list = $cart->GetOrderlist();

if(isset($_REQUEST['custsess']))
{
    $customer->Initialize($_REQUEST['custsess']);
}

if($list->Hasroom() === true)
{
    if(($pastry->Id != "") && (Convert::ToInt($_REQUEST['quantity'])))
    {
        $pastryorder = new Pastryorder($GLOBALS['subscriber']);
        $pastryorder->Pastry = $pastry;
        $pastryorder->Quantity = Convert::ToInt($_REQUEST['quantity']);
        $pastryorder->Immediate = false;
        $pastryorder->Orderdate = new WixDate($_REQUEST['date']);
        $pastryorder->Ordermin = Convert::ToInt($_REQUEST['mins']);
        $pastryorder->Orderhour = Convert::ToInt($_REQUEST['hour']);
        $pastryorder->Ordergmt = $_REQUEST['gmt'];


        $inrange = false;
        $span = $list->Lodgingrange();

        if(($span->Start <= $pastryorder->Orderdate->getValue()) && ($span->Stop >= $pastryorder->Orderdate->getValue()))
        {
            $cart->Addorder($pastryorder);

            $ret = $cart->Generatereply();
            $ret->Content->Data->Cartcount = $cart->Contentcount();
            $ret->status = "success";

            $ret->Content->Data->root = Router::ResolvePath('', $path);
            $ret->Content->Data->modules = new Modules($GLOBALS['subscriber']);
        }
        else
        {
            $ret->status = "out of range";
            $ret->message = "Order has to be within the period of your stay at the hotel. Your selected date is out of range.";
        }
    }
    else
    {
        $ret->status = "failed";
        $ret->message = "Invalid pastry selected or invalid quantity requested";
        Fraudlog::Log($GLOBALS['subscriber'], "Fraud detected", "Client portal", "Attempt to order pastry");
    }
}
else
{
    $ret->status = "failed";
    $ret->message = "You have to be a lodging customer to complete the order. Log in and try again";
    Fraudlog::Log($GLOBALS['subscriber'], "Fraud detected", "Client portal", "Attempt to order pastry");
}

echo json_encode($ret);