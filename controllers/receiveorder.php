<?php

	$ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        $po = null;
        $pr = null;

        $activity = null;

        if(strtolower($_REQUEST['item_type']) == "bar_item")
        {
            if($GLOBALS['user']->Role->Bar->WriteAccess)
            {
                $po = new Barpo($GLOBALS['subscriber']);
                $po->Initialize($_REQUEST['order']);

                $pr = Barpr::ByReference($GLOBALS['subscriber'], $po->Pr);
            }
        }
        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
        {
            if($GLOBALS['user']->Role->Kitchen->WriteAccess)
            {
                $po = new Kitchenpo($GLOBALS['subscriber']);
                $po->Initialize($_REQUEST['order']);

                $pr = Kitchenpr::ByReference($GLOBALS['subscriber'], $po->Pr);
            }
        }
        if(strtolower($_REQUEST['item_type']) == "laundry_item")
        {
            if($GLOBALS['user']->Role->Laundry->WriteAccess)
            {
                $po = new Laundrypo($GLOBALS['subscriber']);
                $po->Initialize($_REQUEST['order']);

                $pr = Laundrypr::ByReference($GLOBALS['subscriber'], $po->Pr);
            }
        }
        if(strtolower($_REQUEST['item_type']) == "pastry_item")
        {
            if($GLOBALS['user']->Role->Bakery->WriteAccess)
            {
                $po = new Pastrypo($GLOBALS['subscriber']);
                $po->Initialize($_REQUEST['order']);

                $pr = Pastrypr::ByReference($GLOBALS['subscriber'], $po->Pr);
            }
        }
        if(strtolower($_REQUEST['item_type']) == "pool_item")
        {
            if($GLOBALS['user']->Role->Pool->WriteAccess)
            {
                $po = new Poolpo($GLOBALS['subscriber']);
                $po->Initialize($_REQUEST['order']);

                $pr = Poolpr::ByReference($GLOBALS['subscriber'], $po->Pr);
            }
        }
        if(strtolower($_REQUEST['item_type']) == "room_item")
        {
            if($GLOBALS['user']->Role->Rooms->WriteAccess)
            {
                $po = new Roompo($GLOBALS['subscriber']);
                $po->Initialize($_REQUEST['order']);

                $pr = Roompr::ByReference($GLOBALS['subscriber'], $po->Pr);
            }
        }
        if(strtolower($_REQUEST['item_type']) == "store_item")
        {
            if($GLOBALS['user']->Role->Store->WriteAccess)
            {
                $po = new Storepo($GLOBALS['subscriber']);
                $po->Initialize($_REQUEST['order']);

                $pr = Storepr::ByReference($GLOBALS['subscriber'], $po->Pr);
            }
        }


        if($po !== null)
        {
            $items = explode(",", $_REQUEST['items']);

            $over = "";
            for($i = 0; $i < count($items); $i++)
            {
                $it = explode(":", $items[$i]);

                if(count($it) === 2)
                {
                    for($j = 0; $j < count($po->Items); $j++)
                    {
                        if($po->Items[$j]->Id == $it[0])
                        {
                            if(intval($po->Items[$j]->Quantity) < intval($it[1]))
                            {
                                $over =  $po->Items[$j]->Item->Name;
                            }
                        }
                    }
                }
            }


            if($over == "")
            {
                if(!$po->Received)
                {
                    for($i = 0; $i < count($items); $i++)
                    {
                        if($items[$i] != "")
                        {
                            $it = explode(":", $items[$i]);

                            if(count($it) === 2)
                            {
                                for($j = 0; $j < count($po->Items); $j++)
                                {
                                    if($po->Items[$j]->Id == $it[0])
                                    {
                                        $po->Items[$j]->Supplied = Convert::ToInt($it[1]);
                                        $po->Items[$j]->Save();

                                        //Do inventory item activity
                                        $activity = null;
                                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                                        {
                                            $activity = new Kitcheninventoryactivity($GLOBALS['subscriber']);
                                        }
                                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                                        {
                                            $activity = new Laundryinventoryactivity($GLOBALS['subscriber']);
                                        }
                                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                                        {
                                            $activity = new Barinventoryactivity($GLOBALS['subscriber']);
                                        }
                                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                                        {
                                            $activity = new Pastryinventoryactivity($GLOBALS['subscriber']);
                                        }
                                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                                        {
                                            $activity = new Poolinventoryactivity($GLOBALS['subscriber']);
                                        }
                                        if(strtolower($_REQUEST['item_type']) == "room_item")
                                        {
                                            $activity = new Roominventoryactivity($GLOBALS['subscriber']);
                                        }
                                        if(strtolower($_REQUEST['item_type']) == "store_item")
                                        {
                                            $activity = new Storeinventoryactivity($GLOBALS['subscriber']);
                                        }
                                        $activity->Item = $po->Items[$j]->Item;
                                        $activity->Initialstock = $po->Items[$j]->Item->Stock;
                                        $activity->Newstock = doubleval($po->Items[$j]->Item->Stock) + doubleval($po->Items[$j]->Supplied);
                                        $activity->Difference = ($activity->Newstock - $activity->Initialstock);
                                        $activity->Order = $po->Id;
                                        $activity->Type = Inventoryactivity::Restocking;
                                        $activity->Increment = true;
                                        $activity->User = $_REQUEST['usersess'];
                                        $activity->Note = "";
                                        $activity->Save();

                                        $po->Items[$j]->Item->Stock += floatval($po->Items[$j]->Supplied);
                                        $po->Items[$j]->Item->Save();
                                    }
                                }
                            }
                        }
                    }
                    $po->Received = true;
                    $po->Receiver = $_REQUEST['usersess'];
                    $po->Receivedate = time();
                    $po->GenerateCreditNote($_REQUEST['usersess']);
                    $po->Save();

                    $pr->Fulfilled = true;
                    $pr->Save();

                    $ret->data = null;

                    $ret->status = "success";
                    $ret->message = "Purchase request retrieved successfully";
                }
                else
                {
                    $ret->status = "failed";
                    $ret->message = "This order have been processed";
                }
            }
            else
            {
                $ret->status = "failed";
                $ret->message = "the supplied quantity for <b>".$over."</b> is greated than the demanded quantity";
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