<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Bar->WriteAccess)
                        {
                            $drink = new Drink($GLOBALS['subscriber']);
                            $drink->Initialize($_REQUEST['Drinkid']);
                            $drink->Status = Convert::ToBool($_REQUEST['Status']);
                            $drink->Save();

                            $ret->status = "success";
                            $ret->message = "Drink status saved successfully";
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