<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Kitchen->WriteAccess)
                        {
                            $food = new Food($GLOBALS['subscriber']);
                            $food->Initialize($_REQUEST['Foodid']);
                            $food->Status = Convert::ToBool($_REQUEST['Status']);
                            $food->Save();

                            $ret->status = "success";
                            $ret->message = "Food status saved successfully";
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