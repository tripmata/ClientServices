<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Booking->ReadAccess)
                        {
                            $ret->status = "success";
                            $ret->data = array();

                            $page = $_REQUEST['Page'];
                            $perpage = $_REQUEST['Perpage'];

                            $store = array();

                            $ret->Page = $page;
                            $ret->Perpage = $perpage;

                            if($_REQUEST['list'] == "system")
                            {
                                $store = EventListener::SystemEvents($GLOBALS['subscriber']);
                            }
                            else
                            {
                                $store = EventListener::UserEvents($GLOBALS['subscriber']);
                            }
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

                            $ret->Totaleventcount = 0;
                            $ret->Totalschedulecount = 0;

                            $ret->status = "success";
                            $ret->message = "Event list retrieved successfully";
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