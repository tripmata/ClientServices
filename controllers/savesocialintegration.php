<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Webconfig->WriteAccess)
                        {
                            $integration = new Integration($GLOBALS['subscriber']);
                            $integration->Facebook = $_REQUEST['facebook'];
                            $integration->Twitter = $_REQUEST['twitter'];
                            $integration->Instagram = $_REQUEST['instagram'];
                            $integration->Google = $_REQUEST['google'];
                            $integration->Whatsapp = $_REQUEST['whatsapp'];
                            $integration->Telegram = $_REQUEST['telegram'];
                            $integration->Linkedin = $_REQUEST['linkedin'];

                            $integration->Save();

                            $ret->status = "success";
                            $ret->message = "Settings saved successfully";
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