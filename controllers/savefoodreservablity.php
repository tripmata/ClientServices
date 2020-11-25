<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Kitchen->WriteAccess)
                        {
                            $food = new Food($GLOBALS['subscriber']);
                            $food->Initialize($_REQUEST['Foodid']);
                            $food->Reservable = Convert::ToBool($_REQUEST['Reservable']);
                            $food->Save();

                            $ret->status = "success";
                            $ret->message = "food reservability has been changed";
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