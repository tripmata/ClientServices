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
                                if($_REQUEST['Filtervalue'] != "")
                                {
                                    if((strtolower(trim($_REQUEST['Filtervalue'])) == "web") || (strtolower(trim($_REQUEST['Filtervalue'])) == "pos"))
                                    {
                                        $sales = Barsale::Searchspan($GLOBALS['subscriber'], $span, $_REQUEST['Filtervalue'], $_REQUEST['Filter'], $_REQUEST['user']);
                                    }
                                    else
                                    {
                                        $sales = Barsale::Searchspan($GLOBALS['subscriber'], null, $_REQUEST['Filtervalue'], "*", $_REQUEST['user']);
                                    }
                                }
                                else if($_REQUEST['sale_span']  != "")
                                {
                                    $range = new Span(Convert::ToInt($_REQUEST['spanStart']), Convert::ToInt($_REQUEST['spanStop']));
                                    $sales = Barsale::FilterSpan($GLOBALS['subscriber'], $span, $range, $_REQUEST['sale_span'], $_REQUEST['Filter'], $_REQUEST['user']);
                                }
                                else
                                {
                                    $sales = Barsale::SaleInPeriod($GLOBALS['subscriber'], $span, $_REQUEST['user'], $_REQUEST['Filter']);
                                }
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchen->ReadAccess)
                            {
                                if($_REQUEST['Filtervalue'] != "")
                                {
                                    if((strtolower(trim($_REQUEST['Filtervalue'])) == "web") || (strtolower(trim($_REQUEST['Filtervalue'])) == "pos"))
                                    {
                                        $sales = Kitchensale::Searchspan($GLOBALS['subscriber'], $span, $_REQUEST['Filtervalue'], $_REQUEST['Filter'], $_REQUEST['user']);
                                    }
                                    else
                                    {
                                        $sales = Kitchensale::Searchspan($GLOBALS['subscriber'], null, $_REQUEST['Filtervalue'], "*", $_REQUEST['user']);
                                    }
                                }
                                else if($_REQUEST['sale_span']  != "")
                                {
                                    $range = new Span(Convert::ToInt($_REQUEST['spanStart']), Convert::ToInt($_REQUEST['spanStop']));
                                    $sales = Kitchensale::FilterSpan($GLOBALS['subscriber'], $span, $range, $_REQUEST['sale_span'], $_REQUEST['Filter'], $_REQUEST['user']);
                                }
                                else
                                {
                                    $sales = Kitchensale::SaleInPeriod($GLOBALS['subscriber'], $span, $_REQUEST['user'], $_REQUEST['Filter']);
                                }
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundry->ReadAccess)
                            {
                                if($_REQUEST['Filtervalue'] != "")
                                {
                                    if((strtolower(trim($_REQUEST['Filtervalue'])) == "web") || (strtolower(trim($_REQUEST['Filtervalue'])) == "pos"))
                                    {
                                        $sales = Laundrysale::Searchspan($GLOBALS['subscriber'], $span, $_REQUEST['Filtervalue'], $_REQUEST['Filter'], $_REQUEST['user']);
                                    }
                                    else
                                    {
                                        $sales = Laundrysale::Searchspan($GLOBALS['subscriber'], null, $_REQUEST['Filtervalue'], "*", $_REQUEST['user']);
                                    }
                                }
                                else if($_REQUEST['sale_span']  != "")
                                {
                                    $range = new Span(Convert::ToInt($_REQUEST['spanStart']), Convert::ToInt($_REQUEST['spanStop']));
                                    $sales = Laundrysale::FilterSpan($GLOBALS['subscriber'], $span, $range, $_REQUEST['sale_span'], $_REQUEST['Filter'], $_REQUEST['user']);
                                }
                                else
                                {
                                    $sales = Laundrysale::SaleInPeriod($GLOBALS['subscriber'], $span, $_REQUEST['user'], $_REQUEST['Filter']);
                                }
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakery->ReadAccess)
                            {
                                if($_REQUEST['Filtervalue'] != "")
                                {
                                    if((strtolower(trim($_REQUEST['Filtervalue'])) == "web") || (strtolower(trim($_REQUEST['Filtervalue'])) == "pos"))
                                    {
                                        $sales = Bakerysale::Searchspan($GLOBALS['subscriber'], $span, $_REQUEST['Filtervalue'], $_REQUEST['Filter'], $_REQUEST['user']);
                                    }
                                    else
                                    {
                                        $sales = Bakerysale::Searchspan($GLOBALS['subscriber'], null, $_REQUEST['Filtervalue'], "*", $_REQUEST['user']);
                                    }
                                }
                                else if($_REQUEST['sale_span']  != "")
                                {
                                    $range = new Span(Convert::ToInt($_REQUEST['spanStart']), Convert::ToInt($_REQUEST['spanStop']));
                                    $sales = Bakerysale::FilterSpan($GLOBALS['subscriber'], $span, $range, $_REQUEST['sale_span'], $_REQUEST['Filter'], $_REQUEST['user']);
                                }
                                else
                                {
                                    $sales = Bakerysale::SaleInPeriod($GLOBALS['subscriber'], $span, $_REQUEST['user'], $_REQUEST['Filter']);
                                }
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Pool->ReadAccess)
                            {
                                if($_REQUEST['Filtervalue'] != "")
                                {
                                    if((strtolower(trim($_REQUEST['Filtervalue'])) == "web") || (strtolower(trim($_REQUEST['Filtervalue'])) == "pos"))
                                    {
                                        $sales = Poolsale::Searchspan($GLOBALS['subscriber'], $span, $_REQUEST['Filtervalue'], $_REQUEST['Filter'], $_REQUEST['user']);
                                    }
                                    else
                                    {
                                        $sales = Poolsale::Searchspan($GLOBALS['subscriber'], null, $_REQUEST['Filtervalue'], "*", $_REQUEST['user']);
                                    }
                                }
                                else if($_REQUEST['sale_span']  != "")
                                {
                                    $range = new Span(Convert::ToInt($_REQUEST['spanStart']), Convert::ToInt($_REQUEST['spanStop']));
                                    $sales = Poolsale::FilterSpan($GLOBALS['subscriber'], $span, $range, $_REQUEST['sale_span'], $_REQUEST['Filter'], $_REQUEST['user']);
                                }
                                else
                                {
                                    $sales = Poolsale::SaleInPeriod($GLOBALS['subscriber'], $span, $_REQUEST['user'], $_REQUEST['Filter']);
                                }
                            }
                        }


                        if($sales !== null)
                        {
                            $ret->data = array();

                            $page = $_REQUEST['Page'];
                            $perpage = $_REQUEST['Perpage'];
                            $filter = $_REQUEST['Filter'];
                            $filtervalue = $_REQUEST['Filtervalue'];

                            $ret->Page = $page;
                            $ret->Perpage = $perpage;


                            $ret->Total = count($sales);

                            $start = (($ret->Page - 1) * $ret->Perpage);
                            $stop = (($start + $ret->Perpage) - 1);

                            $x = 0;
                            for($i = $start; $i < count($sales); $i++)
                            {
                                $ret->data[$x] = $sales[$i];
                                if($i == $stop){break;}
                                $x++;
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