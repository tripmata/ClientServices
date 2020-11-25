<?php

	$ret = new stdClass();


                    $customer = new Customer($GLOBALS['subscriber']);

                    $pastry = new Pastry($GLOBALS['subscriber']);
                    $pastry->Initialize($_REQUEST['pastry']);

                    if(isset($_REQUEST['custsess']))
                    {
                        $customer->Initialize($_REQUEST['custsess']);
                    }

                    if(($customer->Id != "") && (Lodging::isLodged($GLOBALS['subscriber'], $customer)))
                    {
                        if(($pastry->Id != "") && (Convert::ToInt($_REQUEST['quantity'])))
                        {
                            $pastryorder = new Pastryorder($GLOBALS['subscriber']);
                            $pastryorder->Pastry = $pastry;
                            $pastryorder->Quantity = Convert::ToInt($_REQUEST['quantity']);
                            $pastryorder->Immediate = true;

                            $pastryorder->Guest = Lodging::GetGuest($GLOBALS['subscriber'], $customer);

                            $cart = new Cart($GLOBALS['subscriber']);
                            $cart->Addorder($pastryorder);

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
                            Fraudlog::Log($GLOBALS['subscriber'], "Fraud detected", "Client portal", "Attempt to order pastry");
                        }
                    }
                    else
                    {
                        $ret->status = "failed";
                        $ret->message = "You have to be a lodging customer to complete the order. Log in and try again";
                        Fraudlog::Log($GLOBALS['subscriber'], "Fraud detected", "Client portal", "Attempt to order pastry");
                    }

	echo json_encode($ret);