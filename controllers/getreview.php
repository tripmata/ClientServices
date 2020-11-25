<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Messaging->ReadAccess)
                        {
                            $ret->data = new stdClass();
                            $ret->data->Review = new Review($GLOBALS['subscriber']);
                            $ret->data->Review->Initialize($_REQUEST['reviewid']);

                            $ret->data->Sent = Reviewsession::Sentcount($GLOBALS['subscriber'], $ret->data->Review->Id);
                            $ret->data->Responded = Reviewsession::Responsecount($GLOBALS['subscriber'], $ret->data->Review->Id);

                            $ret->data->Items = $ret->data->Review->GetItems();

                            $ret->data->Responses = array();

                            $sess = new Reviewsession($GLOBALS['subscriber']);
                            $sess->Initialize($ret->data->Review->Id);

                            $ret->data->Viasms = Reviewsession::SMSResponses($GLOBALS['subscriber'], $ret->data->Review);
                            $ret->data->Viaemail = Reviewsession::EmailResponses($GLOBALS['subscriber'], $ret->data->Review);
                            $ret->data->Unknownsource = Reviewsession::UnknownResponses($GLOBALS['subscriber'], $ret->data->Review);

                            if($ret->data->Review->Id != "")
                            {
                                $ret->data->Responses = Reviewsession::Get($GLOBALS['subscriber'], $ret->data->Review);

                                $ret->status = "success";
                                $ret->message = "Message retrieved successfully";
                            }
                            else
                            {
                                $ret->status = "success";
                                $ret->message = "Message retrieved successfully";
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