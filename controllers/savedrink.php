<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Bar->WriteAccess)
                        {
                            $drink = new Drink($GLOBALS['subscriber']);
                            $drink->Initialize($_REQUEST['drinkid']);

                            $drink->Name = $_REQUEST['name'];
                            $drink->Category = $_REQUEST['category'];
                            $drink->Onsite = Convert::ToBool($_REQUEST['showonsite']);
                            $drink->Status = Convert::ToBool($_REQUEST['status']);
                            $drink->Showpromo = Convert::ToBool($_REQUEST['showpromo']);
                            $drink->Reservable = Convert::ToBool($_REQUEST['reservable']);
                            $drink->Trackinventory = Convert::ToBool($_REQUEST['inventory']);
                            $drink->Sort = Convert::ToInt($_REQUEST['sort']);
                            $drink->Price = floatval($_REQUEST['price']);
                            $drink->Tax = floatval($_REQUEST['tax']);
                            $drink->Compareat = floatval($_REQUEST['compare']);
                            $drink->Pos = Convert::ToBool($_REQUEST['pos']);
                            $drink->Barcode = $_REQUEST['barcode'];
                            $drink->Costprice = $_REQUEST['cost'];
                            $drink->Images = array();

                            $images = explode(",", $_REQUEST['images']);
                            for($i = 0; $i < count($images); $i++)
                            {
                                if($images[$i] != "")
                                {
                                    array_push($drink->Images, $images[$i]);
                                }
                            }

                            $drink->Description = $_REQUEST['description'];
                            $drink->Promotext = $_REQUEST['promotext'];


                            //Inventory components
                            $item = null;
                            $openingActivity = null;

                            //Check if product has been added before
                            if((Convert::ToBool($_REQUEST['inventory'])) && ($drink->Id == ""))
                            {
                                $item = new Baritem($GLOBALS['subscriber']);
                                $openingActivity = new Barinventoryactivity($GLOBALS['subscriber']);
                            }
                            $drink->Save();

                            if($item != null)
                            {
                                $item->Image = count($drink->Images) > 0 ? $drink->Images[0] : "";
                                $item->Name = $drink->Name;
                                $item->Unit = $_REQUEST['unit'];
                                $item->Pluralunit = $_REQUEST['pluralunit'];
                                $item->Sku = $drink->Barcode;
                                $item->Productid = $drink->Id;
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
                            $ret->message = "drinks saved successfully";
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