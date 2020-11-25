<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $quotation = null;

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Bar->ReadAccess)
                            {
                                $quotation = Barquotation::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchen->ReadAccess)
                            {
                                $quotation = Kitchenquotation::Search($GLOBALS['subscriber'],  $_REQUEST['searchterm']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "laundry_item")
                        {
                            if($GLOBALS['user']->Role->Laundry->ReadAccess)
                            {
                                $quotation = Laundryquotation::Search($GLOBALS['subscriber'],  $_REQUEST['searchterm']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakery->ReadAccess)
                            {
                                $quotation = Pastryquotation::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pool_item")
                        {
                            if($GLOBALS['user']->Role->Pool->ReadAccess)
                            {
                                $quotation = Poolquotation::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "room_item")
                        {
                            if($GLOBALS['user']->Role->Rooms->ReadAccess)
                            {
                                $quotation = Roomquotation::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "store_item")
                        {
                            if($GLOBALS['user']->Role->Store->ReadAccess)
                            {
                                $quotation = Storequotation::Search($GLOBALS['subscriber'], $_REQUEST['searchterm']);
                            }
                        }


                        if($quotation !== null)
                        {
                            $ret->data = array();

                            $page = $_REQUEST['Page'];
                            $perpage = $_REQUEST['Perpage'];

                            $ret->Page = $page;
                            $ret->Perpage = $perpage;

                            $ret->Total = count($quotation);

                            //For listing all
                            if(Convert::ToInt($page) == 0)
                            {
                                $ret->data = $quotation;
                            }
                            else
                            {
                                $start = (($ret->Page - 1) * $ret->Perpage);
                                $stop = (($start + $ret->Perpage) - 1);

                                $x = 0;
                                for($i = $start; $i < count($quotation); $i++)
                                {
                                    $ret->data[$x] = $quotation[$i];
                                    if($i == $stop){break;}
                                    $x++;
                                }
                            }

                            $ret->status = "success";
                            $ret->message = "Inventory items retrieved successfully";
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