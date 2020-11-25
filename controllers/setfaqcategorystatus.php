<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        if($GLOBALS['subscriber']->Id == $_REQUEST['usersess'])
                        {
                            $faqcat = new Faqcategory($GLOBALS['subscriber']);
                            $faqcat->Initialize($_REQUEST['Faqcategoryid']);
                            $faqcat->Status = Convert::ToBool($_REQUEST['Status']);
                            $faqcat->Save();

                            $ret->status = "success";
                            $ret->data = "success";
                            $ret->message = "FAQ category deleted";
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