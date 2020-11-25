<?php

	$ret = new stdClass();


                    $cart = new Cart($GLOBALS['subscriber']);
                    $list = $cart->GetOrderlist()->Getitems();

                    $ret->data = new stdClass();

                    for($i = 0; $i < count($list); $i++)
                    {
                        if($list[$i]->Id == $_REQUEST['itemid'])
                        {
                            if(Convert::ToInt($_REQUEST['quantity']) > 0)
                            {

                                $list[$i]->Quantity = Convert::ToInt($_REQUEST['quantity']);
                                $list[$i]->Save();

                                $list[$i]->Total();

                                $orderlist = Discount::process($GLOBALS['subscriber'], $cart->GetOrderlist());

                                $ret->status = "success";
                                $ret->data = new stdClass();
                                $ret->data->Reservationcount = $cart->Contentcount();
                                $ret->data->Currency = $GLOBALS['subscriber']->Currency->Symbol;
                                $ret->data->Total = $orderlist->GetTotal();
                                $ret->data->Discount = $orderlist->TotalDiscount();
                                $ret->data->Tax = $orderlist->GetTax();
                                $ret->data->Coupon = $orderlist->Getcouponlist();

                                $ret->data->total = $list[$i]->Total() + $list[$i]->CalcTaxes();

                                $ret->status = "success";
                            }
                            else
                            {
                                $ret->status = "failed";
                                $ret->message = "Invalid quantity";
                                $ret->data->Quantity = $list[$i]->Quantity;
                                $ret->data->total = $list[$i]->Total() + $list[$i]->CalcTaxes();
                            }
                        }
                    }



	echo json_encode($ret);