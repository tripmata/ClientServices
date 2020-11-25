<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Webfront->WriteAccess)
                        {
                            $service = new Services($GLOBALS['subscriber']);
                            $service->Initialize($_REQUEST['serviceid']);

                            $service->Status = Convert::ToBool($_REQUEST['status']);
                            $service->Body = $_REQUEST['body'];
                            $service->Heading = $_REQUEST['heading'];
                            $service->Icon = $_REQUEST['image'];
                            $service->Icontype = $_REQUEST['icontype'];
                            $service->Sort = $_REQUEST['sort'];

                            $service->Save();

                            $ret->status = "success";
                            $ret->data = $service->Id;
                            $ret->message = "Testimonaial item is saved";
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