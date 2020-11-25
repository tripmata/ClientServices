<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $ret->data = null;

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Bar->ReadAccess)
                            {
                                $ret->data = new Baritem($GLOBALS['subscriber']);
                                $ret->data->Initialize($_REQUEST['itemid']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchen->ReadAccess)
                            {
                                $ret->data = new Kitchenitem($GLOBALS['subscriber']);
                                $ret->data->Initialize($_REQUEST['itemid']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundry->ReadAccess)
                            {
                                $ret->data = new Laundryitem($GLOBALS['subscriber']);
                                $ret->data->Initialize($_REQUEST['itemid']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakery->ReadAccess)
                            {
                                $ret->data = new Pastryitem($GLOBALS['subscriber']);
                                $ret->data->Initialize($_REQUEST['itemid']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Pool->ReadAccess)
                            {
                                $ret->data = new Poolitem($GLOBALS['subscriber']);
                                $ret->data->Initialize($_REQUEST['itemid']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "room_item")
                        {
                            if($GLOBALS['user']->Role->Rooms->ReadAccess)
                            {
                                $ret->data = new Roomitem($GLOBALS['subscriber']);
                                $ret->data->Initialize($_REQUEST['itemid']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "store_item")
                        {
                            if($GLOBALS['user']->Role->Store->ReadAccess)
                            {
                                $ret->data = new Storeitem($GLOBALS['subscriber']);
                                $ret->data->Initialize($_REQUEST['itemid']);
                            }
                        }


                        if($ret->data !== null)
                        {
                            $ret->status = "success";
                            $ret->message = "Inventory item retrieved successfully";
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