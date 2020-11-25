<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Messaging->ReadAccess)
                        {
                            $entity = Entity::getUser($GLOBALS['subscriber'], $_REQUEST['user'], $_REQUEST['type']);

                            $context = Context::Create($entity);

                            $sms = new Sms();
                            $sms->From = $_REQUEST['fromname'];
                            $sms->To = is_object($entity) ? $entity->Phone : $user;
                            $sms->Body = Context::ProcessContent($context, $_REQUEST['message']);

                            $ret->data = Sms::Send($GLOBALS['subscriber'], $sms);
                            $ret->status = "success";
                            $ret->message = "";
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