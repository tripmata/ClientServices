<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Id != "")
                        {
                            $GLOBALS['user']->UpdateSeenTime();
                        }

                        $items = null;

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Barpos->ReadAccess)
                            {
                                $items = Drink::Filter($GLOBALS['subscriber'], 1, 'pos');
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchenpos->ReadAccess)
                            {
                                $items = Food::Filter($GLOBALS['subscriber'], 1, 'pos');
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundrypos->ReadAccess)
                            {
                                $items = Laundry::filter($GLOBALS['subscriber'], 1, 'status');
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakerypos->ReadAccess)
                            {
                                $items = Pastry::Filter($GLOBALS['subscriber'], 1, 'pos');
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Poolpos->ReadAccess)
                            {
                                $items = Pool::filter($GLOBALS['subscriber'], 1, 'status');
                            }
                        }


                        if($items !== null)
                        {
                            $ret->data = $items;
                            $ret->status = "success";
                            $ret->message = "Item list successfully retrieved";
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