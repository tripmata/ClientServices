<?php

	$ret = new stdClass();


                    $customer = new Customer($GLOBALS['subscriber']);

                    $drink = new Drink($GLOBALS['subscriber']);
                    $drink->Initialize($_REQUEST['drink']);

                    if(isset($_REQUEST['custsess']))
                    {
                        $customer->Initialize($_REQUEST['custsess']);
                    }

                    if(($customer->Id != "") && (Lodging::isLodged($GLOBALS['subscriber'], $customer)))
                    {
                        if(($drink->Id != "") && (Convert::ToInt($_REQUEST['quantity'])))
                        {
                            $drinkorder = new Drinkorder($GLOBALS['subscriber']);
                            $drinkorder->Drink = $drink;
                            $drinkorder->Quantity = Convert::ToInt($_REQUEST['quantity']);
                            $drinkorder->Immediate = true;

                            $drinkorder->Guest = Lodging::GetGuest($GLOBALS['subscriber'], $customer);

                            $cart = new Cart($GLOBALS['subscriber']);
                            $cart->Addorder($drinkorder);

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