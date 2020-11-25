<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Messaging->ReadAccess)
                        {
                            $msg = new Message($GLOBALS['subscriber']);
                            $msg->Initialize($_REQUEST['Messageid']);
                            $msg->Stared = true;
                            $msg->Save();

                            $ret->data = Message::Staredcount($GLOBALS['subscriber']);
                            $ret->status = "success";
                            $ret->message = "Message has been deleted";
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