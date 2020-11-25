<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Laundry->ReadAccess)
                        {
                            $ret->data = array();

                            $page = $_REQUEST['Page'];
                            $perpage = $_REQUEST['Perpage'];

                            $store = array();

                            $ret->Page = $page;
                            $ret->Perpage = $perpage;

                            $store = Laundry::All($GLOBALS['subscriber']);

                            $ret->Total = count($store);

                            $start = (($ret->Page - 1) * $ret->Perpage);
                            $stop = (($start + $ret->Perpage) - 1);

                            $x = 0;
                            for($i = $start; $i < count($store); $i++)
                            {
                                $ret->data[$x] = $store[$i];
                                if($i == $stop){break;}
                                $x++;
                            }
                            $ret->status = "success";
                            $ret->message = "Pool session saved successfuly";
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