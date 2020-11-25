<?php

$ret = new stdClass();

$customer = new Customer($GLOBALS['subscriber']);

$food = new Food($GLOBALS['subscriber']);
$food->Initialize($_REQUEST['food']);

$cart = new Cart($GLOBALS['subscriber']);

$list = $cart->GetOrderlist();

if(isset($_REQUEST['custsess']))
{
    $customer->Initialize($_REQUEST['custsess']);
}

if($list->Hasroom() === true)
{
    if(($food->Id != "") && (Convert::ToInt($_REQUEST['quantity'])))
    {
        $foodorder = new Foodorder($GLOBALS['subscriber']);
        $foodorder->Food = $food;
        $foodorder->Quantity = Convert::ToInt($_REQUEST['quantity']);
        $foodorder->Immediate = false;
        $foodorder->Orderdate = new WixDate($_REQUEST['date']);
        $foodorder->Ordermin = Convert::ToInt($_REQUEST['mins']);
        $foodorder->Orderhour = Convert::ToInt($_REQUEST['hour']);
        $foodorder->Ordergmt = $_REQUEST['gmt'];


        $inrange = false;
        $span = $list->Lodgingrange();

        if(($span->Start <= $foodorder->Orderdate->getValue()) && ($span->Stop >= $foodorder->Orderdate->getValue()))
        {
            $cart->Addorder($foodorder);

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
        $ret->message = "Invalid food selected or invalid quantity requested";
        Fraudlog::Log($GLOBALS['subscriber'], "Fraud detected", "Client portal", "Attempt to order food");
    }
}
else
{
    $ret->status = "failed";
    $ret->message = "You have to be a lodging customer to complete the order. Log in and try again";
    Fraudlog::Log($GLOBALS['subscriber'], "Fraud detected", "Client portal", "Attempt to order food");
}

echo json_encode($ret);