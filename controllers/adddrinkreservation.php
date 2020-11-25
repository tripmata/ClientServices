<?php

$ret = new stdClass();

$customer = new Customer($GLOBALS['subscriber']);

$drink = new Drink($GLOBALS['subscriber']);
$drink->Initialize($_REQUEST['drink']);

$cart = new Cart($GLOBALS['subscriber']);

$list = $cart->GetOrderlist();

if(isset($_REQUEST['custsess']))
{
    $customer->Initialize($_REQUEST['custsess']);
}

if($list->Hasroom() === true)
{
    if(($drink->Id != "") && (Convert::ToInt($_REQUEST['quantity'])))
    {
        $drinkorder = new Drinkorder($GLOBALS['subscriber']);
        $drinkorder->Drink = $drink;
        $drinkorder->Quantity = Convert::ToInt($_REQUEST['quantity']);
        $drinkorder->Immediate = false;
        $drinkorder->Orderdate = new WixDate($_REQUEST['date']);
        $drinkorder->Ordermin = Convert::ToInt($_REQUEST['mins']);
        $drinkorder->Orderhour = Convert::ToInt($_REQUEST['hour']);
        $drinkorder->Ordergmt = $_REQUEST['gmt'];


        $inrange = false;
        $span = $list->Lodgingrange();

        if(($span->Start <= $drinkorder->Orderdate->getValue()) && ($span->Stop >= $drinkorder->Orderdate->getValue()))
        {
            $cart->Addorder($drinkorder);

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
        $ret->message = "Invalid drink selected or invalid quantity requested";
        Fraudlog::Log($GLOBALS['subscriber'], "Fraud detected", "Client portal", "Attempt to order drink");
    }
}
else
{
    $ret->status = "failed";
    $ret->message = "You have to be a lodging customer to complete the order. Log in and try again";
    Fraudlog::Log($GLOBALS['subscriber'], "Fraud detected", "Client portal", "Attempt to order drink");
}

echo json_encode($ret);