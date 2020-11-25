<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Bar->WriteAccess)
                        {
                            $drink = new Drink($GLOBALS['subscriber']);
                            $drink->Initialize($_REQUEST['Drinkid']);
                            $drink->Onsite = Convert::ToBool($_REQUEST['Onsite']);
                            $drink->Save();

                            $ret->status = "success";
                            $ret->message = "drink visibility has been changed";
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