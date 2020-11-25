<?php

	$ret = new stdClass();


                    $cart = new Cart($GLOBALS['subscriber']);
                    $list = $cart->GetOrderlist()->Getitems();

                    $ret->data = new stdClass();

                    for($i = 0; $i < count($list); $i++)
                    {
                        if($list[$i]->Id == $_REQUEST['itemid'])
                        {
                            if(Convert::ToInt($_REQUEST['guest']) > 0)
                            {
                                if((Convert::ToInt($_REQUEST['guest']) <= $list[$i]->Roomcategory->Maxoccupancy) && ($list[$i]->Roomcategory->Maxoccupancy > 0))
                                {
                                    if((strtotime($_REQUEST['start_date'])) >= strtotime(date("m/d/Y")))
                                    {
                                        if(strtotime($_REQUEST['stop_date']) > strtotime($_REQUEST['start_date']))
                                        {
                                            $list[$i]->Guestcount = Convert::ToInt($_REQUEST['guest']);
                                            $list[$i]->Checkindate = new WixDate($_REQUEST['start_date']);
                                            $list[$i]->Checkoutdate = new WixDate($_REQUEST['stop_date']);
                                            $list[$i]->Save();

                                            $list[$i]->Total();

                                            $orders = $cart->GetOrderlist();

                                            $period = $orders->Lodgingrange();

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



                                            $orderlist = Discount::process($GLOBALS['subscriber'], $cart->GetOrderlist());

                                            $ret->status = "success";
                                            $ret->data = new stdClass();
                                            $ret->data->Reservationcount = $cart->Contentcount();
                                            $ret->data->Currency = $GLOBALS['subscriber']->Currency->Symbol;
                                            $ret->data->Total = $orderlist->GetTotal();
                                            $ret->data->Discount = $orderlist->TotalDiscount();
                                            $ret->data->Tax = $orderlist->GetTax();
                                            $ret->data->Coupon = $orderlist->Getcouponlist();

                                            $ret->data->Order = $list[$i];
                                            $ret->data->Days = Roomorder::Days($list[$i]);
                                            $ret->data->total = $list[$i]->Total() + $list[$i]->CalcTaxes();

                                            $ret->data->Removelist = $removeList;

                                            $ret->status = "success";
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "You can't check out before you check in";
                                            $ret->data->Order = $list[$i];
                                            $ret->data->Days = Roomorder::Days($list[$i]);
                                            $ret->data->total = $list[$i]->Total() + $list[$i]->CalcTaxes();
                                        }
                                    }
                                    else
                                    {
                                        $ret->status = "failed";
                                        $ret->message = "Invalid check in date";
                                        $ret->data->Order = $list[$i];
                                        $ret->data->Days = Roomorder::Days($list[$i]);
                                        $ret->data->total = $list[$i]->Total() + $list[$i]->CalcTaxes();
                                    }
                                }
                                else
                                {
                                    $ret->status = "failed";
                                    $ret->message = "Only a maximum of ".$list[$i]->Roomcategory->Maxoccupancy." people can occupy the selected room category";
                                    $ret->data->Order = $list[$i];
                                    $ret->data->Days = Roomorder::Days($list[$i]);
                                    $ret->data->total = $list[$i]->Total() + $list[$i]->CalcTaxes();
                                }
                            }
                            else
                            {
                                $ret->status = "failed";
                                $ret->message = "Invalid number of guests";
                                $ret->data->Order = $list[$i];
                                $ret->data->Days = Roomorder::Days($list[$i]);
                                $ret->data->total = $list[$i]->Total() + $list[$i]->CalcTaxes();
                            }
                        }
                    }


	echo json_encode($ret);