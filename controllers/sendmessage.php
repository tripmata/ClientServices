<?php

	$ret = new stdClass();

                    $message = new Message($GLOBALS['subscriber']);

                    $names = explode(" ", $_REQUEST['names']);

                    $message->Name = $names[0];
                    if(count($names) > 1)
                    {
                        $message->Surname = $names[1];
                    }
                    $message->Email = strtolower($_REQUEST['email']);
                    $message->Phone = strtolower($_REQUEST['phone']);
                    $message->Body = strtolower($_REQUEST['message']);
                    $message->Save();

                    $context = Context::Create($customer);
                    $event = new Event($GLOBALS['subscriber'], Event::UserSendsMessage, $context);
                    Event::Fire($event);

                    $ret->status = "success";
                    $ret->message = "Message sent";

	echo json_encode($ret);