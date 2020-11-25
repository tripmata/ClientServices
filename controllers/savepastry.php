<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Bakery->WriteAccess)
                        {
                            $pastry = new Pastry($GLOBALS['subscriber']);
                            $pastry->Initialize($_REQUEST['pastryid']);

                            $pastry->Name = $_REQUEST['name'];
                            $pastry->Category = $_REQUEST['category'];
                            $pastry->Onsite = Convert::ToBool($_REQUEST['showonsite']);
                            $pastry->Status = Convert::ToBool($_REQUEST['status']);
                            $pastry->Showpromo = Convert::ToBool($_REQUEST['showpromo']);
                            $pastry->Reservable = Convert::ToBool($_REQUEST['reservable']);
                            $pastry->Trackinventory = Convert::ToBool($_REQUEST['inventory']);
                            $pastry->Sort = Convert::ToInt($_REQUEST['sort']);
                            $pastry->Price = floatval($_REQUEST['price']);
                            $pastry->Tax = floatval($_REQUEST['tax']);
                            $pastry->Compareat = floatval($_REQUEST['compare']);
                            $pastry->Pos = Convert::ToBool($_REQUEST['pos']);
                            $pastry->Barcode = $_REQUEST['barcode'];
                            $pastry->Costprice = $_REQUEST['cost'];
                            $pastry->Images = array();

                            $images = explode(",", $_REQUEST['images']);
                            for($i = 0; $i < count($images); $i++)
                            {
                                if($images[$i] != "")
                                {
                                    array_push($pastry->Images, $images[$i]);
                                }
                            }

                            $pastry->Description = $_REQUEST['description'];
                            $pastry->Promotext = $_REQUEST['promotext'];

                            //Inventory components
                            $item = null;
                            $openingActivity = null;

                            //Check if product has been added before
                            if((Convert::ToBool($_REQUEST['inventory'])) && ($pastry->Id == ""))
                            {
                                $item = new Pastryitem($GLOBALS['subscriber']);
                                $openingActivity = new Pastryinventoryactivity($GLOBALS['subscriber']);
                            }
                            $pastry->Save();

                            if($item != null)
                            {
                                $item->Image = count($pastry->Images) > 0 ? $pastry->Images[0] : "";
                                $item->Name = $pastry->Name;
                                $item->Unit = $_REQUEST['unit'];
                                $item->Pluralunit = $_REQUEST['pluralunit'];
                                $item->Sku = $pastry->Barcode;
                                $item->Productid = $pastry->Id;
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
                            $ret->message = "pastry saved successfully";
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