<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['subscriber']->Id == $_REQUEST['usersess'])
                        {
                            $ret->status = "failed";
                            $ret->message = "The super user has no username. The hotel email serves as the username for a super user";
                        }
                        else if($GLOBALS['user']->Id !== "")
                        {
                            $GLOBALS['user']->Username = $_REQUEST['username'];
                            $GLOBALS['user']->Save();

                            $ret->status = "success";
                            $ret->message = "Admin username saved";
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