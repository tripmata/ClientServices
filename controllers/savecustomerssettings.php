<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Settings->WriteAccess)
                        {
                            $site = new Site($GLOBALS['subscriber']);

                            $site->Customersaddress = Convert::ToBool($_REQUEST['collectaddress']);
                            $site->Customerselfdatamgt = Convert::ToBool($_REQUEST['allowselfmgt']);
                            $site->Save();
                            $ret->status = "success";
                            $ret->message = "Settings saved successfully";

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