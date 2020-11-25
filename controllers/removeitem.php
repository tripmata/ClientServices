<?php

	$ret = new stdClass();


                    $cart = new Cart($GLOBALS['subscriber']);
                    $cart->removeItem($_REQUEST['item']);

                    $orders = $cart->GetOrderlist();
                    $period = $orders->Lodgingrange();
                    $list = $orders->Getitems();
                    //check and remove food pastry and bar order out of date
                    $removeList = [];
                    for($h = 0; $h < count($list); $h++)
                    {
                        if($list[$h]->Type != "room_order")
                        {
                            if (($period->Start > $list[$h]->Orderdate->getValue()) || ($period->Stop < $list[$h]->Orderdate->getValue()))
                            {
                                $orders->Removeitem($list[$h]);
                                array_push($removeList, $list[$h]->Id);
                            }
                        }
                    }

                    $list = Discount::process($GLOBALS['subscriber'], $cart->GetOrderlist());

                    $ret->status = "success";
                    $ret->data = new stdClass();
                    $ret->data->Reservationcount = $cart->Contentcount();
                    $ret->data->Currency = $GLOBALS['subscriber']->Currency->Symbol;
                    $ret->data->Total = $list->GetTotal();
                    $ret->data->Discount = $list->TotalDiscount();
                    $ret->data->Tax = $list->Tax;
                    $ret->data->Coupon = $list->Getcouponlist();
                    $ret->data->Removelist = $removeList;

	echo json_encode($ret);