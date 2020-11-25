<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $quotation = null;
                        $item = null;

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Bar->WriteAccess)
                            {
                                $quotation = new Barquotation($GLOBALS['subscriber']);
                                //$quotation->Initialize($_REQUEST['prid']);

                                $item = new Baritem($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchen->WriteAccess)
                            {
                                $quotation = new Kitchenquotation($GLOBALS['subscriber']);
                                //$quotation->Initialize($_REQUEST['prid']);

                                $item = new Kitchenitem($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundry->WriteAccess)
                            {
                                $quotation = new Laundryquotation($GLOBALS['subscriber']);
                                //$quotation->Initialize($_REQUEST['prid']);

                                $item = new Laundryitem($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakery->WriteAccess)
                            {
                                $quotation = new Pastryquotation($GLOBALS['subscriber']);
                                //$quotation->Initialize($_REQUEST['prid']);

                                $item = new Pastryitem($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Pool->WriteAccess)
                            {
                                $quotation = new Poolquotation($GLOBALS['subscriber']);
                                //$quotation->Initialize($_REQUEST['prid']);

                                $item = new Poolitem($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "room_item")
                        {
                            if($GLOBALS['user']->Role->Rooms->WriteAccess)
                            {
                                $quotation = new Roomquotation($GLOBALS['subscriber']);
                                //$quotation->Initialize($_REQUEST['prid']);

                                $item = new Roomitem($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "store_item")
                        {
                            if($GLOBALS['user']->Role->Store->WriteAccess)
                            {
                                $quotation = new Storequotation($GLOBALS['subscriber']);
                                //$quotation->Initialize($_REQUEST['prid']);
                                
                                $item = new Storeitem($GLOBALS['subscriber']);
                            }
                        }


                        if($quotation !== null)
                        {
                            $ar = explode(",", $_REQUEST['data']);

                            $itemList = [];
                            for ($i = 0; $i < count($ar); $i++)
                            {
                                $prdnum = explode(":", $ar[$i]);

                                if (count($prdnum) == 2)
                                {
                                    $quotationitem = new Quotationitem($GLOBALS['subscriber']);
                                    //$quotationitem->TryRetrieve($purchaserequest->Id, $prdnum[0]);

                                    $quotationitem->Item = $prdnum[0];

                                    $quotationitem->Suppliers = [];
                                    $quotationitem->Pixel = [];

                                    if(!Convert::ToBool($_REQUEST['toassociatedSp']))
                                    {
                                        $sp = explode(",", $_REQUEST['suppliers']);
                                        for($j = 0; $j < count($sp); $j++)
                                        {
                                            if($sp[$j] != "")
                                            {
                                                $px = new QuotationPixel();
                                                $px->Supplier = $sp[$j];
                                                $px->Price = 0.0;
                                                array_push($quotationitem->Suppliers, $sp[$j]);
                                                array_push($quotationitem->Pixel, $px);
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $item->Initialize($prdnum[0]);
                                        for($j = 0; $j < count($item->Suppliers); $j++)
                                        {
                                            $px = new QuotationPixel();
                                            $px->Supplier = is_a($item->Suppliers[$j], "Supplier") ? $item->Suppliers[$j]->Id : $item->Suppliers[$j];
                                            $px->Price = 0.0;
                                            array_push($quotationitem->Suppliers, is_a($item->Suppliers[$j], "Supplier") ? $item->Suppliers[$j]->Id : $item->Suppliers[$j]);
                                            array_push($quotationitem->Pixel, $px);
                                        }
                                    }
                                    $quotationitem->Quantity = $prdnum[1];
                                    $quotationitem->Save();

                                    array_push($itemList, $quotationitem);
                                }
                                else
                                {
                                    $ret->status = "failed";
                                    $ret->message = "Inaccurate data received";
                                    goto end;
                                }
                            }

                            $quotation->Sms = Convert::ToBool($_REQUEST['sendsms']);
                            $quotation->Email = Convert::ToBool($_REQUEST['sendmail']);
                            $quotation->Associatedsuppliers = Convert::ToBool($_REQUEST['toassociatedSp']);
                            $quotation->Note = $_REQUEST['note'];
                            $quotation->GenerateReference();

                            if(!Convert::ToBool($_REQUEST['toassociatedSp']))
                            {
                                $sp = explode(",", $_REQUEST['suppliers']);
                                for($i = 0; $i < count($sp); $i++)
                                {
                                    if($sp[$i] != "")
                                    {
                                        array_push($quotation->Suppliers, $sp[$i]);
                                    }
                                }
                            }
                            else
                            {
                                for($u = 0; $u < count($itemList); $u++)
                                {
                                    for($k = 0; $k < count($itemList[$u]->Suppliers); $k++)
                                    {
                                        if(!in_array($itemList[$u]->Suppliers[$k], $quotation->Suppliers))
                                        {
                                            array_push($quotation->Suppliers, $itemList[$u]->Suppliers[$k]);
                                        }
                                    }
                                }
                            }
                            $quotation->Items = $itemList;
                            $quotation->Save();

                            for($i = 0; $i < count($itemList); $i++)
                            {
                                if($itemList[$i]->Quotation == "")
                                {
                                    $itemList[$i]->attachQuotation($quotation->Id);
                                }
                            }

                            $contactlist = new Contactcollection($GLOBALS['subscriber']);
                            $contactlist->Issystem = true;

                            for($i = 0; $i < count($quotation->Suppliers); $i++)
                            {
                                if($quotation->Suppliers[$i] != "")
                                {
                                    $sess = new Quotationsession($GLOBALS['subscriber']);
                                    $sess->Quotation = $quotation->Id;
                                    $sess->Supplier = $quotation->Suppliers[$i];
                                    $sess->Responded = false;
                                    $sess->Sms = $quotation->Sms;
                                    $sess->Email = $quotation->Email;
                                    $sess->Type = $_REQUEST['item_type'];
                                    $sess->Save();

                                    $contactlist->Additem($quotation->Suppliers[$i], "supplier");
                                }
                            }
                            $contactlist->Name = "_syscon_quote_req".Random::GenerateId(mt_rand(8, 16));
                            $contactlist->Save();

                            $message  = new Messagetemplate($GLOBALS['subscriber']);
                            $message->From = "robot@".$GLOBALS['subscriber']->Domain;
                            $message->Type = "email";
                            $message->Replyto = $GLOBALS['subscriber']->Email1;
                            $message->Fromname = $GLOBALS['subscriber']->BusinessName;
                            $message->Issystem = true;
                            $message->Subject = "Quotation request";
                            $message->Title = "_sys_msg_".Random::GenerateId(mt_rand(10, 16));
                            $message->Body = trim($quotation->Note) != "" ? $quotation->Note :
                                "Hello [{company}{contactperson}], we would love to get the prices of some items from you. Please
                                click on the link below and fill in the prices. we would love to hear from you. <br/><br/>
                                {domain}/{quotatation}";
                            $message->Save();

                            $msgschedule = new Messageschedule($GLOBALS['subscriber']);
                            $msgschedule->Autodelete = true;
                            $msgschedule->Contactlist = [];
                            array_push($msgschedule->Contactlist, $contactlist->Id);
                            $msgschedule->Message = $message->Id;
                            $msgschedule->Title = $message->Title;
                            $msgschedule->Year = date("Y");
                            $msgschedule->Month = date("m");
                            $msgschedule->Day = date("d");
                            $msgschedule->Execcount = 1;
                            $msgschedule->Issystem = true;
                            $msgschedule->Hour = date("H");
                            $msgschedule->Minuet = Convert::ToInt(date("i")) + 3;
                            $msgschedule->Save();

                            $msgtask = new Sendmessage_task($GLOBALS['subscriber']);
                            $msgtask->Addmessageschedule($msgschedule);
                            $msgtask->Que();

                            $schedule = new Schedule($GLOBALS['subscriber']);
                            $schedule->Autodelete = true;
                            $schedule->Taskclass = "Sendmessage_task";
                            $schedule->Task = $msgtask->GetId();
                            $schedule->Save();



                            $ret->status = "success";
                            $ret->message = "Quotation request sent successfully";
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