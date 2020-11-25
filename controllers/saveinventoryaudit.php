<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $audit = null;

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Bar->WriteAccess)
                            {
                                $audit = new Baraudit($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchen->WriteAccess)
                            {
                                $audit = new Kitchenaudit($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundry->WriteAccess)
                            {
                                $audit = new Laundryaudit($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakery->WriteAccess)
                            {
                                $audit = new Pastryaudit($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Pool->WriteAccess)
                            {
                                $audit = new Poolaudit($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "room_item")
                        {
                            if($GLOBALS['user']->Role->Rooms->WriteAccess)
                            {
                                $audit = new Roomaudit($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "store_item")
                        {
                            if($GLOBALS['user']->Role->Store->WriteAccess)
                            {
                                $audit = new Storeaudit($GLOBALS['subscriber']);
                            }
                        }


                        if($audit !== null)
                        {
                            $audit->Initialize($_REQUEST['id']);
                            $audit->Title = ucwords(strtolower($_REQUEST['title']));
                            $audit->Save();

                            $ret->status = "success";
                            $ret->message = "audit session saved successfully";
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