<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Id != "")
                        {
                            $GLOBALS['user']->UpdateSeenTime();
                        }

                        $module = new Modules($GLOBALS['subscriber']);

                        $discount = null;

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Barpos->ReadAccess)
                            {
                                if($module->Discount)
                                {
                                    $discount = Discount::Barcovered($GLOBALS['subscriber']);
                                }
                                else
                                {
                                    $discount = [];
                                }
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchenpos->ReadAccess)
                            {
                                if($module->Discount)
                                {
                                    $discount = Discount::Foodcovered($GLOBALS['subscriber']);
                                }
                                else
                                {
                                    $discount = [];
                                }
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundrypos->ReadAccess)
                            {
                                if($module->Discount)
                                {
                                    $discount = Discount::Laundrycovered($GLOBALS['subscriber']);
                                }
                                else
                                {
                                    $discount = [];
                                }
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakerypos->ReadAccess)
                            {
                                if($module->Discount)
                                {
                                    $discount = Discount::Pastrycovered($GLOBALS['subscriber']);
                                }
                                else
                                {
                                    $discount = [];
                                }
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Poolpos->ReadAccess)
                            {
                                if($module->Discount)
                                {
                                    $discount = Discount::Poolcovered($GLOBALS['subscriber']);
                                }
                                else
                                {
                                    $discount = [];
                                }
                            }
                        }


                        if($discount !== null)
                        {
                            $ret->data = $discount;
                            $ret->status = "success";
                            $ret->message = "pos discount retrieved successfully";
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