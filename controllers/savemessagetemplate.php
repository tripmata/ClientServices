<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Messaging->WriteAccess)
                        {
                            $msgtmp = new Messagetemplate($GLOBALS['subscriber']);
                            $msgtmp->Initialize($_REQUEST['messageid']);
                            $msgtmp->From = $_REQUEST['from'];
                            $msgtmp->Fromname = $_REQUEST['fromname'];
                            $msgtmp->Replyto = $_REQUEST['replyto'];
                            $msgtmp->Attachment = $_REQUEST['attachment'];
                            $msgtmp->Subject = $_REQUEST['subject'];
                            $msgtmp->Body = $_REQUEST['body'];
                            $msgtmp->Status = Convert::ToBool($_REQUEST['status']);
                            $msgtmp->Type = $_REQUEST['type'];
                            $msgtmp->Title = $_REQUEST['title'];
                            $msgtmp->Save();

                            $ret->status = "success";
                            $ret->message = "Message template saved successfully";
                            $ret->data = null;
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