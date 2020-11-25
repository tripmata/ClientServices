<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        if($GLOBALS['user']->Role->Webfront->ReadAccess)
                        {
                            $site = new Site($GLOBALS['subscriber']);
                            $ret->data = $site->PageText;
                            $ret->status = "success";
                            $ret->message = "Page text was retrieved successfully";
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