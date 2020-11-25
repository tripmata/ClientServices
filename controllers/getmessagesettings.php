<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Messaging->ReadAccess)
                        {
                            $ret->data = new Messagesettings($GLOBALS['subscriber']);
                            $ret->token = $GLOBALS['subscriber']->Key;

                            $ret->status = "success";
                            $ret->SMSUnits = $GLOBALS['subscriber']->Smsunit;
                            $ret->message = "settings have been retrieved successfully";
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