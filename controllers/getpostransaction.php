<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $sale = null;
                        $transaction = null;

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Bar->ReadAccess)
                            {
                                $sale = new Barsale($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchen->ReadAccess)
                            {
                                $sale = new Kitchensale($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundry->ReadAccess)
                            {
                                $sale = new Laundrysale($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakery->ReadAccess)
                            {
                                $sale = new Bakerysale($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Pool->ReadAccess)
                            {
                                $sale = new Poolsale($GLOBALS['subscriber']);
                            }
                        }


                        if($sale !== null)
                        {
                            $sale->initialize($_REQUEST['sale']);

                            $ret->data = new stdClass();
                            $ret->data->sale = $sale;
                            $ret->data->transaction = $sale->transactionList();

                            for($i = 0; $i < count($ret->data->transaction); $i++)
                            {
                                $u = $ret->data->transaction[$i]->User;
                                $ret->data->transaction[$i]->User = new User($GLOBALS['subscriber']);
                                $ret->data->transaction[$i]->User->initialize($u);
                            }

                            $ret->status = "success";
                            $ret->message = "POS report retrieved successfully";
                        }
                        else
                        {
                            $ret->status = "access denied";
                            $ret->message = "You do not have the required privilege to complete the operation";
                        }
                    }
                    else
                    {
                        $ret->status = "login";
                        $ret->data = "login & try again";
                    }
                    
	echo json_encode($ret);