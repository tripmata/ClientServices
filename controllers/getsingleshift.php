<?php

	$ret = new stdClass();


                    $ret->data = array();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Staff->ReadAccess)
                        {
                            $shift = new Shift($GLOBALS['subscriber']);
                            $shift->Initialize($_REQUEST['Shiftid']);
                            $ret->data = $shift;
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