<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $report = null;

                        $ret->data = new stdClass();

                        $span = new Timespan(new WixDate($_REQUEST['start_date']), new WixDate($_REQUEST['stop_date']), true);

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Bar->ReadAccess)
                            {
                                //Initialization code goes here
                                $report = [];
                                $generalReport = new stdClass();
                                $generalReport->Customers = 0;
                                $generalReport->Itemcount = 0;
                                $generalReport->Totalsold = 0;
                                $generalReport->POSChannelSales = 0;
                                $generalReport->WebChannelSales = 0;
                                $generalReport->SalesPeriod = [];
                                $generalReport->Topselling = [];
                                $generalReport->Worseselling = [];
                                $generalReport->Salesort = [];

                                $generalReport->SalesPeriod = Barsale::dailySalePlot($GLOBALS['subscriber'], $span, $_REQUEST['plotCriteria']);

                                $users = User::ByRole($GLOBALS['subscriber'], Role::BarPOS);

                                $websale = 0;
                                $possale = 0;

                                for($i = 0; $i < count($users); $i++)
                                {
                                    $userreport = new stdClass();
                                    $userreport->User = $users[$i];
                                    $userreport->isActive = ((time() - $users[$i]->Lastseen->getValue()) > 60) ? false : true;
                                    $userreport->Itemcount = 0;
                                    $userreport->Sold = 0;
                                    $userreport->Paid = 0;
                                    $userreport->Balance = 0;

                                    $sales = Barsale::SaleInPeriod($GLOBALS['subscriber'], $span, $users[$i]);

                                    for($j = 0; $j < count($sales); $j++)
                                    {
                                        $userreport->Itemcount += Convert::ToInt($sales[$j]->Itemcount);
                                        $userreport->Sold += ((doubleval($sales[$j]->Total) + doubleval($sales[$j]->Taxes)) - doubleval($sales[$j]->Discount));
                                        $userreport->Paid += doubleval($sales[$j]->Paidamount);

                                        $generalReport->Itemcount += Convert::ToInt($sales[$j]->Itemcount);
                                        $generalReport->Totalsold += ((doubleval($sales[$j]->Total) + doubleval($sales[$j]->Taxes)) - doubleval($sales[$j]->Discount));

                                        $websale += ($sales[$j]->Channel == "web" ? 1 : 0);
                                        $possale += ($sales[$j]->Channel == "pos" ? 1 : 0);
                                    }
                                    $userreport->Balance = ($userreport->Sold - $userreport->Paid);
                                    $generalReport->Customers += count($sales);

                                    array_push($report, $userreport);
                                }

                                if(($websale + $possale) > 0)
                                {
                                    $generalReport->WebChannelSales = ($websale / ($websale + $possale)) * 100.0;
                                    $generalReport->POSChannelSales = ($possale / ($websale + $possale)) * 100.0;
                                }

                                $sales = Barsale::SaleInPeriod($GLOBALS['subscriber'], $span);
                                //$generalReport->Salesort = Kitchensale::sortItemSales($GLOBALS['subscriber'], $sales);
                                $generalReport->Salesort = Barsale::sortItemSales2($GLOBALS['subscriber'], $span);

                                $ret->data = new stdClass();
                                $ret->data->Users = $report;
                                $ret->data->General = $generalReport;
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchen->ReadAccess)
                            {
                                //Initialization code goes here
                                $report = [];
                                $generalReport = new stdClass();
                                $generalReport->Customers = 0;
                                $generalReport->Itemcount = 0;
                                $generalReport->Totalsold = 0;
                                $generalReport->POSChannelSales = 0;
                                $generalReport->WebChannelSales = 0;
                                $generalReport->SalesPeriod = [];
                                $generalReport->Topselling = [];
                                $generalReport->Worseselling = [];
                                $generalReport->Salesort = [];

                                $generalReport->SalesPeriod = Kitchensale::dailySalePlot($GLOBALS['subscriber'], $span, $_REQUEST['plotCriteria']);

                                $users = User::ByRole($GLOBALS['subscriber'], Role::KitchenPOS);

                                $websale = 0;
                                $possale = 0;

                                for($i = 0; $i < count($users); $i++)
                                {
                                    $userreport = new stdClass();
                                    $userreport->User = $users[$i];
                                    $userreport->isActive = ((time() - $users[$i]->Lastseen->getValue()) > 60) ? false : true;
                                    $userreport->Itemcount = 0;
                                    $userreport->Sold = 0;
                                    $userreport->Paid = 0;
                                    $userreport->Balance = 0;

                                    $sales = Kitchensale::SaleInPeriod($GLOBALS['subscriber'], $span, $users[$i]);

                                    for($j = 0; $j < count($sales); $j++)
                                    {
                                        $userreport->Itemcount += Convert::ToInt($sales[$j]->Itemcount);
                                        $userreport->Sold += ((doubleval($sales[$j]->Total) + doubleval($sales[$j]->Taxes)) - doubleval($sales[$j]->Discount));
                                        $userreport->Paid += doubleval($sales[$j]->Paidamount);

                                        $generalReport->Itemcount += Convert::ToInt($sales[$j]->Itemcount);
                                        $generalReport->Totalsold += ((doubleval($sales[$j]->Total) + doubleval($sales[$j]->Taxes)) - doubleval($sales[$j]->Discount));

                                        $websale += ($sales[$j]->Channel == "web" ? 1 : 0);
                                        $possale += ($sales[$j]->Channel == "pos" ? 1 : 0);
                                    }
                                    $userreport->Balance = ($userreport->Sold - $userreport->Paid);
                                    $generalReport->Customers += count($sales);

                                    array_push($report, $userreport);
                                }

                                if(($websale + $possale) > 0)
                                {
                                    $generalReport->WebChannelSales = ($websale / ($websale + $possale)) * 100.0;
                                    $generalReport->POSChannelSales = ($possale / ($websale + $possale)) * 100.0;
                                }

                                $sales = Kitchensale::SaleInPeriod($GLOBALS['subscriber'], $span);
                                //$generalReport->Salesort = Kitchensale::sortItemSales($GLOBALS['subscriber'], $sales);
                                $generalReport->Salesort = Kitchensale::sortItemSales2($GLOBALS['subscriber'], $span);

                                $ret->data = new stdClass();
                                $ret->data->Users = $report;
                                $ret->data->General = $generalReport;
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundry->ReadAccess)
                            {
                                //Initialization code goes here
                                $report = [];
                                $generalReport = new stdClass();
                                $generalReport->Customers = 0;
                                $generalReport->Itemcount = 0;
                                $generalReport->Totalsold = 0;
                                $generalReport->POSChannelSales = 0;
                                $generalReport->WebChannelSales = 0;
                                $generalReport->SalesPeriod = [];
                                $generalReport->Topselling = [];
                                $generalReport->Worseselling = [];
                                $generalReport->Salesort = [];

                                $generalReport->SalesPeriod = Laundrysale::dailySalePlot($GLOBALS['subscriber'], $span, $_REQUEST['plotCriteria']);

                                $users = User::ByRole($GLOBALS['subscriber'], Role::LaundryPOS);

                                $websale = 0;
                                $possale = 0;

                                for($i = 0; $i < count($users); $i++)
                                {
                                    $userreport = new stdClass();
                                    $userreport->User = $users[$i];
                                    $userreport->isActive = ((time() - $users[$i]->Lastseen->getValue()) > 60) ? false : true;
                                    $userreport->Itemcount = 0;
                                    $userreport->Sold = 0;
                                    $userreport->Paid = 0;
                                    $userreport->Balance = 0;

                                    $sales = Laundrysale::SaleInPeriod($GLOBALS['subscriber'], $span, $users[$i]);

                                    for($j = 0; $j < count($sales); $j++)
                                    {
                                        $userreport->Itemcount += Convert::ToInt($sales[$j]->Itemcount);
                                        $userreport->Sold += ((doubleval($sales[$j]->Total) + doubleval($sales[$j]->Taxes)) - doubleval($sales[$j]->Discount));
                                        $userreport->Paid += doubleval($sales[$j]->Paidamount);

                                        $generalReport->Itemcount += Convert::ToInt($sales[$j]->Itemcount);
                                        $generalReport->Totalsold += ((doubleval($sales[$j]->Total) + doubleval($sales[$j]->Taxes)) - doubleval($sales[$j]->Discount));

                                        $websale += ($sales[$j]->Channel == "web" ? 1 : 0);
                                        $possale += ($sales[$j]->Channel == "pos" ? 1 : 0);
                                    }
                                    $userreport->Balance = ($userreport->Sold - $userreport->Paid);
                                    $generalReport->Customers += count($sales);

                                    array_push($report, $userreport);
                                }

                                if(($websale + $possale) > 0)
                                {
                                    $generalReport->WebChannelSales = ($websale / ($websale + $possale)) * 100.0;
                                    $generalReport->POSChannelSales = ($possale / ($websale + $possale)) * 100.0;
                                }

                                $sales = Laundrysale::SaleInPeriod($GLOBALS['subscriber'], $span);
                                //$generalReport->Salesort = Kitchensale::sortItemSales($GLOBALS['subscriber'], $sales);
                                $generalReport->Salesort = Laundrysale::sortItemSales2($GLOBALS['subscriber'], $span);

                                $ret->data = new stdClass();
                                $ret->data->Users = $report;
                                $ret->data->General = $generalReport;
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakery->ReadAccess)
                            {
                                //Initialization code goes here
                                $report = [];
                                $generalReport = new stdClass();
                                $generalReport->Customers = 0;
                                $generalReport->Itemcount = 0;
                                $generalReport->Totalsold = 0;
                                $generalReport->POSChannelSales = 0;
                                $generalReport->WebChannelSales = 0;
                                $generalReport->SalesPeriod = [];
                                $generalReport->Topselling = [];
                                $generalReport->Worseselling = [];
                                $generalReport->Salesort = [];

                                $generalReport->SalesPeriod = Bakerysale::dailySalePlot($GLOBALS['subscriber'], $span, $_REQUEST['plotCriteria']);

                                $users = User::ByRole($GLOBALS['subscriber'], Role::BakeryPOS);

                                $websale = 0;
                                $possale = 0;

                                for($i = 0; $i < count($users); $i++)
                                {
                                    $userreport = new stdClass();
                                    $userreport->User = $users[$i];
                                    $userreport->isActive = ((time() - $users[$i]->Lastseen->getValue()) > 60) ? false : true;
                                    $userreport->Itemcount = 0;
                                    $userreport->Sold = 0;
                                    $userreport->Paid = 0;
                                    $userreport->Balance = 0;

                                    $sales = Bakerysale::SaleInPeriod($GLOBALS['subscriber'], $span, $users[$i]);

                                    for($j = 0; $j < count($sales); $j++)
                                    {
                                        $userreport->Itemcount += Convert::ToInt($sales[$j]->Itemcount);
                                        $userreport->Sold += ((doubleval($sales[$j]->Total) + doubleval($sales[$j]->Taxes)) - doubleval($sales[$j]->Discount));
                                        $userreport->Paid += doubleval($sales[$j]->Paidamount);

                                        $generalReport->Itemcount += Convert::ToInt($sales[$j]->Itemcount);
                                        $generalReport->Totalsold += ((doubleval($sales[$j]->Total) + doubleval($sales[$j]->Taxes)) - doubleval($sales[$j]->Discount));

                                        $websale += ($sales[$j]->Channel == "web" ? 1 : 0);
                                        $possale += ($sales[$j]->Channel == "pos" ? 1 : 0);
                                    }
                                    $userreport->Balance = ($userreport->Sold - $userreport->Paid);
                                    $generalReport->Customers += count($sales);

                                    array_push($report, $userreport);
                                }

                                if(($websale + $possale) > 0)
                                {
                                    $generalReport->WebChannelSales = ($websale / ($websale + $possale)) * 100.0;
                                    $generalReport->POSChannelSales = ($possale / ($websale + $possale)) * 100.0;
                                }

                                $sales = Bakerysale::SaleInPeriod($GLOBALS['subscriber'], $span);
                                //$generalReport->Salesort = Kitchensale::sortItemSales($GLOBALS['subscriber'], $sales);
                                $generalReport->Salesort = Bakerysale::sortItemSales2($GLOBALS['subscriber'], $span);

                                $ret->data = new stdClass();
                                $ret->data->Users = $report;
                                $ret->data->General = $generalReport;
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Pool->ReadAccess)
                            {
                                //Initialization code goes here
                                $report = [];
                                $generalReport = new stdClass();
                                $generalReport->Customers = 0;
                                $generalReport->Itemcount = 0;
                                $generalReport->Totalsold = 0;
                                $generalReport->POSChannelSales = 0;
                                $generalReport->WebChannelSales = 0;
                                $generalReport->SalesPeriod = [];
                                $generalReport->Topselling = [];
                                $generalReport->Worseselling = [];
                                $generalReport->Salesort = [];

                                $generalReport->SalesPeriod = Poolsale::dailySalePlot($GLOBALS['subscriber'], $span, $_REQUEST['plotCriteria']);

                                $users = User::ByRole($GLOBALS['subscriber'], Role::PoolPOS);

                                $websale = 0;
                                $possale = 0;

                                for($i = 0; $i < count($users); $i++)
                                {
                                    $userreport = new stdClass();
                                    $userreport->User = $users[$i];
                                    $userreport->isActive = ((time() - $users[$i]->Lastseen->getValue()) > 60) ? false : true;
                                    $userreport->Itemcount = 0;
                                    $userreport->Sold = 0;
                                    $userreport->Paid = 0;
                                    $userreport->Balance = 0;

                                    $sales = Poolsale::SaleInPeriod($GLOBALS['subscriber'], $span, $users[$i]);

                                    for($j = 0; $j < count($sales); $j++)
                                    {
                                        $userreport->Itemcount += Convert::ToInt($sales[$j]->Itemcount);
                                        $userreport->Sold += ((doubleval($sales[$j]->Total) + doubleval($sales[$j]->Taxes)) - doubleval($sales[$j]->Discount));
                                        $userreport->Paid += doubleval($sales[$j]->Paidamount);

                                        $generalReport->Itemcount += Convert::ToInt($sales[$j]->Itemcount);
                                        $generalReport->Totalsold += ((doubleval($sales[$j]->Total) + doubleval($sales[$j]->Taxes)) - doubleval($sales[$j]->Discount));

                                        $websale += ($sales[$j]->Channel == "web" ? 1 : 0);
                                        $possale += ($sales[$j]->Channel == "pos" ? 1 : 0);
                                    }
                                    $userreport->Balance = ($userreport->Sold - $userreport->Paid);
                                    $generalReport->Customers += count($sales);

                                    array_push($report, $userreport);
                                }

                                if(($websale + $possale) > 0)
                                {
                                    $generalReport->WebChannelSales = ($websale / ($websale + $possale)) * 100.0;
                                    $generalReport->POSChannelSales = ($possale / ($websale + $possale)) * 100.0;
                                }

                                $sales = Poolsale::SaleInPeriod($GLOBALS['subscriber'], $span);
                                //$generalReport->Salesort = Kitchensale::sortItemSales($GLOBALS['subscriber'], $sales);
                                $generalReport->Salesort = Poolsale::sortItemSales2($GLOBALS['subscriber'], $span);

                                $ret->data = new stdClass();
                                $ret->data->Users = $report;
                                $ret->data->General = $generalReport;
                            }
                        }


                        if($report !== null)
                        {
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