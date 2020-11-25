<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Settings->WriteAccess)
                        {
                            $site = new Site($GLOBALS['subscriber']);
                            if((strtoupper($_REQUEST['collectaddress']) === "SIMPLE") ||
                                (strtoupper($_REQUEST['collectaddress']) === "INTERMEDIARY") ||
                                (strtoupper($_REQUEST['collectaddress']) === "DETAILED"))
                            {
                                $site->Guestformtype = strtoupper($_REQUEST['collectaddress']);
                                $site->Save();
                                $ret->status = "success";
                                $ret->message = "Settings saved successfully";
                            }
                            else
                            {
                                $ret->status = "failed";
                                $ret->message = "Unsupported form type";
                            }
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