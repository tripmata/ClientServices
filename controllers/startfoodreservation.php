<?php

	$ret = new stdClass();


                    $food = new Food($GLOBALS['subscriber']);
                    $food->Initialize($_REQUEST['food']);

                    if($food->Reservable)
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

                            $ret->data = $food;
                            $ret->Currency = $GLOBALS['subscriber']->Currency;
                        }
                        else if(Lodging::isLodged($GLOBALS['subscriber'], $customer))
                        {
                            $ret->status = "order-now";
                            $ret->data = $food;
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
                        $ret->data = $food;
                    }

	echo json_encode($ret);