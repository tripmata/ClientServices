<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $purchaserequest = null;

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Bar->WriteAccess)
                            {
                                $purchaserequest = new Barpr($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchen->WriteAccess)
                            {
                                $purchaserequest = new Kitchenpr($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundry->WriteAccess)
                            {
                                $purchaserequest = new Laundrypr($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakery->WriteAccess)
                            {
                                $purchaserequest = new Pastrypr($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Pool->WriteAccess)
                            {
                                $purchaserequest = new Poolpr($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "room_item")
                        {
                            if($GLOBALS['user']->Role->Rooms->WriteAccess)
                            {
                                $purchaserequest = new Roompr($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "store_item")
                        {
                            if($GLOBALS['user']->Role->Store->WriteAccess)
                            {
                                $purchaserequest = new Storepr($GLOBALS['subscriber']);

                            }
                        }


                        if($purchaserequest !== null)
                        {
                            $purchaserequest->Initialize($_REQUEST['prid']);

                            if($purchaserequest->Order_reference == "")
                            {
                                $ar = explode(",", $_REQUEST['data']);

                                $itemList = [];
                                for ($i = 0; $i < count($ar); $i++)
                                {
                                    $prdnum = explode(":", $ar[$i]);

                                    if (count($prdnum) == 3)
                                    {
                                        $purchaseitem = new Purchaserequestitem($GLOBALS['subscriber']);
                                        $purchaseitem->TryRetrieve($purchaserequest->Id, $prdnum[0]);

                                        $purchaseitem->Item = $prdnum[0];
                                        $purchaseitem->Quantity = $prdnum[1];
                                        $purchaseitem->Rate = $prdnum[2];

                                        $purchaseitem->Save();

                                        array_push($itemList, $purchaseitem);
                                    }
                                    else
                                    {
                                        $ret->status = "failed";
                                        $ret->message = "Inaccurate data received";
                                        goto end;
                                    }
                                }

                                $purchaserequest->Note = $_REQUEST['note'];
                                $purchaserequest->Items = $itemList;
                                $purchaserequest->Fulfilled = false;
                                $purchaserequest->User = $_REQUEST['usersess'];
                                $purchaserequest->Save();

                                for($i = 0; $i < count($itemList); $i++)
                                {
                                    if($itemList[$i]->Pr == "")
                                    {
                                        $itemList[$i]->attachPr($purchaseitem->Id);
                                    }
                                }

                                $ret->status = "success";
                                $ret->message = "Purchase request saved successfully";
                            }
                            else
                            {
                                $ret->status = "access denied";
                                $ret->message = "The order for the request have been generated and changes to the request cannot be saved. Try deleting the request and creating a new one";
                            }
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