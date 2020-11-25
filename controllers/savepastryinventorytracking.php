<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Bakery->WriteAccess)
                        {
                            $pastry = new Pastry($GLOBALS['subscriber']);
                            $pastry->Initialize($_REQUEST['Pastryid']);
                            $pastry->Status = Convert::ToBool($_REQUEST['inventory']);
                            $pastry->Save();

                            $ret->status = "success";
                            $ret->message = "pastry inventory status has been changed";
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
                        $ret->data = "login";
                    }

	echo json_encode($ret);