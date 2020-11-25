<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $sales = null;

                        $span = new Timespan(new WixDate($_REQUEST['start_date']), new WixDate($_REQUEST['stop_date']), true);

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Bar->ReadAccess)
                            {
                                $sales = Barsale::SaleInPeriod($GLOBALS['subscriber'], $span, $_REQUEST['user']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchen->ReadAccess)
                            {
                                $sales = Kitchensale::SaleInPeriod($GLOBALS['subscriber'], $span, $_REQUEST['user']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundry->ReadAccess)
                            {
                                $sales = Laundrysale::SaleInPeriod($GLOBALS['subscriber'], $span, $_REQUEST['user']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakery->ReadAccess)
                            {
                                $sales = Bakerysale::SaleInPeriod($GLOBALS['subscriber'], $span, $_REQUEST['user']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Pool->ReadAccess)
                            {
                                $sales = Poolsale::SaleInPeriod($GLOBALS['subscriber'], $span, $_REQUEST['user']);
                            }
                        }


                        if($sales !== null)
                        {
                            $report = new stdClass();
                            $report->Customers = count($sales);
                            $report->Solditems = 0;
                            $report->Totalcash = 0;
                            $report->POSOrder = 0;
                            $report->WebOrder = 0;
                            $report->Paidcash = 0;
                            $report->Balance = 0;
                            $report->Rebate = 0;

                            $report->Cash = 0;
                            $report->Pos  = 0;
                            $report->Online = 0;
                            $report->Others = 0;

                            $report->Cashbar = 0;
                            $report->Posbar  = 0;
                            $report->Onlinebar = 0;
                            $report->Othersbar = 0;

                            for($i = 0; $i < count($sales); $i++)
                            {
                                $report->Solditems += $sales[$i]->Itemcount;
                                $report->Totalcash += ((doubleval($sales[$i]->Total)) + (doubleval($sales[$i]->Taxes))) - (doubleval($sales[$i]->Discount));

                                $report->Paidcash += doubleval($sales[$i]->Paidamount);

                                $report->POSOrder += ($sales[$i]->Channel == "pos") ? 1 : 0;
                                $report->WebOrder += ($sales[$i]->Channel == "web") ? 1 : 0;

                                $transactions = $sales[$i]->transactionList();

                                for($j = 0; $j < count($transactions); $j++)
                                {
                                    $report->Cash += ((($transactions[$j]->Method == "cash") &&
                                        ($transactions[$j]->Type == "credit")) ? doubleval($transactions[$j]->Amount) : 0);
                                    $report->Pos  += ((($transactions[$j]->Method == "pos") &&
                                        ($transactions[$j]->Type == "credit")) ? doubleval($transactions[$j]->Amount) : 0);
                                    $report->Online += ((($transactions[$j]->Method == "web") &&
                                        ($transactions[$j]->Type == "credit")) ? doubleval($transactions[$j]->Amount) : 0);
                                    $report->Others += ((($transactions[$j]->Method == "others") &&
                                        ($transactions[$j]->Type == "credit")) ? doubleval($transactions[$j]->Amount) : 0);


                                    $report->Cash -= ((($transactions[$j]->Method == "cash") &&
                                        ($transactions[$j]->Type == "debit")) ? doubleval($transactions[$j]->Amount) : 0);
                                    $report->Pos  -= ((($transactions[$j]->Method == "pos") &&
                                        ($transactions[$j]->Type == "debit")) ? doubleval($transactions[$j]->Amount) : 0);
                                    $report->Online -= ((($transactions[$j]->Method == "web") &&
                                        ($transactions[$j]->Type == "debit")) ? doubleval($transactions[$j]->Amount) : 0);
                                    $report->Others -= ((($transactions[$j]->Method == "others") &&
                                        ($transactions[$j]->Type == "debit")) ? doubleval($transactions[$j]->Amount) : 0);
                                }
                            }
                            $report->Balance = doubleval($report->Totalcash) - doubleval($report->Paidcash);
                            $report->Rebate = doubleval($report->Paidcash) - doubleval($report->Totalcash);

                            $report->user = new User($GLOBALS['subscriber']);
                            $report->user->Initialize($_REQUEST['user']);



                            if(($report->Cash + $report->Pos + $report->Online + $report->Others) > 0)
                            {
                                $tots = ($report->Cash + $report->Pos + $report->Online + $report->Others);

                                $report->Cashbar = (($report->Cash / $tots) * 100.0);
                                $report->Posbar  = (($report->Pos / $tots) * 100.0);
                                $report->Onlinebar = (($report->Online / $tots) * 100.0);
                                $report->Othersbar = (($report->Others / $tots) * 100.0);
                            }


                            $ret->status = "success";
                            $ret->data = $report;
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