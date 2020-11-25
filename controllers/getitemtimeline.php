<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $store = null;

                        $span = new Timespan(new WixDate($_REQUEST['starttime']), new WixDate($_REQUEST['stoptime']), true);

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Bar->ReadAccess)
                            {
                                if(strtolower($_REQUEST['filter']) == "all")
                                {
                                    $store = Barinventoryactivity::TimelineAll($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "usage")
                                {
                                    $store = Barinventoryactivity::TimelineUsage($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "restocking")
                                {
                                    $store = Barinventoryactivity::TimelineRestocking($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "surplus")
                                {
                                    $store = Barinventoryactivity::TimelineSurplus($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "damages")
                                {
                                    $store = Barinventoryactivity::TimelineDamages($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "returns")
                                {
                                    $store = Barinventoryactivity::TimelineReturns($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                $ret->Item = new Baritem($GLOBALS['subscriber']);
                                $ret->Item->Initialize($_REQUEST['itemid']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchen->ReadAccess)
                            {
                                if(strtolower($_REQUEST['filter']) == "all")
                                {
                                    $store = Kitcheninventoryactivity::TimelineAll($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "usage")
                                {
                                    $store = Kitcheninventoryactivity::TimelineUsage($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "restocking")
                                {
                                    $store = Kitcheninventoryactivity::TimelineRestocking($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "surplus")
                                {
                                    $store = Kitcheninventoryactivity::TimelineSurplus($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "damages")
                                {
                                    $store = Kitcheninventoryactivity::TimelineDamages($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "returns")
                                {
                                    $store = Kitcheninventoryactivity::TimelineReturns($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                $ret->Item = new Kitchenitem($GLOBALS['subscriber']);
                                $ret->Item->Initialize($_REQUEST['itemid']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundry->ReadAccess)
                            {
                                if(strtolower($_REQUEST['filter']) == "all")
                                {
                                    $store = Laundryinventoryactivity::TimelineAll($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "usage")
                                {
                                    $store = Laundryinventoryactivity::TimelineUsage($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "restocking")
                                {
                                    $store = Laundryinventoryactivity::TimelineRestocking($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "surplus")
                                {
                                    $store = Laundryinventoryactivity::TimelineSurplus($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "damages")
                                {
                                    $store = Laundryinventoryactivity::TimelineDamages($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "returns")
                                {
                                    $store = Laundryinventoryactivity::TimelineReturns($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                $ret->Item = new Laundryitem($GLOBALS['subscriber']);
                                $ret->Item->Initialize($_REQUEST['itemid']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakery->ReadAccess)
                            {
                                if(strtolower($_REQUEST['filter']) == "all")
                                {
                                    $store = Pastryinventoryactivity::TimelineAll($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "usage")
                                {
                                    $store = Pastryinventoryactivity::TimelineUsage($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "restocking")
                                {
                                    $store = Pastryinventoryactivity::TimelineRestocking($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "surplus")
                                {
                                    $store = Pastryinventoryactivity::TimelineSurplus($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "damages")
                                {
                                    $store = Pastryinventoryactivity::TimelineDamages($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "returns")
                                {
                                    $store = Pastryinventoryactivity::TimelineReturns($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                $ret->Item = new Pastryitem($GLOBALS['subscriber']);
                                $ret->Item->Initialize($_REQUEST['itemid']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Pool->ReadAccess)
                            {
                                if(strtolower($_REQUEST['filter']) == "all")
                                {
                                    $store = Poolinventoryactivity::TimelineAll($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "usage")
                                {
                                    $store = Poolinventoryactivity::TimelineUsage($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "restocking")
                                {
                                    $store = Poolinventoryactivity::TimelineRestocking($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "surplus")
                                {
                                    $store = Poolinventoryactivity::TimelineSurplus($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "damages")
                                {
                                    $store = Poolinventoryactivity::TimelineDamages($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "returns")
                                {
                                    $store = Poolinventoryactivity::TimelineReturns($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                $ret->Item = new Poolitem($GLOBALS['subscriber']);
                                $ret->Item->Initialize($_REQUEST['itemid']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "room_item")
                        {
                            if($GLOBALS['user']->Role->Rooms->ReadAccess)
                            {
                                if(strtolower($_REQUEST['filter']) == "all")
                                {
                                    $store = Roominventoryactivity::TimelineAll($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "usage")
                                {
                                    $store = Roominventoryactivity::TimelineUsage($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "restocking")
                                {
                                    $store = Roominventoryactivity::TimelineRestocking($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "surplus")
                                {
                                    $store = Roominventoryactivity::TimelineSurplus($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "damages")
                                {
                                    $store = Roominventoryactivity::TimelineDamages($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "returns")
                                {
                                    $store = Roominventoryactivity::TimelineReturns($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                $ret->Item = new Roomitem($GLOBALS['subscriber']);
                                $ret->Item->Initialize($_REQUEST['itemid']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "store_item")
                        {
                            if($GLOBALS['user']->Role->Store->ReadAccess)
                            {
                                if(strtolower($_REQUEST['filter']) == "all")
                                {
                                    $store = Storeinventoryactivity::TimelineAll($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "usage")
                                {
                                    $store = Storeinventoryactivity::TimelineUsage($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "restocking")
                                {
                                    $store = Storeinventoryactivity::TimelineRestocking($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "surplus")
                                {
                                    $store = Storeinventoryactivity::TimelineSurplus($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "damages")
                                {
                                    $store = Storeinventoryactivity::TimelineDamages($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                if(strtolower($_REQUEST['filter']) == "returns")
                                {
                                    $store = Storeinventoryactivity::TimelineReturns($GLOBALS['subscriber'], $span, $_REQUEST['itemid']);
                                }
                                $ret->Item = new Storeitem($GLOBALS['subscriber']);
                                $ret->Item->Initialize($_REQUEST['itemid']);
                            }
                        }


                        if($store !== null)
                        {
                            $ret->data = $store;
                            $ret->Stats = Inventoryactivity::BuildStatistics($store);
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