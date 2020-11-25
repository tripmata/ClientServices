<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $po = null;

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Bar->WriteAccess)
                            {
                                $po = Barpo::ByReference($GLOBALS['subscriber'], $_REQUEST['reference']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchen->WriteAccess)
                            {
                                $po = Kitchenpo::ByReference($GLOBALS['subscriber'], $_REQUEST['reference']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundry->WriteAccess)
                            {
                                $po = Laundrypo::ByReference($GLOBALS['subscriber'], $_REQUEST['reference']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakery->WriteAccess)
                            {
                                $po = Pastrypo::ByReference($GLOBALS['subscriber'], $_REQUEST['reference']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Pool->WriteAccess)
                            {
                                $po = Poolpo::ByReference($GLOBALS['subscriber'], $_REQUEST['reference']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "room_item")
                        {
                            if($GLOBALS['user']->Role->Rooms->WriteAccess)
                            {
                                $po = Roompo::ByReference($GLOBALS['subscriber'], $_REQUEST['reference']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "store_item")
                        {
                            if($GLOBALS['user']->Role->Store->WriteAccess)
                            {
                                $po = Storepo::ByReference($GLOBALS['subscriber'], $_REQUEST['reference']);
                            }
                        }


                        if($po !== null)
                        {
                            $ret->data = $po;

                            $ret->status = "success";
                            $ret->message = "Purchase request retrieved successfully";
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