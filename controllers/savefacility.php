<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Webfront->WriteAccess)
                        {
                            $facility = new Facilities($GLOBALS['subscriber']);
                            $facility->Initialize($_REQUEST['facilityid']);

                            $facility->Status = Convert::ToBool($_REQUEST['status']);
                            $facility->Body = $_REQUEST['body'];
                            $facility->Heading = $_REQUEST['heading'];
                            $facility->Icon = $_REQUEST['image'];
                            $facility->Icontype = $_REQUEST['icontype'];
                            $facility->Sort = $_REQUEST['sort'];

                            $facility->Save();

                            $ret->status = "success";
                            $ret->data = $facility->Id;
                            $ret->message = "Facility item is saved";
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