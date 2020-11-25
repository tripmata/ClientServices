<?php

	$ret = new stdClass();

                            if($GLOBALS['user']->Id != "")
                            {
                                

                                if($GLOBALS['user']->Role->Webfront->ReadAccess)
                                {
                                    $ret->data = Gallery::All($GLOBALS['subscriber']);

                                    $ret->status = "success";
                                    $ret->message = "Gallery item is saved";
                                }
                                else
                                {
                                    $ret->status = "access denied";
                                    $ret->message = "You do not have the required privilage to complete the operation";
                                }
                            }
                            else
                            {
                                $ret->status = "login";
                                $ret->data = "login";
                            }

	echo json_encode($ret);