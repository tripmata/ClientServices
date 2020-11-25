<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Discount->ReadAccess)
                        {
                            $ret->status = "success";
                            $ret->data = array();

                            $page = $_REQUEST['Page'];
                            $perpage = $_REQUEST['Perpage'];
                            $filter = $_REQUEST['Filter'];
                            $filtervalue = $_REQUEST['Filtervalue'];

                            $store = array();

                            $ret->Page = $page;
                            $ret->Perpage = $perpage;


                            $store = Discount::Search($GLOBALS['subscriber'], $filtervalue);


                            $ret->Total = count($store);

                            $ret->Usedcount = Coupon::Usedcount($GLOBALS['subscriber']);
                            $ret->Expiredcount = Coupon::Expiredcount($GLOBALS['subscriber']);
                            $ret->Unusedcount = Coupon::Unusedcount($GLOBALS['subscriber']);
                            $ret->Allcount = Coupon::Countall($GLOBALS['subscriber']);

                            $start = (($ret->Page - 1) * $ret->Perpage);
                            $stop = (($start + $ret->Perpage) - 1);

                            $x = 0;
                            for($i = $start; $i < count($store); $i++)
                            {
                                $ret->data[$x] = $store[$i];
                                if($i == $stop){break;}
                                $x++;
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