<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Messaging->WriteAccess)
                        {
                            $msg = new Message($GLOBALS['subscriber']);
                            $msg->Initialize($_REQUEST['Messageid']);
                            $msg->Stared = false;
                            $msg->Save();

                            $ret->data = Message::Staredcount($GLOBALS['subscriber']);
                            $ret->status = "success";
                            $ret->message = "Message has been unstared";
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