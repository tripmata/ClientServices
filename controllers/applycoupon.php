<?php

$ret = new stdClass();


$coupon = Coupon::byCode($GLOBALS['subscriber'], trim(strtoupper($_REQUEST['code'])));

if($coupon != null)
{
    if($coupon->Used)
    {
        $ret->status = "failed";
        $ret->message = "Used coupon";
    }
    else
    {
        if((intval($coupon->Expirydate) < time()) && ($coupon->Expires))
        {
            $ret->status = "failed";
            $ret->message = "Expired coupon";
        }
        else
        {
            $cart = new Cart($GLOBALS['subscriber']);

            if($cart->GetOrderlist()->Applycoupon($coupon) == Coupon::Added)
            {
                $list = Discount::process($GLOBALS['subscriber'], $cart->GetOrderlist());

                $ret->status = "success";
                $ret->data = new stdClass();
                $ret->data->Reservationcount = $cart->Contentcount();
                $ret->data->Currency = $GLOBALS['subscriber']->Currency->Symbol;
                $ret->data->Total = $list->GetTotal();
                $ret->data->Discount = $list->TotalDiscount();
                $ret->data->Tax = $list->Tax;
                $ret->data->Coupon = $list->Getcouponlist();

                $ret->status = "success";
                $ret->message = "Coupon code applied";

                $customer = new Customer($GLOBALS['subscriber']);
                if(isset($_REQUEST['custsess']))
                {
                    $customer->Initialize($_REQUEST['custsess']);
                }

                $context = Context::Create($customer, $coupon);
                $event = new Event($GLOBALS['subscriber'], Event::CouponIsUsed, $context);
                Event::Fire($event);
            }
            else
            {
                $ret->status = "failed";
                $ret->message = "Items not covered";
            }
        }
    }
}
else
{
    $ret->status = "failed";
    $ret->message = "Invalid code";
}

echo json_encode($ret);