<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Staff->WriteAccess)
                        {
                            $shift = new Shift($GLOBALS['subscriber']);
                            $shift->Initialize($_REQUEST['shiftid']);
                            $shift->Name = ucwords(strtolower($_REQUEST['name']));
                            $shift->Monday = Convert::ToBool($_REQUEST['monday']);
                            $shift->Tuesday = Convert::ToBool($_REQUEST['tueday']);
                            $shift->Wednesday = Convert::ToBool($_REQUEST['wedday']);
                            $shift->Thursday = Convert::ToBool($_REQUEST['thuday']);
                            $shift->Friday = Convert::ToBool($_REQUEST['friday']);
                            $shift->Saturday = Convert::ToBool($_REQUEST['satday']);
                            $shift->Sunday = Convert::ToBool($_REQUEST['sunday']);
                            $shift->Starthour = $_REQUEST['starthour'];
                            $shift->Stophour = $_REQUEST['stophour'];
                            $shift->Startminuite = $_REQUEST['startmin'];
                            $shift->Stopminuite = $_REQUEST['stopmin'];
                            $shift->Startgmt = $_REQUEST['startgmt'];
                            $shift->Stopgmt = $_REQUEST['stopgmt'];

                            $shift->Save();

                            $ret->data = "success";
                            $ret->status = "success";
                        }
                        else
                        {
                            $ret->status = "access denied";
                            $ret->message = "You do not have the required privilage to complete the operation";
                        }
                    }
                    else
                    {
                        $ret->status = "login";
                        $ret->data = "login";
                    }

	echo json_encode($ret);