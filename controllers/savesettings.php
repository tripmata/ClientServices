<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $settings = null;

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Bar->ReadAccess)
                            {
                                $settings = new Barsettings($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchen->ReadAccess)
                            {
                                $settings = new Kitchensettings($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundry->ReadAccess)
                            {
                                $settings = new Laundrysettings($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakery->ReadAccess)
                            {
                                $settings = new Pastrysettings($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Pool->ReadAccess)
                            {
                                $settings = new Poolsettings($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "room_item")
                        {
                            if($GLOBALS['user']->Role->Rooms->ReadAccess)
                            {
                                $settings = new Roomsettings($GLOBALS['subscriber']);
                            }
                        }


                        if($settings !== null)
                        {
                            $settings->Receipttemplate = $_REQUEST['receipttemplate'];
                            $settings->Papertype = $_REQUEST['papertype'];
                            $settings->Lowstockemail = $_REQUEST['lowstockemail'];
                            $settings->Lowstockphone = $_REQUEST['lowstockphone'];
                            $settings->Onlineorderphone = $_REQUEST['onlineorderphone'];
                            $settings->Receiptaddress = Convert::ToBool($_REQUEST['receiptaddess']);
                            $settings->Receiptemail = Convert::ToBool($_REQUEST['receiptemail']);
                            $settings->Receiptlogo = Convert::ToBool($_REQUEST['receiptlogo']);
                            $settings->Receiptsalutation = Convert::ToBool($_REQUEST['receiptsalutation']);
                            $settings->Cash = Convert::ToBool($_REQUEST['cash_pay']);
                            $settings->Pos = Convert::ToBool($_REQUEST['pos_pay']);
                            $settings->Online = Convert::ToBool($_REQUEST['online_pay']);
                            $settings->Others = Convert::ToBool($_REQUEST['other_pay']);
                            $settings->Refund = Convert::ToBool($_REQUEST['refund']);
                            $settings->Compundtax = Convert::ToBool($_REQUEST['compound_tax']);
                            $settings->Salutation = $_REQUEST['salutation'];

                            $settings->Save();

                            $ret->status = "success";
                            $ret->message = "settings have been saved successfully successfully";
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