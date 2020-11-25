<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Pool->ReadAccess)
                        {
                            $ret->data = new Pool($GLOBALS['subscriber']);
                            $ret->data->Initialize($_REQUEST['id']);

                            $ret->status = "success";
                            $ret->message = "Pool session retrieved successfully";
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