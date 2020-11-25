<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Webconfig->WriteAccess)
                        {
                            $integration = new Integration($GLOBALS['subscriber']);
                            $integration->Analytics = $_REQUEST['analytics'];
                            $integration->Save();

                            $ret->status = "success";
                            $ret->message = "Analytics saved successfully";
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