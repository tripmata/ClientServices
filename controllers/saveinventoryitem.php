<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $item = null;
                        $openingActivity = null;

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Bar->WriteAccess)
                            {
                                $item = new Baritem($GLOBALS['subscriber']);
                                $item->Initialize($_REQUEST['itemid']);

                                $openingActivity = new Barinventoryactivity($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchen->WriteAccess)
                            {
                                $item = new Kitchenitem($GLOBALS['subscriber']);
                                $item->Initialize($_REQUEST['itemid']);
                                
                                $openingActivity = new Kitcheninventoryactivity($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundry->WriteAccess)
                            {
                                $item = new Laundryitem($GLOBALS['subscriber']);
                                $item->Initialize($_REQUEST['itemid']);

                                $openingActivity = new Laundryinventoryactivity($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakery->WriteAccess)
                            {
                                $item = new Pastryitem($GLOBALS['subscriber']);
                                $item->Initialize($_REQUEST['itemid']);

                                $openingActivity = new Pastryinventoryactivity($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Pool->WriteAccess)
                            {
                                $item = new Poolitem($GLOBALS['subscriber']);
                                $item->Initialize($_REQUEST['itemid']);

                                $openingActivity = new Poolinventoryactivity($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "room_item")
                        {
                            if($GLOBALS['user']->Role->Rooms->WriteAccess)
                            {
                                $item = new Roomitem($GLOBALS['subscriber']);
                                $item->Initialize($_REQUEST['itemid']);

                                $openingActivity = new Roominventoryactivity($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "store_item")
                        {
                            if($GLOBALS['user']->Role->Store->WriteAccess)
                            {
                                $item = new Storeitem($GLOBALS['subscriber']);
                                $item->Initialize($_REQUEST['itemid']);

                                $openingActivity = new Storeinventoryactivity($GLOBALS['subscriber']);
                            }
                        }


                        if($item !== null)
                        {
                            $item->Image = $_REQUEST['image'];
                            $item->Name = $_REQUEST['name'];
                            $item->Unit = $_REQUEST['unit'];
                            $item->Pluralunit = $_REQUEST['pluralunit'];
                            $item->Sku = $_REQUEST['sku'];
                            $item->Productid = $_REQUEST['productid'];
                            $item->Lowstockpoint = Convert::ToInt($_REQUEST['lowstockpoint']);

                            $suppliers = explode(",", $_REQUEST['suppliers']);
                            $item->Suppliers = [];

                            for($i = 0; $i < count($suppliers); $i++)
                            {
                                if($suppliers[$i] != "")
                                {
                                    array_push($item->Suppliers, $suppliers[$i]);
                                }
                            }
                            $item->SetSuppliers($item->Suppliers);

                            //Check if Item is newly added and opeing stock
                            if($item->Id == "")
                            {
                                $item->Openingstock = Convert::ToInt($_REQUEST['openingstock']);
                                $item->Creator = $user;
                                $item->Stock = Convert::ToInt($_REQUEST['openingstock']);
                                $item->Save();

                                $openingActivity->Item = $item;
                                $openingActivity->Initialstock = 0;
                                $openingActivity->Newstock = Convert::ToInt($_REQUEST['openingstock']);
                                $openingActivity->Difference = Convert::ToInt($_REQUEST['openingstock']);;
                                $openingActivity->Order = null;
                                $openingActivity->Type = Inventoryactivity::Opening;
                                $openingActivity->Increment = true;
                                $openingActivity->User = $_REQUEST['usersess'];
                                $openingActivity->Note = "Opening";
                                $openingActivity->Save();
                            }
                            else
                            {
                                $item->Save();
                            }

                            $ret->status = "success";
                            $ret->message = "Inventory item saved successfully";
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