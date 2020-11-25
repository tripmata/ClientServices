<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $audit = null;
                        $items = null;

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Bar->ReadAccess)
                            {
                                $audit = new Baraudit($GLOBALS['subscriber']);
                                $items = Baritem::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchen->ReadAccess)
                            {
                                $audit = new Kitchenaudit($GLOBALS['subscriber']);
                                $items = Kitchenitem::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundry->ReadAccess)
                            {
                                $audit = new Laundryaudit($GLOBALS['subscriber']);
                                $items = Laundryitem::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakery->ReadAccess)
                            {
                                $audit = new Pastryaudit($GLOBALS['subscriber']);
                                $items = Pastryitem::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Pool->ReadAccess)
                            {
                                $audit = new  Poolaudit($GLOBALS['subscriber']);
                                $items = Poolitem::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "room_item")
                        {
                            if($GLOBALS['user']->Role->Rooms->ReadAccess)
                            {
                                $audit = new  Roomaudit($GLOBALS['subscriber']);
                                $items = Roomitem::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "store_item")
                        {
                            if($GLOBALS['user']->Role->Store->ReadAccess)
                            {
                                $audit = new  Storeaudit($GLOBALS['subscriber']);
                                $items = Storeitem::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                            }
                        }


                        if($audit !== null)
                        {
                            $audit->Initialize($_REQUEST['auditid']);

                            $audit->initStockCount();

                            $ret->data = new stdClass();
                            $ret->data->Items = [];
                            $ret->data->Audits = $audit;

                            $page = $_REQUEST['Page'];
                            $perpage = $_REQUEST['Perpage'];


                            $ret->Page = $page;
                            $ret->Perpage = $perpage;

                            $ret->Total = count($items);


                            $start = (($ret->Page - 1) * $ret->Perpage);
                            $stop = (($start + $ret->Perpage) - 1);

                            $x = 0;
                            for($i = $start; $i < count($items); $i++)
                            {
                                $ret->data->Items[$x] = $items[$i];
                                if($i == $stop){break;}
                                $x++;
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