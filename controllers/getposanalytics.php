<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $transaction = null;
                        $sale = null;

                        $span = new Timespan(new WixDate(strtotime(date("m/d/Y"))), new WixDate(strtotime(date("m/d/Y"))), true);

                        if($_REQUEST['period'] == "yesterday")
                        {
                            $yesterday = strtotime(date("m/d/Y", time() - ((60 * 60) * 24)));
                            $span = new Timespan(new WixDate($yesterday), new WixDate($yesterday), true);
                        }

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Barpos->ReadAccess)
                            {
                                $sale = Barsale::SaleInPeriod($GLOBALS['subscriber'], $span, $_REQUEST['usersess']);
                                $transaction = new Bartransaction($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchenpos->ReadAccess)
                            {
                                $sale = Kitchensale::SaleInPeriod($GLOBALS['subscriber'], $span, $_REQUEST['usersess']);
                                $transaction = new Kitchentransaction($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundrypos->ReadAccess)
                            {
                                $sale = Laundrysale::SaleInPeriod($GLOBALS['subscriber'], $span, $_REQUEST['usersess']);
                                $transaction = new Laundrytransaction($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakerypos->ReadAccess)
                            {
                                $sale = Bakerysale::SaleInPeriod($GLOBALS['subscriber'], $span, $_REQUEST['usersess']);
                                $transaction = new Bakerytransaction($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Poolpos->ReadAccess)
                            {
                                $sale = Poolsale::SaleInPeriod($GLOBALS['subscriber'], $span, $_REQUEST['usersess']);
                                $transaction = new Pooltransaction($GLOBALS['subscriber']);
                            }
                        }


                        if($transaction !== null)
                        {
                            $ret->data = new stdClass();

                            $ret->data->Paidtotal = 0;
                            $ret->data->Saletotal = 0;
                            $ret->data->Totalitems = 0;
                            $ret->data->Cashsale = 0;
                            $ret->data->Possale = 0;
                            $ret->data->Othersale = 0;
                            $ret->data->Websale = 0;

                            $ret->data->Webchannel = 0;
                            $ret->data->Poschannel = 0;

                            for($i = 0; $i < count($sale); $i++)
                            {
                                $ret->data->Saletotal += (doubleval($sale[$i]->Total) + doubleval($sale[$i]->Taxes)) - doubleval($sale[$i]->Discount);

                                $transactions = $sale[$i]->transactionList();

                                for($j = 0; $j < count($transactions); $j++)
                                {
                                    $ret->data->Totalitems += Convert::ToInt($sale[$i]->Itemcount);

                                    $ret->data->Cashsale += doubleval((($transactions[$j]->Method == "cash") &&
                                        ($transactions[$j]->Type == "credit")) ? $transactions[$j]->Amount : 0);
                                    $ret->data->Possale += doubleval((($transactions[$j]->Method == "pos") &&
                                        ($transactions[$j]->Type == "credit")) ? $transactions[$j]->Amount : 0);
                                    $ret->data->Othersale += doubleval((($transactions[$j]->Method == "others") &&
                                        ($transactions[$j]->Type == "credit")) ? $transactions[$j]->Amount : 0);
                                    $ret->data->Websale += doubleval((($transactions[$j]->Method == "web") &&
                                        ($transactions[$j]->Type == "credit")) ? $transactions[$j]->Amount : 0);


                                    $ret->data->Cashsale -= doubleval((($transactions[$j]->Method == "cash") &&
                                        ($transactions[$j]->Type == "debit")) ? $transactions[$j]->Amount : 0);
                                    $ret->data->Possale -= doubleval((($transactions[$j]->Method == "pos") &&
                                        ($transactions[$j]->Type == "debit")) ? $transactions[$j]->Amount : 0);
                                    $ret->data->Othersale -= doubleval((($transactions[$j]->Method == "others") &&
                                        ($transactions[$j]->Type == "debit")) ? $transactions[$j]->Amount : 0);
                                    $ret->data->Websale -= doubleval((($transactions[$j]->Method == "web") &&
                                        ($transactions[$j]->Type == "debit")) ? $transactions[$j]->Amount : 0);

                                    $ret->data->Webchannel += ($sale[$i]->Channel == "web" ? 1 : 0);
                                    $ret->data->Poschannel += ($sale[$i]->Channel == "pos" ? 1 : 0);
                                }
                                $ret->data->Paidtotal = $ret->data->Cashsale + $ret->data->Possale + $ret->data->Othersale + $ret->data->Websale;

                                $ret->data->Pospercentage = number_format(($ret->data->Poschannel / ($ret->data->Webchannel + $ret->data->Poschannel)) * 100);
                            }

                            $ret->status = "success";
                            $ret->message = "POS transaction added successfully";
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