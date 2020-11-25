<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $store = null;

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Bar->ReadAccess)
                            {
                                if($_REQUEST['filter'] == "all")
                                {
                                    $store = Baritem::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "instock")
                                {
                                    $store = Baritem::InStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "outofstock")
                                {
                                    $store = Baritem::OutofStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "lowstock")
                                {
                                    $store = Baritem::LowStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "stockspan")
                                {
                                    $store = Baritem::ByStockRange($GLOBALS['subscriber'], $_REQUEST['rangestart'], $_REQUEST['rangestop']);
                                }
                                $ret->instockcount = Baritem::InStockItemsCount($GLOBALS['subscriber']);
                                $ret->lowstockcount = Baritem::LowStockItemsCount($GLOBALS['subscriber']);
                                $ret->outofstockcount = Baritem::OutofStockItemsCount($GLOBALS['subscriber']);
                                $ret->orderedproduct = 0;
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchen->ReadAccess)
                            {
                                if($_REQUEST['filter'] == "all")
                                {
                                    $store = Kitchenitem::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "instock")
                                {
                                    $store = Kitchenitem::InStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "outofstock")
                                {
                                    $store = Kitchenitem::OutofStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "lowstock")
                                {
                                    $store = Kitchenitem::LowStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "stockspan")
                                {
                                    $store = Kitchenitem::ByStockRange($GLOBALS['subscriber'], $_REQUEST['rangestart'], $_REQUEST['rangestop']);
                                }
                                $ret->instockcount = Kitchenitem::InStockItemsCount($GLOBALS['subscriber']);
                                $ret->lowstockcount = Kitchenitem::LowStockItemsCount($GLOBALS['subscriber']);
                                $ret->outofstockcount = Kitchenitem::OutofStockItemsCount($GLOBALS['subscriber']);
                                $ret->orderedproduct = 0;
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundry->ReadAccess)
                            {
                                if($_REQUEST['filter'] == "all")
                                {
                                    $store = Laundryitem::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "instock")
                                {
                                    $store = Laundryitem::InStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "outofstock")
                                {
                                    $store = Laundryitem::OutofStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "lowstock")
                                {
                                    $store = Laundryitem::LowStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "stockspan")
                                {
                                    $store = Laundryitem::ByStockRange($GLOBALS['subscriber'], $_REQUEST['rangestart'], $_REQUEST['rangestop']);
                                }
                                $ret->instockcount = Laundryitem::InStockItemsCount($GLOBALS['subscriber']);
                                $ret->lowstockcount = Laundryitem::LowStockItemsCount($GLOBALS['subscriber']);
                                $ret->outofstockcount = Laundryitem::OutofStockItemsCount($GLOBALS['subscriber']);
                                $ret->orderedproduct = 0;
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakery->ReadAccess)
                            {
                                if($_REQUEST['filter'] == "all")
                                {
                                    $store = Pastryitem::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "instock")
                                {
                                    $store = Pastryitem::InStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "outofstock")
                                {
                                    $store = Pastryitem::OutofStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "lowstock")
                                {
                                    $store = Pastryitem::LowStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "stockspan")
                                {
                                    $store = Pastryitem::ByStockRange($GLOBALS['subscriber'], $_REQUEST['rangestart'], $_REQUEST['rangestop']);
                                }
                                $ret->instockcount = Pastryitem::InStockItemsCount($GLOBALS['subscriber']);
                                $ret->lowstockcount = Pastryitem::LowStockItemsCount($GLOBALS['subscriber']);
                                $ret->outofstockcount = Pastryitem::OutofStockItemsCount($GLOBALS['subscriber']);
                                $ret->orderedproduct = 0;
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Pool->ReadAccess)
                            {
                                if($_REQUEST['filter'] == "all")
                                {
                                    $store = Poolitem::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "instock")
                                {
                                    $store = Poolitem::InStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "outofstock")
                                {
                                    $store = Poolitem::OutofStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "lowstock")
                                {
                                    $store = Poolitem::LowStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "stockspan")
                                {
                                    $store = Poolitem::ByStockRange($GLOBALS['subscriber'], $_REQUEST['rangestart'], $_REQUEST['rangestop']);
                                }
                                $ret->instockcount = Poolitem::InStockItemsCount($GLOBALS['subscriber']);
                                $ret->lowstockcount = Poolitem::LowStockItemsCount($GLOBALS['subscriber']);
                                $ret->outofstockcount = Poolitem::OutofStockItemsCount($GLOBALS['subscriber']);
                                $ret->orderedproduct = 0;
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "room_item")
                        {
                            if($GLOBALS['user']->Role->Rooms->ReadAccess)
                            {
                                if($_REQUEST['filter'] == "all")
                                {
                                    $store = Roomitem::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "instock")
                                {
                                    $store = Roomitem::InStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "outofstock")
                                {
                                    $store = Roomitem::OutofStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "lowstock")
                                {
                                    $store = Roomitem::LowStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "stockspan")
                                {
                                    $store = Roomitem::ByStockRange($GLOBALS['subscriber'], $_REQUEST['rangestart'], $_REQUEST['rangestop']);
                                }
                                $ret->instockcount = Roomitem::InStockItemsCount($GLOBALS['subscriber']);
                                $ret->lowstockcount = Roomitem::LowStockItemsCount($GLOBALS['subscriber']);
                                $ret->outofstockcount = Roomitem::OutofStockItemsCount($GLOBALS['subscriber']);
                                $ret->orderedproduct = 0;
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "store_item")
                        {
                            if($GLOBALS['user']->Role->Store->ReadAccess)
                            {
                                if($_REQUEST['filter'] == "all")
                                {
                                    $store = Storeitem::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "instock")
                                {
                                    $store = Storeitem::InStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "outofstock")
                                {
                                    $store = Storeitem::OutofStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "lowstock")
                                {
                                    $store = Storeitem::LowStockItems($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if($_REQUEST['filter'] == "stockspan")
                                {
                                    $store = Storeitem::ByStockRange($GLOBALS['subscriber'], $_REQUEST['rangestart'], $_REQUEST['rangestop']);
                                }
                                $ret->instockcount = Storeitem::InStockItemsCount($GLOBALS['subscriber']);
                                $ret->lowstockcount = Storeitem::LowStockItemsCount($GLOBALS['subscriber']);
                                $ret->outofstockcount = Storeitem::OutofStockItemsCount($GLOBALS['subscriber']);
                                $ret->orderedproduct = 0;
                            }
                        }


                        if($store !== null)
                        {
                            $ret->data = array();

                            $page = $_REQUEST['Page'];
                            $perpage = $_REQUEST['Perpage'];

                            $ret->Page = $page;
                            $ret->Perpage = $perpage;

                            $ret->Total = count($store);

                            //For listing all
                            if(Convert::ToInt($page) == 0)
                            {
                                $ret->data = $store;
                            }
                            else
                            {
                                $start = (($ret->Page - 1) * $ret->Perpage);
                                $stop = (($start + $ret->Perpage) - 1);

                                $x = 0;
                                for($i = $start; $i < count($store); $i++)
                                {
                                    $ret->data[$x] = $store[$i];
                                    if($i == $stop){break;}
                                    $x++;
                                }
                            }

                            $ret->status = "success";
                            $ret->message = "Inventory items retrieved successfully";
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