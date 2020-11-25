<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Settings->WriteAccess)
                        {
                            $GLOBALS['subscriber']->UpdateLogo($_REQUEST['logo']);

                            $site = new Site($GLOBALS['subscriber']);
                            $site->Logo = $_REQUEST['logo'];
                            $site->Save();

                            $ret->status = "success";
                            $ret->message = "logo saved";
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