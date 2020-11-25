<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Messaging->ReadAccess)
                        {
                            $ret->data = new stdClass();
                            $ret->data->Review = new Review($GLOBALS['subscriber']);
                            $ret->data->Review->Initialize($_REQUEST['reviewid']);

                            $ret->data->Items = $ret->data->Review->GetItems();

                            $ret->status = "success";
                            $ret->message = "Message retrieved successfully";
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