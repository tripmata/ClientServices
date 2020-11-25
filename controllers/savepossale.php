<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Id != "")
                        {
                            $GLOBALS['user']->UpdateSeenTime();
                        }

                        $orders = null;
                        $sale = null;
                        $transaction = null;

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Barpos->ReadAccess)
                            {
                                $orders = Barorder::Filter($GLOBALS['subscriber'], 0, 'fullfilled');
                                $sale = new Barsale($GLOBALS['subscriber']);
                                $transaction = new Bartransaction($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchenpos->ReadAccess)
                            {
                                $orders = Kitchenorder::Filter($GLOBALS['subscriber'], 0, 'fullfilled');
                                $sale = new Kitchensale($GLOBALS['subscriber']);
                                $transaction = new Kitchentransaction($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundrypos->ReadAccess)
                            {
                                $orders = [];
                                $sale = new Laundrysale($GLOBALS['subscriber']);
                                $transaction = new Laundrytransaction($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakerypos->ReadAccess)
                            {
                                $orders = Bakeryorder::Filter($GLOBALS['subscriber'], 0, 'fullfilled');
                                $sale = new Bakerysale($GLOBALS['subscriber']);
                                $transaction = new Bakerytransaction($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Poolpos->ReadAccess)
                            {
                                $orders = [];
                                $sale = new Poolsale($GLOBALS['subscriber']);
                                $transaction = new Pooltransaction($GLOBALS['subscriber']);
                            }
                        }


                        if($orders !== null)
                        {
                            $ret->data = $orders;

                            $transaction->Sale = "";
                            $transaction->Type = "credit";
                            $transaction->Amount = doubleval($_REQUEST['paidAmount']);
                            $transaction->User = $_REQUEST['posuser'];
                            $transaction->Text = "";
                            $transaction->Paytime = doubleval($_REQUEST['time']);
                            $transaction->Method = $_REQUEST['method'];

                            $sale->Total = doubleval($_REQUEST['total']);
                            $sale->Discount = doubleval($_REQUEST['discount']);
                            $sale->Taxes = doubleval($_REQUEST['taxes']);
                            $sale->Paidamount = doubleval($_REQUEST['paidAmount']);
                            $sale->Paid = ($sale->Paidamount >= (($sale->Total + $sale->Taxes) - $sale->Discount)) ? true : false;
                            $sale->Hasstaff = (explode(":", $_REQUEST['entity'])[1] == "staff") ? true : false;
                            $sale->Hasguest = (explode(":", $_REQUEST['entity'])[1] == "customer") ? true : false;
                            $sale->Staff = $sale->Hasstaff ? explode(":", $_REQUEST['entity'])[0] : "";
                            $sale->Guest = $sale->Hasguest ? explode(":", $_REQUEST['entity'])[0] : "";
                            $sale->Channel = Convert::ToBool($_REQUEST['isWeborder']) ? "web" : "pos";
                            $sale->Items = [];
                            $sale->Coupons = [];
                            $sale->Discounts = [];
                            $sale->Itemcount = 0;
                            $sale->User = $_REQUEST['posuser'];

                            $sale->Transactionid = $_REQUEST['transId'];
                            $sale->Saletime = doubleval($_REQUEST['time']);

                            $coupons = explode(",", $_REQUEST['coupons']);
                            for($i = 0; $i < count($coupons); $i++)
                            {
                                if($coupons[$i] != "")
                                {
                                    $c = new Coupon($GLOBALS['subscriber']);
                                    $c->Initialize($coupons[$i]);
                                    array_push($sale->Coupons, $c);
                                }
                            }

                            $discounts = explode(",", $_REQUEST['discounts']);
                            for($i = 0; $i < count($discounts); $i++)
                            {
                                if($discounts[$i] != "")
                                {
                                    $d = new Discount($GLOBALS['subscriber']);
                                    $d->Initialize($discounts[$i]);
                                    array_push($sale->Discounts, $d);
                                }
                            }


                            $items = explode(",", $_REQUEST['items']);
                            for($i = 0; $i < count($items); $i++)
                            {
                                if($items[$i] != "")
                                {
                                    $iq = explode(":", $items[$i]);

                                    if(count($iq) === 4)
                                    {
                                        $it = null;
                                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                                        {
                                            $it = new Kitchensaleitem($GLOBALS['subscriber']);
                                            $it->Item = $iq[0];
                                            $it->Quantity = Convert::ToInt($iq[1]);
                                            $it->Save();

                                            //working inventory for item
                                            $food = new Food($GLOBALS['subscriber']);
                                            $food->Initialize($iq[0]);

                                            Kitchensale::ProcessInventory($GLOBALS['subscriber'], $food, $user, $it->Quantity);
                                        }
                                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                                        {
                                            $it = new Barsaleitem($GLOBALS['subscriber']);
                                            $it->Item = $iq[0];
                                            $it->Quantity = Convert::ToInt($iq[1]);
                                            $it->Save();

                                            //working inventory for item
                                            $drink = new Drink($GLOBALS['subscriber']);
                                            $drink->Initialize($iq[0]);

                                            Barsale::ProcessInventory($GLOBALS['subscriber'], $drink, $user, $it->Quantity);
                                        }
                                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                                        {
                                            $it = new Bakerysaleitem($GLOBALS['subscriber']);
                                            $it->Item = $iq[0];
                                            $it->Quantity = Convert::ToInt($iq[1]);
                                            $it->Save();

                                            //working inventory for item
                                            $pastry = new Pastry($GLOBALS['subscriber']);
                                            $pastry->Initialize($iq[0]);

                                            Bakerysale::ProcessInventory($GLOBALS['subscriber'], $pastry, $user, $it->Quantity);
                                        }
                                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                                        {
                                            $it = new Laundrysaleitem($GLOBALS['subscriber']);
                                            $it->Item = $iq[0];
                                            $it->Quantity = Convert::ToInt($iq[1]);
                                            $it->Save();
                                        }
                                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                                        {
                                            $it = new Poolsaleitem($GLOBALS['subscriber']);
                                            $it->Item = $iq[0];
                                            $it->Quantity = Convert::ToInt($iq[1]);
                                            $it->Save();
                                        }
                                    }
                                    $sale->Itemcount += $it->Quantity;
                                    array_push($sale->Items, $it);
                                }
                            }
                            $sale->Save();

                            $transaction->Sale = $sale->Id;
                            $transaction->Save();


                            if(Convert::ToBool($_REQUEST['isWeborder']))
                            {
                                $order = null;
                                if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                                {
                                    $order = new Kitchenorder($GLOBALS['subscriber']);
                                }
                                if(strtolower($_REQUEST['item_type']) == "bar_item")
                                {
                                    $order = new Barorder($GLOBALS['subscriber']);
                                }
                                if(strtolower($_REQUEST['item_type']) == "pastry_item")
                                {
                                    $order = new Bakeryorder($GLOBALS['subscriber']);
                                }

                                /* Laundry and pool cannot have web orders. They can only be ordered in the hotel

                                if(strtolower($_REQUEST['item_type']) == "laundry_item")
                                {
                                    $order = new Laundryorder($GLOBALS['subscriber']);
                                }
                                if(strtolower($_REQUEST['item_type']) == "pool_item")
                                {
                                    $order = new Poolorder($GLOBALS['subscriber']);
                                }
                                */

                                if($order != null)
                                {
                                    $order->Initialize($_REQUEST['weborder']);
                                    $order->Delete();
                                }
                            }
                            else
                            {
                                $couponpixels = explode(",", $_REQUEST['couponPixels']);

                                for($i = 0; $i < count($couponpixels); $i++)
                                {
                                    if($couponpixels[$i] != "")
                                    {
                                        $pixels = explode(":", $couponpixels[$i]);

                                        if(count($pixels) === 4)
                                        {
                                            $history = new Couponhistory($GLOBALS['subscriber']);
                                            $history->Coupon = $pixels[0];
                                            $history->User = explode(":", $_REQUEST['entity'])[0];
                                            $history->Value = $pixels[2];
                                            $history->Amount = $pixels[1];
                                            $history->Bypercentage = Convert::ToBool($pixels[3]);

                                            if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                                            {
                                                $history->Onfood = $pixels[1];
                                            }
                                            if(strtolower($_REQUEST['item_type']) == "bar_item")
                                            {
                                                $history->Ondrinks = $pixels[1];
                                            }
                                            if(strtolower($_REQUEST['item_type']) == "pastry_item")
                                            {
                                                $history->Onpastry = $pixels[1];
                                            }
                                            if(strtolower($_REQUEST['item_type']) == "laundry_item")
                                            {
                                                $history->Onlaundry = $pixels[1];
                                            }
                                            if(strtolower($_REQUEST['item_type']) == "pool_item")
                                            {
                                                $history->Onpool = $pixels[1];
                                            }
                                            $history->Save();

                                            $coupon = new Coupon($GLOBALS['subscriber']);
                                            $coupon->Initialize($pixels[0]);

                                            $coupon->Usecount --;
                                            if($coupon->Usecount <= 0)
                                            {
                                                $coupon->Used = true;
                                            }
                                            $coupon->Save();
                                        }
                                    }
                                }


                                $discountpixels = explode(",", $_REQUEST['discountPixels']);

                                for($i = 0; $i < count($discountpixels); $i++)
                                {
                                    if($discountpixels[$i] != "")
                                    {
                                        $pixels = explode(":", $discountpixels[$i]);

                                        if(count($pixels) === 4)
                                        {
                                            $history = new Discounthistory($GLOBALS['subscriber']);
                                            $history->Discount = $pixels[0];
                                            $history->User = explode(":", $_REQUEST['entity'])[0];
                                            $history->Value = $pixels[2];
                                            $history->Amount = $pixels[1];
                                            $history->Bypercentage = Convert::ToBool($pixels[3]);

                                            if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                                            {
                                                $history->Onfood = $pixels[1];
                                            }
                                            if(strtolower($_REQUEST['item_type']) == "bar_item")
                                            {
                                                $history->Ondrinks = $pixels[1];
                                            }
                                            if(strtolower($_REQUEST['item_type']) == "pastry_item")
                                            {
                                                $history->Onpastry = $pixels[1];
                                            }
                                            if(strtolower($_REQUEST['item_type']) == "laundry_item")
                                            {
                                                $history->Onlaundry = $pixels[1];
                                            }
                                            if(strtolower($_REQUEST['item_type']) == "pool_item")
                                            {
                                                $history->Onpool = $pixels[1];
                                            }
                                            $history->Save();
                                        }
                                    }
                                }
                            }


                            if(count($orders) == 0)
                            {
                                $ret->status = "success";
                            }
                            else
                            {
                                $ret->status = "order";
                            }
                            $ret->message = "online orders retrieved successfully";
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