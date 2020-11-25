<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        $report = null;

                        if(strtolower($_REQUEST['item_type']) == "bar_item")
                        {
                            if($GLOBALS['user']->Role->Bar->ReadAccess)
                            {
                                $report = new stdClass();
                                $report->Item = new Drink($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "kitchen_item")
                        {
                            if($GLOBALS['user']->Role->Kitchen->ReadAccess)
                            {
                                $report = new stdClass();
                                $report->Item = new Food($GLOBALS['subscriber']);
                            }
                        }
                        if(strtolower($_REQUEST['item_type']) == "pastry_item")
                        {
                            if($GLOBALS['user']->Role->Bakery->ReadAccess)
                            {
                                $report = new stdClass();
                                $report->Item = new Pastry($GLOBALS['subscriber']);
                            }
                        }

                        if($report !== null)
                        {
                            $report->Item->Initialize($_REQUEST['item']);
                            $ret->data = $report;

                            $ret->status = "success";
                            $ret->message = "Purchase request retrieved successfully";
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