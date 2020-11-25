<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Webfront->WriteAccess)
                        {
                            $testimonial = new Testimonial($GLOBALS['subscriber']);
                            $testimonial->Initialize($_REQUEST['teamid']);

                            $testimonial->Status = Convert::ToBool($_REQUEST['status']);
                            $testimonial->Body = $_REQUEST['testimony'];
                            $testimonial->Name = $_REQUEST['name'];
                            $testimonial->Image = $_REQUEST['image'];
                            $testimonial->Sort = $_REQUEST['sort'];
                            $testimonial->Rating = Convert::ToInt($_REQUEST['rating']);

                            $testimonial->Save();

                            $ret->status = "success";
                            $ret->data = $testimonial->Id;
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