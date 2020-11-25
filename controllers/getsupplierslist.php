<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Kitchen->ReadAccess)
                            || ($GLOBALS['user']->Role->Bar->ReadAccess) || ($GLOBALS['user']->Role->Bakery->ReadAccess) || ($GLOBALS['user']->Role->Store->ReadAccess)
                            || ($GLOBALS['user']->Role->Laundry->ReadAccess) || ($GLOBALS['user']->Role->Pool->ReadAccess) || ($GLOBALS['user']->Role->Room->ReadAccess)
                        {
                            $ret->data = array();

                            $page = $_REQUEST['Page'];
                            $perpage = $_REQUEST['Perpage'];
                            $filter = $_REQUEST['Filter'];
                            $filtervalue = $_REQUEST['Filtervalue'];

                            $store = array();

                            $ret->Page = $page;
                            $ret->Perpage = $perpage;

                            $store = Supplier::Search($GLOBALS['subscriber'], $filtervalue);

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