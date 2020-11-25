<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $coupon = Coupon::byCode($GLOBALS['subscriber'], $_REQUEST['code']);

                        if($coupon != null)
                        {
                            if(!$coupon->Used)
                            {
                                if(!(($coupon->Expires) && ($coupon->Expirydate < time())))
                                {
                                    if(strtolower($_REQUEST['item_type']) == "bar_item")
                                    {
                                        if($GLOBALS['user']->Role->Barpos->ReadAccess)
                                        {
                                            if(count($coupon->Drinks) > 0)
                                            {
                                                $ret->status = "success";
                                                $ret->data = $coupon;
                                                $ret->message = "Coupon retrieved successfully";
                                            }
                                            else
                                            {
                                                $ret->status = "failed";
                                                $ret->data = null;
                                                $ret->message = "No drink is covered by the coupon";
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "access denied";
                                            $ret->message = "You do not have the required privilege to complete the operation";
                                        }
                                    }
                                    if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                                    {
                                        if($GLOBALS['user']->Role->Kitchenpos->ReadAccess)
                                        {
                                            if(count($coupon->Food) > 0)
                                            {
                                                $ret->status = "success";
                                                $ret->data = $coupon;
                                                $ret->message = "Coupon retrieved successfully";
                                            }
                                            else
                                            {
                                                $ret->status = "failed";
                                                $ret->data = null;
                                                $ret->message = "No food is covered by the coupon";
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "access denied";
                                            $ret->message = "You do not have the required privilege to complete the operation";
                                        }
                                    }
                                    if(strtolower($_REQUEST['item_type']) == "laundry_item")
                                    {
                                        if($GLOBALS['user']->Role->Kitchenpos->ReadAccess)
                                        {
                                            if(count($coupon->Laundry) > 0)
                                            {
                                                $ret->status = "success";
                                                $ret->data = $coupon;
                                                $ret->message = "Coupon retrieved successfully";
                                            }
                                            else
                                            {
                                                $ret->status = "failed";
                                                $ret->data = null;
                                                $ret->message = "No laundry is covered by the coupon";
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "access denied";
                                            $ret->message = "You do not have the required privilege to complete the operation";
                                        }
                                    }
                                    if(strtolower($_REQUEST['item_type']) == "pastry_item")
                                    {
                                        if($GLOBALS['user']->Role->Bakerypos->ReadAccess)
                                        {
                                            if(count($coupon->Laundry) > 0)
                                            {
                                                $ret->status = "success";
                                                $ret->data = $coupon;
                                                $ret->message = "Coupon retrieved successfully";
                                            }
                                            else
                                            {
                                                $ret->status = "failed";
                                                $ret->data = null;
                                                $ret->message = "No laundry item is covered by the coupon";
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "access denied";
                                            $ret->message = "You do not have the required privilege to complete the operation";
                                        }
                                    }
                                    if(strtolower($_REQUEST['item_type']) == "pool_item")
                                    {
                                        if($GLOBALS['user']->Role->Poolpos->ReadAccess)
                                        {
                                            if(count($coupon->Pool) > 0)
                                            {
                                                $ret->status = "success";
                                                $ret->data = $coupon;
                                                $ret->message = "Coupon retrieved successfully";
                                            }
                                            else
                                            {
                                                $ret->status = "failed";
                                                $ret->data = null;
                                                $ret->message = "No pool item is covered by the coupon";
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "access denied";
                                            $ret->message = "You do not have the required privilege to complete the operation";
                                        }
                                    }
                                }
                                else
                                {
                                    $ret->status = "coupon error";
                                    $ret->message = "Expired coupon";
                                }
                            }
                            else
                            {
                                $ret->status = "coupon error";
                                $ret->message = "Used coupon";
                            }
                        }
                        else
                        {
                            $ret->status = "coupon error";
                            $ret->message = "Invalid code";
                        }
                    }
                    else
                    {
                        $ret->status = "login";
                        $ret->data = "login & try again";
                    }


	echo json_encode($ret);