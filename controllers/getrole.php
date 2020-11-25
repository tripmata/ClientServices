<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        if($GLOBALS['subscriber']->Id == $_REQUEST['usersess'])
                        {
                            $ret->data = new Role($GLOBALS['subscriber']);
                            $ret->data->Initialize($_REQUEST['roleid']);

                            $ret->status = "success";
                            $ret->message = "Role have been retrieved successfully";
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