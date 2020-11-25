<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Bakery->ReadAccess)
                        {
                            $pastrycat = new Pastrycategory($GLOBALS['subscriber']);
                            $pastrycat->Initialize($_REQUEST['catid']);
                            $pastrycat->Name = $_REQUEST['title'];
                            $pastrycat->Sort = Convert::ToInt($_REQUEST['sort']);
                            $pastrycat->Status = Convert::ToBool($_REQUEST['status']);
                            $pastrycat->Save();

                            $ret->status = "success";
                            $ret->message = "Pastry category saved successfully";
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