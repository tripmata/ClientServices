<?php

	$ret = new stdClass();

                if($GLOBALS['user']->Id != "")
                {
                    

                    $audit = null;
                    $itemscount = 0;

                    if(strtolower($_REQUEST['item_type']) == "bar_item")
                    {
                        if($GLOBALS['user']->Role->Bar->ReadAccess)
                        {
                            $audit = Baraudit::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                            $itemscount = count(Baritem::All($GLOBALS['subscriber']));
                        }
                    }
                    if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                    {
                        if($GLOBALS['user']->Role->Kitchen->ReadAccess)
                        {
                            $audit = Kitchenaudit::Search($GLOBALS['subscriber'],  $_REQUEST['searchterm']);
                            $itemscount = count(Kitchenitem::All($GLOBALS['subscriber']));
                        }
                    }
                    if(strtolower($_REQUEST['item_type']) == "laundry_item")
                    {
                        if($GLOBALS['user']->Role->Laundry->ReadAccess)
                        {
                            $audit = Laundryaudit::Search($GLOBALS['subscriber'],  $_REQUEST['searchterm']);
                            $itemscount = count(Laundryitem::All($GLOBALS['subscriber']));
                        }
                    }
                    if(strtolower($_REQUEST['item_type']) == "pastry_item")
                    {
                        if($GLOBALS['user']->Role->Bakery->ReadAccess)
                        {
                            $audit = Pastryaudit::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                            $itemscount = count(Pastryitem::All($GLOBALS['subscriber']));
                        }
                    }
                    if(strtolower($_REQUEST['item_type']) == "pool_item")
                    {
                        if($GLOBALS['user']->Role->Pool->ReadAccess)
                        {
                            $audit = Poolaudit::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                            $itemscount = count(Poolitem::All($GLOBALS['subscriber']));
                        }
                    }
                    if(strtolower($_REQUEST['item_type']) == "room_item")
                    {
                        if($GLOBALS['user']->Role->Rooms->ReadAccess)
                        {
                            $audit = Roomaudit::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                            $itemscount = count(Roomitem::All($GLOBALS['subscriber']));
                        }
                    }
                    if(strtolower($_REQUEST['item_type']) == "store_item")
                    {
                        if($GLOBALS['user']->Role->Store->ReadAccess)
                        {
                            $audit = Storeaudit::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                            $itemscount = count(Storeitem::All($GLOBALS['subscriber']));
                        }
                    }


                    if($audit !== null)
                    {
                        $ret->data = array();

                        $page = $_REQUEST['Page'];
                        $perpage = $_REQUEST['Perpage'];

                        $ret->Itemscount = $itemscount;

                        $ret->Page = $page;
                        $ret->Perpage = $perpage;

                        $ret->Total = count($audit);

                        //For listing all
                        if(Convert::ToInt($page) == 0)
                        {
                            $ret->data = $audit;
                        }
                        else
                        {
                            $start = (($ret->Page - 1) * $ret->Perpage);
                            $stop = (($start + $ret->Perpage) - 1);

                            $x = 0;
                            for($i = $start; $i < count($audit); $i++)
                            {
                                $ret->data[$x] = $audit[$i];
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