<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Id != "")
                        {
                            $GLOBALS['user']->UpdateSeenTime();
                        }

                        $orders = null;

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Barpos->ReadAccess)
                            {
                                $orders = Barorder::Filter($GLOBALS['subscriber'], 0, 'fullfilled');
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchenpos->ReadAccess)
                            {
                                $orders = Kitchenorder::Filter($GLOBALS['subscriber'], 0, 'fullfilled');
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundrypos->ReadAccess)
                            {
                                $orders = Laundryorder::Filter($GLOBALS['subscriber'], 0, 'fullfilled');
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakerypos->ReadAccess)
                            {
                                $orders = Bakeryorder::Filter($GLOBALS['subscriber'], 0, 'fullfilled');
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Poolpos->ReadAccess)
                            {
                                $orders = Poolorder::Filter($GLOBALS['subscriber'], 0, 'fullfilled');
                            }
                        }


                        if($orders !== null)
                        {
                            $ret->data = $orders;
                            $ret->status = "success";
                            $ret->message = "online orders retrieved successfully";
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