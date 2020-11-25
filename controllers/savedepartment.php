<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Staff->WriteAccess)
                        {
                            $department = new Department($GLOBALS['subscriber']);
                            $department->Initialize($_REQUEST['dept_id']);
                            $department->Name = ucwords(strtolower($_REQUEST['name']));

                            if($department->Id == "")
                            {
                                if($department->Exist())
                                {
                                    $ret->status = "success";
                                    $ret->data = "failed";
                                    $ret->message = "Department Exists";
                                }
                                else
                                {
                                    $department->Save();
                                }
                            }
                            else
                            {
                                $department->Save();
                            }


                            $ret->data = "success";
                            $ret->status = "success";
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