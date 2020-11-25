<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Messaging->WriteAccess)
                        {
                            $msgtmp = new Messagetemplate($GLOBALS['subscriber']);
                            $msgtmp->Initialize($_REQUEST['messageid']);

                            $ret->status = "success";
                            $ret->message = "Message template saved successfully";
                            $ret->data = $msgtmp;
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