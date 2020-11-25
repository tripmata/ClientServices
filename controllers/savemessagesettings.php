<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Messaging->ReadAccess)
                        {
                            $settings = new Messagesettings($GLOBALS['subscriber']);

                            $settings->Lowunitphone = $_REQUEST['lowunitphone'];
                            $settings->Tagprocessing = $_REQUEST['tagprocessing'];
                            $settings->Ononiruapikey = $_REQUEST['ononiruapikey'];
                            $settings->Lowunitpoint = $_REQUEST['lowunitpoint'];

                            $settings->Save();

                            $ret->status = "success";
                            $ret->message = "messaging settings have been saved successfully";
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