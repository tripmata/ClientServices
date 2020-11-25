<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Messaging->ReadAccess)
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


                            if($_REQUEST['tab'] == "all")
                            {
                                $store = Message::Search($GLOBALS['subscriber'], $filtervalue);
                            }
                            if($_REQUEST['tab'] == "unresolved")
                            {
                                $store = Message::Unresolved($GLOBALS['subscriber'], $filtervalue);
                            }
                            if($_REQUEST['tab'] == "resolved")
                            {
                                $store = Message::Resolved($GLOBALS['subscriber'], $filtervalue);
                            }
                            if($_REQUEST['tab'] == "stared")
                            {
                                $store = Message::Stared($GLOBALS['subscriber'], $filtervalue);
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

                            Message::markListSeen($GLOBALS['subscriber'], $ret->data);

                            $ret->Totalcount = Message::Totalcount($GLOBALS['subscriber']);
                            $ret->Staredcount = Message::Staredcount($GLOBALS['subscriber']);
                            $ret->Resolvedcount = Message::Resolvedcount($GLOBALS['subscriber']);
                            $ret->Unresolvedcount = Message::Unresolvedcount($GLOBALS['subscriber']);

                            $ret->status = "success";
                            $ret->message = "Message retrieved successfully";
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