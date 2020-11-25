<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $ret->data = null;

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Bar->WriteAccess)
                            {
                                $ar = explode(",", $_REQUEST['data']);

                                if($_REQUEST['activity'] == "usage")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Baritem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Baritem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Barinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Usage;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Baritem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Baritem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Baritem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "damage")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Baritem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Baritem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Barinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Damage;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Baritem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Baritem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Baritem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "surplus")
                                {
                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Baritem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Barinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock + floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Newstock - $activity->Initialstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Surplus;
                                            $activity->Increment = true;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock += floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            $context = Context::Create($user, Event::ItemIsAdded, $item);
                                            $event = new Event($GLOBALS['subscriber'], Event::ItemIsAdded, $context);
                                            Event::Fire($event);
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Baritem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Baritem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Baritem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "return")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Baritem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Baritem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Barinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Returned;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Baritem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Baritem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Baritem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
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
                            if($GLOBALS['user']->Role->Kitchen->WriteAccess)
                            {
                                $ar = explode(",", $_REQUEST['data']);

                                if($_REQUEST['activity'] == "usage")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Kitchenitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Kitchenitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Kitcheninventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Usage;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Kitchenitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Kitchenitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Kitchenitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "damage")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Kitchenitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Kitchenitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Kitcheninventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Damage;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Kitchenitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Kitchenitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Kitchenitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "surplus")
                                {
                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Kitchenitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Kitcheninventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock + floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Newstock - $activity->Initialstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Surplus;
                                            $activity->Increment = true;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock += floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            $context = Context::Create($user, Event::ItemIsAdded, $item);
                                            $event = new Event($GLOBALS['subscriber'], Event::ItemIsAdded, $context);
                                            Event::Fire($event);
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Kitchenitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Kitchenitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Kitchenitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "return")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Kitchenitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Kitchenitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Kitcheninventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Returned;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Kitchenitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Kitchenitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Kitchenitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
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
                            if($GLOBALS['user']->Role->Laundry->WriteAccess)
                            {
                                $ar = explode(",", $_REQUEST['data']);

                                if($_REQUEST['activity'] == "usage")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Laundryitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Laundryitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Laundryinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Usage;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Laundryitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Laundryitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Laundryitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "damage")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Laundryitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Laundryitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Laundryinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Damage;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Laundryitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Laundryitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Laundryitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "surplus")
                                {
                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Laundryitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Laundryinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock + floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Newstock - $activity->Initialstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Surplus;
                                            $activity->Increment = true;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock += floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            $context = Context::Create($user, Event::ItemIsAdded, $item);
                                            $event = new Event($GLOBALS['subscriber'], Event::ItemIsAdded, $context);
                                            Event::Fire($event);
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Laundryitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Laundryitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Laundryitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "return")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Laundryitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Laundryitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Laundryinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Returned;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Laundryitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Laundryitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Laundryitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
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
                            if($GLOBALS['user']->Role->Bakery->WriteAccess)
                            {
                                $ar = explode(",", $_REQUEST['data']);

                                if($_REQUEST['activity'] == "usage")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Pastryitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Pastryitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Pastryinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Usage;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Pastryitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Pastryitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Pastryitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "damage")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Pastryitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Pastryitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Pastryinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Damage;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Pastryitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Pastryitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Pastryitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "surplus")
                                {
                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Pastryitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Pastryinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock + floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Newstock - $activity->Initialstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Surplus;
                                            $activity->Increment = true;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock += floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            $context = Context::Create($user, Event::ItemIsAdded, $item);
                                            $event = new Event($GLOBALS['subscriber'], Event::ItemIsAdded, $context);
                                            Event::Fire($event);
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Pastryitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Pastryitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Pastryitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "return")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Pastryitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Pastryitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Pastryinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Returned;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Pastryitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Pastryitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Pastryitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
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
                            if($GLOBALS['user']->Role->Pool->WriteAccess)
                            {
                                $ar = explode(",", $_REQUEST['data']);

                                if($_REQUEST['activity'] == "usage")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Poolitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Poolitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Poolinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Usage;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Poolitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Poolitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Poolitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "damage")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Poolitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Poolitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Poolinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Damage;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Poolitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Poolitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Poolitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "surplus")
                                {
                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Poolitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Poolinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock + floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Newstock - $activity->Initialstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Surplus;
                                            $activity->Increment = true;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock += floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            $context = Context::Create($user, Event::ItemIsAdded, $item);
                                            $event = new Event($GLOBALS['subscriber'], Event::ItemIsAdded, $context);
                                            Event::Fire($event);
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Poolitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Poolitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Poolitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "return")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Poolitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Poolitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Poolinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Returned;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Poolitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Poolitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Poolitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                            }
                            else
                            {
                                $ret->status = "access denied";
                                $ret->message = "You do not have the required privilege to complete the operation";
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "room_item")
                        {
                            if($GLOBALS['user']->Role->Rooms->WriteAccess)
                            {
                                $ar = explode(",", $_REQUEST['data']);

                                if($_REQUEST['activity'] == "usage")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Roomitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Roomitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Roominventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Usage;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Roomitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Roomitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Roomitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "damage")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Roomitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Roomitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Roominventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Damage;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Roomitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Roomitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Roomitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "surplus")
                                {
                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Roomitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Roominventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock + floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Newstock - $activity->Initialstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Surplus;
                                            $activity->Increment = true;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock += floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            $context = Context::Create($user, Event::ItemIsAdded, $item);
                                            $event = new Event($GLOBALS['subscriber'], Event::ItemIsAdded, $context);
                                            Event::Fire($event);
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Roomitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Roomitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Roomitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "return")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Roomitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Roomitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Roominventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Returned;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Roomitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Roomitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Roomitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                            }
                            else
                            {
                                $ret->status = "access denied";
                                $ret->message = "You do not have the required privilege to complete the operation";
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "store_item")
                        {
                            if($GLOBALS['user']->Role->Store->ReadAccess)
                            {
                                $ar = explode(",", $_REQUEST['data']);

                                if($_REQUEST['activity'] == "usage")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Storeitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Storeitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Storeinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Usage;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Storeitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Storeitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Storeitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "damage")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Storeitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Storeitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Storeinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Damage;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Storeitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Storeitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Storeitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "surplus")
                                {
                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Storeitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Storeinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock + floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Newstock - $activity->Initialstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Surplus;
                                            $activity->Increment = true;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock += floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            $context = Context::Create($user, Event::ItemIsAdded, $item);
                                            $event = new Event($GLOBALS['subscriber'], Event::ItemIsAdded, $context);
                                            Event::Fire($event);
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Storeitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Storeitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Storeitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
                                }
                                if($_REQUEST['activity'] == "return")
                                {
                                    //Run check make sure all requested products are available
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if(count($prdnum) == 2)
                                        {
                                            $item = new Storeitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            if($item->Stock < floatval($prdnum[1]))
                                            {
                                                $ret->status = "failed";

                                                if($item->Stock == 0)
                                                {
                                                    $ret->message = $item->Name." is out of stock";
                                                }
                                                $ret->message = $item->Name." has only <b>".$item->Stock." ".
                                                    ($item->Stock != 1 ? $item->Pluralunit : $item->Unit)."</b> in stock";
                                                goto end;
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->data = [];
                                    for ($i = 0; $i < count($ar); $i++)
                                    {
                                        $prdnum = explode(":", $ar[$i]);

                                        if (count($prdnum) == 2)
                                        {
                                            $item = new Storeitem($GLOBALS['subscriber']);
                                            $item->Initialize($prdnum[0]);

                                            $activity = new Storeinventoryactivity($GLOBALS['subscriber']);
                                            $activity->Item = $item;
                                            $activity->Initialstock = $item->Stock;
                                            $activity->Newstock = $item->Stock - floatval($prdnum[1]);
                                            $activity->Difference = ($activity->Initialstock - $activity->Newstock);
                                            $activity->Order = null;
                                            $activity->Type = Inventoryactivity::Returned;
                                            $activity->Increment = false;
                                            $activity->User = $_REQUEST['usersess'];
                                            $activity->Note = $_REQUEST['note'];
                                            $activity->Save();

                                            $item->Stock -= floatval($prdnum[1]);
                                            $item->Save();

                                            array_push($ret->data, $item);

                                            if($activity->Newstock == 0)
                                            {
                                                $context = Context::Create($user, Event::ItemIsOutOfStock, $item);
                                                $event = new Event($GLOBALS['subscriber'], Event::ItemIsOutOfStock, $context);
                                                Event::Fire($event);
                                            }
                                            else
                                            {
                                                if(($activity->Initialstock > $item->Lowstockpoint) && ($activity->Newstock <= $item->Lowstockpoint))
                                                {
                                                    $context = Context::Create($user, Event::ItemIsLowStock, $item);
                                                    $event = new Event($GLOBALS['subscriber'], Event::ItemIsLowStock, $context);
                                                    Event::Fire($event);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $ret->status = "failed";
                                            $ret->message = "Inaccurate data received";
                                            goto end;
                                        }
                                    }

                                    $ret->instockcount = Storeitem::InStockItemsCount($GLOBALS['subscriber']);
                                    $ret->lowstockcount = Storeitem::LowStockItemsCount($GLOBALS['subscriber']);
                                    $ret->outofstockcount = Storeitem::OutofStockItemsCount($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Record saved successfully";
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
                        $ret->status = "login";
                        $ret->data = "login & try again";
                    }


	echo json_encode($ret);