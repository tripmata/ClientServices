<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Messaging->ReadAccess)
                        {
                            $entity = Entity::getUser($GLOBALS['subscriber'], $_REQUEST['user'], $_REQUEST['type']);

                            $context = Context::Create($entity);

                            $mail = new Mail();
                            $mail->From = $_REQUEST['from'];
                            $mail->FromName = $_REQUEST['name'];
                            $mail->To = is_object($entity) ? $entity->Email : $entity;
                            $mail->ToName = is_object($entity) ? ($entity->Type != "supplier" ? ($entity->Name." ".$entity->Surname) :
                                ($entity->Company == "" ? $entity->Contactperson : $entity->Company)) : $entity;
                            $mail->Subject = $_REQUEST['subject'];
                            $mail->ReplyTo = $_REQUEST['replyto'];
                            $mail->ReplyToName = $_REQUEST['replytoname'];
                            $mail->Attachments = $_REQUEST['attachment'];
                            $mail->Body = Context::ProcessContent($context, $_REQUEST['message']);
                            $mail->Altbody = strip_tags($mail->Body);

                            $ret->data = Mail::Send($GLOBALS['subscriber'], $mail);
                            $ret->status = "success";
                            $ret->message = "Mail sent";
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