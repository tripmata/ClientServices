<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $store = null;

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Bar->ReadAccess)
                            {
                                if(strtolower($_REQUEST['filter']) == "all")
                                {
                                    $store = Barpr::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "fulfilled")
                                {
                                    $store = Barpr::Fulfilled($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "pending")
                                {
                                    $store = Barpr::Pending($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "processing")
                                {
                                    $store = Barpr::Processing($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }

                                $ret->All = Barpr::AllCount($GLOBALS['subscriber']);
                                $ret->Fulfilled = Barpr::FulfilledCount($GLOBALS['subscriber']);
                                $ret->Processing = Barpr::ProcessingCount($GLOBALS['subscriber']);
                                $ret->Pending = Barpr::PendingCount($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchen->ReadAccess)
                            {
                                if(strtolower($_REQUEST['filter']) == "all")
                                {
                                    $store = Kitchenpr::Search($GLOBALS['subscriber'],  $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "fulfilled")
                                {
                                    $store = Kitchenpr::Fulfilled($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "pending")
                                {
                                    $store = Kitchenpr::Pending($GLOBALS['subscriber'],  $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "processing")
                                {
                                    $store = Kitchenpr::Processing($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                $ret->All = Kitchenpr::AllCount($GLOBALS['subscriber']);
                                $ret->Fulfilled = Kitchenpr::FulfilledCount($GLOBALS['subscriber']);
                                $ret->Processing = Kitchenpr::ProcessingCount($GLOBALS['subscriber']);
                                $ret->Pending = Kitchenpr::PendingCount($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundry->ReadAccess)
                            {
                                if(strtolower($_REQUEST['filter']) == "all")
                                {
                                    $store = Laundrypr::Search($GLOBALS['subscriber'],  $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "fulfilled")
                                {
                                    $store = Laundrypr::Fulfilled($GLOBALS['subscriber'],  $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "pending")
                                {
                                    $store = Laundrypr::Pending($GLOBALS['subscriber'],  $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "processing")
                                {
                                    $store = Laundrypr::Processing($GLOBALS['subscriber'],  $_REQUEST['searchterm']);
                                }
                                $ret->All = Laundrypr::AllCount($GLOBALS['subscriber']);
                                $ret->Fulfilled = Laundrypr::FulfilledCount($GLOBALS['subscriber']);
                                $ret->Processing = Laundrypr::ProcessingCount($GLOBALS['subscriber']);
                                $ret->Pending = Laundrypr::PendingCount($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakery->ReadAccess)
                            {
                                if(strtolower($_REQUEST['filter']) == "all")
                                {
                                    $store = Pastrypr::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "fulfilled")
                                {
                                    $store = Pastrypr::Fulfilled($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "pending")
                                {
                                    $store = Pastrypr::Pending($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "processing")
                                {
                                    $store = Pastrypr::Processing($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                $ret->All = Pastrypr::AllCount($GLOBALS['subscriber']);
                                $ret->Fulfilled = Pastrypr::FulfilledCount($GLOBALS['subscriber']);
                                $ret->Processing = Pastrypr::ProcessingCount($GLOBALS['subscriber']);
                                $ret->Pending = Pastrypr::PendingCount($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Pool->ReadAccess)
                            {
                                if(strtolower($_REQUEST['filter']) == "all")
                                {
                                    $store = Poolpr::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "fulfilled")
                                {
                                    $store = Poolpr::Fulfilled($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "pending")
                                {
                                    $store = Poolpr::Pending($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "processing")
                                {
                                    $store = Poolpr::Processing($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                $ret->All = Poolpr::AllCount($GLOBALS['subscriber']);
                                $ret->Fulfilled = Poolpr::FulfilledCount($GLOBALS['subscriber']);
                                $ret->Processing = Poolpr::ProcessingCount($GLOBALS['subscriber']);
                                $ret->Pending = Poolpr::PendingCount($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "room_item")
                        {
                            if($GLOBALS['user']->Role->Rooms->ReadAccess)
                            {
                                if(strtolower($_REQUEST['filter']) == "all")
                                {
                                    $store = Roompr::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "fulfilled")
                                {
                                    $store = Roompr::Fulfilled($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "pending")
                                {
                                    $store = Roompr::Pending($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "processing")
                                {
                                    $store = Roompr::Processing($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                $ret->All = Roompr::AllCount($GLOBALS['subscriber']);
                                $ret->Fulfilled = Roompr::FulfilledCount($GLOBALS['subscriber']);
                                $ret->Processing = Roompr::ProcessingCount($GLOBALS['subscriber']);
                                $ret->Pending = Roompr::PendingCount($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "store_item")
                        {
                            if($GLOBALS['user']->Role->Store->ReadAccess)
                            {
                                if(strtolower($_REQUEST['filter']) == "all")
                                {
                                    $store = Storepr::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "fulfilled")
                                {
                                    $store = Storepr::Fulfilled($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "pending")
                                {
                                    $store = Storepr::Pending($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                if(strtolower($_REQUEST['filter']) == "processing")
                                {
                                    $store = Storepr::Processing($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                                }
                                $ret->All = Storepr::AllCount($GLOBALS['subscriber']);
                                $ret->Fulfilled = Storepr::FulfilledCount($GLOBALS['subscriber']);
                                $ret->Processing = Storepr::ProcessingCount($GLOBALS['subscriber']);
                                $ret->Pending = Storepr::PendingCount($GLOBALS['subscriber']);
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