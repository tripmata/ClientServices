<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Webfront->ReadAccess)
                        {
                            $banner = new Banner($GLOBALS['subscriber']);
                            $banner->Initialize($_REQUEST['Bannerid']);
                            $banner->Status = Convert::ToBool($_REQUEST['Status']);
                            $banner->Save();

                            $ret->status = "success";
                            $ret->message = "Banner status saved successfully";
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