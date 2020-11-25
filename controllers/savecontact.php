<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Messaging->WriteAccess)
                        {
                            $names = explode(" ", $_REQUEST['names']);

                            $contact = new Contact($GLOBALS['subscriber']);
                            $contact->Initialize($_REQUEST['id']);
                            $contact->Name = ucwords(strtolower($names[0]));
                            if(count($names) > 1)
                            {
                                $contact->Surname = ucwords(strtolower($names[1]));
                            }
                            $contact->Email = strtolower($_REQUEST['email']);
                            $contact->Phone = strtolower($_REQUEST['phone']);
                            $contact->Save();

                            $ret->status = "success";
                            $ret->message = "Contact saved successfully";
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