<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['subscriber']->Id == $_REQUEST['usersess'])
                        {
                            $GLOBALS['subscriber']->UpdatePassword($_REQUEST['password']);

                            $ret->status = "success";
                            $ret->message = "Admin password saved";
                        }
                        else if($GLOBALS['user']->Id !== "")
                        {
                            $GLOBALS['user']->setPassword($_REQUEST['password']);
                            $GLOBALS['user']->Save();

                            $ret->status = "success";
                            $ret->message = "Admin password saved";
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