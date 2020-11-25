<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Kitchen->WriteAccess)
                        {
                            $food = new Food($GLOBALS['subscriber']);
                            $food->Initialize($_REQUEST['foodid']);

                            $food->Name = $_REQUEST['name'];
                            $food->Category = $_REQUEST['category'];
                            $food->Onsite = Convert::ToBool($_REQUEST['showonsite']);
                            $food->Status = Convert::ToBool($_REQUEST['status']);
                            $food->Showpromo = Convert::ToBool($_REQUEST['showpromo']);
                            $food->Reservable = Convert::ToBool($_REQUEST['reservable']);
                            $food->Trackinventory = Convert::ToBool($_REQUEST['inventory']);
                            $food->Sort = Convert::ToInt($_REQUEST['sort']);
                            $food->Price = floatval($_REQUEST['price']);
                            $food->Tax = floatval($_REQUEST['tax']);
                            $food->Compareat = floatval($_REQUEST['compare']);
                            $food->Pos = Convert::ToBool($_REQUEST['pos']);
                            $food->Barcode = $_REQUEST['barcode'];
                            $food->Costprice = $_REQUEST['cost'];
                            $food->Images = array();

                            $images = explode(",", $_REQUEST['images']);
                            for($i = 0; $i < count($images); $i++)
                            {
                                if($images[$i] != "")
                                {
                                    array_push($food->Images, $images[$i]);
                                }
                            }

                            $food->Description = $_REQUEST['description'];
                            $food->Promotext = $_REQUEST['promotext'];

                            //Inventory components
                            $item = null;
                            $openingActivity = null;

                            //Check if product has been added before
                            if((Convert::ToBool($_REQUEST['inventory'])) && ($food->Id == ""))
                            {
                                $item = new Kitchenitem($GLOBALS['subscriber']);
                                $openingActivity = new Kitcheninventoryactivity($GLOBALS['subscriber']);
                            }
                            $food->Save();

                            if($item != null)
                            {
                                $item->Image = count($food->Images) > 0 ? $food->Images[0] : "";
                                $item->Name = $food->Name;
                                $item->Unit = $_REQUEST['unit'];
                                $item->Pluralunit = $_REQUEST['pluralunit'];
                                $item->Sku = $food->Barcode;
                                $item->Productid = $food->Id;
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


                            $ret->status = "success";
                            $ret->message = "food saved successfully";
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