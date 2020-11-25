<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Laundry->ReadAccess)
                        {
                            $ret->data = new Laundry($GLOBALS['subscriber']);
                            $ret->data->Initialize($_REQUEST['id']);

                            $ret->status = "success";
                            $ret->message = "Laundry item retrieved successfully";
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