<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Kitchen->ReadAccess)
                        {
                            $foodcat = new Foodcategory($GLOBALS['subscriber']);
                            $foodcat->Initialize($_REQUEST['catid']);
                            $foodcat->Name = $_REQUEST['title'];
                            $foodcat->Sort = Convert::ToInt($_REQUEST['sort']);
                            $foodcat->Status = Convert::ToBool($_REQUEST['status']);
                            $foodcat->Save();

                            $ret->status = "success";
                            $ret->message = "Food category saved successfully";
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