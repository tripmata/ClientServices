<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Bar->ReadAccess)
                        {
                            $ret->status = "success";
                            $ret->data = new Drink($GLOBALS['subscriber']);
                            $ret->data->Initialize($_REQUEST['drinkid']);

                            $ret->message = "Single drink retrieved";
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