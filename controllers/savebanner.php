<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Webfront->ReadAccess)
                        {
                            $banner = new Banner($GLOBALS['subscriber']);
                            $banner->Initialize($_REQUEST['id']);
                            $banner->Image = $_REQUEST['image'];
                            $banner->Text = $_REQUEST['main'];
                            $banner->Subtext = $_REQUEST['sub'];
                            $banner->Status = Convert::ToBool($_REQUEST['status']);
                            $banner->Sort = Convert::ToInt($_REQUEST['sort']);
                            $banner->Save();

                            $ret->status = "success";
                            $ret->message = "Banner saved successfully";
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