<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Messaging->ReadAccess)
                        {
                            $settings = new Messagesettings($GLOBALS['subscriber']);

                            if($settings->Ononiruapikey == "")
                            {
                                $ret->status = "failed";
                                $ret->message = "You have not added your API key.";
                            }
                            else
                            {
                                ////TODO:
                                /// Do api connecting Ononiru is doe

                                //Statment to be removed when Ononiru integration is ready
                                if(!false)
                                {
                                    $ret->status = "failed";
                                    $ret->message = "Unable to connect at the moment. Please try again latter";
                                }
                                else
                                {
                                    $ret->status = "success";
                                    $ret->message = "API connected successfully";
                                }
                            }
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