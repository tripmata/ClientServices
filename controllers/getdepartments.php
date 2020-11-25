<?php

	$ret = new stdClass();


                    $ret->data = array();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Staff->ReadAccess)
                        {
                            $department = Department::All($GLOBALS['subscriber']);

                            for($i = 0; $i < count($department); $i++)
                            {
                                $r = new stdClass();
                                $r->Department = $department[$i];
                                $r->Staffcount = $department[$i]->Staffcount();
                                $ret->data[$i] = $r;
                            }

                            $ret->status = "success";
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