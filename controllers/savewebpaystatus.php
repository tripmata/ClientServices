<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Webconfig->ReadAccess)
                        {
                            $site = new Site($GLOBALS['subscriber']);
                            $site->Payonline = Convert::ToBool($_REQUEST['webpay']);
                            $site->Nopayreservation = Convert::ToBool($_REQUEST['nopayreservation']);
                            $site->Save();

                            $ret->status = "success";
                            $ret->message = "Web pay status saved successfully";
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