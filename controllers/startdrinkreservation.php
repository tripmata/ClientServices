<?php

	$ret = new stdClass();


                    $drink = new Drink($GLOBALS['subscriber']);
                    $drink->Initialize($_REQUEST['drink']);

                    if($drink->Reservable)
                    {
                        $customer = new Customer($GLOBALS['subscriber']);
                        if(isset($_REQUEST['custsess']))
                        {
                            $customer->Initialize($_REQUEST['custsess']);
                        }

                        $cart = new Cart($GLOBALS['subscriber']);

                        $list = $cart->GetOrderlist();

                        if($list->Hasroom())
                        {
                            $ret->status = "add-reservation";

                            $ret->data = $drink;
                            $ret->Currency = $GLOBALS['subscriber']->Currency;
                        }
                        else if(Lodging::isLodged($GLOBALS['subscriber'], $customer))
                        {
                            $ret->status = "order-now";
                            $ret->data = $drink;
                            $ret->Lodging = new Lodging($GLOBALS['subscriber']);
                            $ret->Lodging->Initialize($customer);

                            $ret->Currency = $GLOBALS['subscriber']->Currency;
                        }
                        else
                        {
                            if($customer->Id != "")
                            {
                                $ret->status = "no-room-logged-in";
                            }
                            else
                            {
                                $ret->status = "no-room";
                            }
                        }
                    }
                    else
                    {
                        $ret->status = "not-reservable";
                        $ret->data = $drink;
                    }

	echo json_encode($ret);