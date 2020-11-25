<?php

	$ret = new stdClass();


                    $customer = new Customer($GLOBALS['subscriber']);

                    $food = new Food($GLOBALS['subscriber']);
                    $food->Initialize($_REQUEST['food']);

                    if(isset($_REQUEST['custsess']))
                    {
                        $customer->Initialize($_REQUEST['custsess']);
                    }

                    if(($customer->Id != "") && (Lodging::isLodged($GLOBALS['subscriber'], $customer)))
                    {
                        if(($food->Id != "") && (Convert::ToInt($_REQUEST['quantity'])))
                        {
                            $foodorder = new Foodorder($GLOBALS['subscriber']);
                            $foodorder->Food = $food;
                            $foodorder->Quantity = Convert::ToInt($_REQUEST['quantity']);
                            $foodorder->Immediate = true;

                            $foodorder->Guest = Lodging::GetGuest($GLOBALS['subscriber'], $customer);

                            $cart = new Cart($GLOBALS['subscriber']);
                            $cart->Addorder($foodorder);

                            $ret = $cart->Generatereply();
                            $ret->Content->Data->Cartcount = $cart->Contentcount();
                            $ret->status = "success";

                            $ret->Content->Data->root = Router::ResolvePath('', $path);
                            $ret->Content->Data->modules = new Modules($GLOBALS['subscriber']);
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