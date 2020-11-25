<?php

	$ret = new stdClass();
    $cart = new Cart($GLOBALS['subscriber']);

    $cart->GetOrderlist()->Removecoupon($_REQUEST['coupon']);

    $list = Discount::process($GLOBALS['subscriber'], $cart->GetOrderlist());

    $ret->status = "success";
    $ret->data = new stdClass();
    $ret->data->Reservationcount = $cart->Contentcount();
    $ret->data->Currency = $GLOBALS['subscriber']->Currency->Symbol;
    $ret->data->Total = $list->GetTotal();
    $ret->data->Discount = $list->TotalDiscount();
    $ret->data->Tax = $list->GetTax();
    $ret->data->Coupon = $list->Getcouponlist();


    $ret->status = "success";
    $ret->message = "Coupon has been removed";


	echo json_encode($ret);