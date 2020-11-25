<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Settings->WriteAccess)
                        {
                            $site = new Site($GLOBALS['subscriber']);
                            $site->Tandc = $_REQUEST['content'];
                            $site->Save();
                            $ret->status = "success";
                            $ret->data = "success";
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
                        $ret->data = "login";
                    }


	echo json_encode($ret);