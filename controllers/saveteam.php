<?php

	$ret = new stdClass();

                            if($GLOBALS['user']->Id != "")
                            {
                                

                                if($GLOBALS['user']->Role->Webfront->WriteAccess)
                                {
                                    $gallery = new Team($GLOBALS['subscriber']);
                                    $gallery->Initialize($_REQUEST['teamid']);

                                    $gallery->Status = Convert::ToBool($_REQUEST['status']);
                                    $gallery->Description = $_REQUEST['description'];
                                    $gallery->Name = $_REQUEST['name'];
                                    $gallery->Image = $_REQUEST['image'];
                                    $gallery->Sort = $_REQUEST['sort'];

                                    $gallery->Save();

                                    $ret->status = "success";
                                    $ret->data = $gallery->Id;
                                    $ret->message = "Gallery item is saved";
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