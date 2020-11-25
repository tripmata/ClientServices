<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $transactions = null;

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Barpos->ReadAccess)
                            {
                                $transactions = Barsale::SearchByUser($GLOBALS['subscriber'], $user, $_REQUEST['Filtervalue']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchenpos->ReadAccess)
                            {
                                $transactions = Kitchensale::SearchByUser($GLOBALS['subscriber'], $user, $_REQUEST['Filtervalue']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundrypos->ReadAccess)
                            {
                                $transactions = Laundrysale::SearchByUser($GLOBALS['subscriber'], $user, $_REQUEST['Filtervalue']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakerypos->ReadAccess)
                            {
                                $transactions = Bakerysale::SearchByUser($GLOBALS['subscriber'], $user, $_REQUEST['Filtervalue']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Poolpos->ReadAccess)
                            {
                                $transactions = Poolsale::SearchByUser($GLOBALS['subscriber'], $user, $_REQUEST['Filtervalue']);
                            }
                        }


                        if($transactions !== null)
                        {
                            $ret->data = [];

                            $page = $_REQUEST['Page'];
                            $perpage = $_REQUEST['Perpage'];

                            $ret->Page = $page;
                            $ret->Perpage = $perpage;


                            $ret->Total = count($transactions);

                            $start = (($ret->Page - 1) * $ret->Perpage);
                            $stop = (($start + $ret->Perpage) - 1);

                            $x = 0;
                            for($i = $start; $i < count($transactions); $i++)
                            {
                                $ret->data[$x] = $transactions[$i];
                                if($i == $stop){break;}
                                $x++;
                            }
                            $ret->status = "success";
                            $ret->message = "POS transactions retrieved successfully";
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