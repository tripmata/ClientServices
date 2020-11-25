<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Discount->ReadAccess)
                        {
                            $service = new Extraservice($GLOBALS['subscriber']);
                            $service->Initialize($_REQUEST['id']);
                            $service->Name = $_REQUEST['name'];
                            $service->Price = floatval($_REQUEST['price']);
                            $service->Save();

                            $ret->status = "success";
                            $ret->message = "Extra service saved successfully";
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