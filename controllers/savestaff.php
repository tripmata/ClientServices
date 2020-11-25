<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        if($GLOBALS['subscriber']->Id == $_REQUEST['usersess'])
                        {
                            $staff = new Staff($GLOBALS['subscriber']);
                            $staff->Initialize($_REQUEST['staffid']);
                            $staff->Name = $_REQUEST['name'];
                            $staff->Surname = $_REQUEST['surname'];
                            $staff->Phone = $_REQUEST['phone'];
                            $staff->Email = $_REQUEST['email'];
                            $staff->Nationality = $_REQUEST['country'];
                            $staff->State = $_REQUEST['state'];
                            $staff->Address = $_REQUEST['address'];
                            $staff->Sex = $_REQUEST['sex'];
                            $staff->Dateofbirth = strtotime($_REQUEST['dateofbirth']);
                            $staff->Department = $_REQUEST['department'];
                            $staff->Shift = array($_REQUEST['shift']);
                            $staff->Position = $_REQUEST['position'];
                            $staff->Bank = $_REQUEST['bank'];
                            $staff->Accountname = $_REQUEST['accname'];
                            $staff->Accountnumber = $_REQUEST['accountnum'];
                            $staff->Passport = $_REQUEST['passport'];
                            $staff->Fullshot = $_REQUEST['fullshot'];
                            $staff->Biodata = $_REQUEST['biodata'];
                            $staff->Salary = $_REQUEST['salary'];
                            $staff->Status = true;

                            $staff->Save();

                            $ret->status = "success";
                            $ret->data = "success";
                        }
                        else
                        {
                            $user = new User($GLOBALS['subscriber']);
                            

                            if($GLOBALS['user']->Access->Role->WriteAccess == true)
                            {

                            }
                            else
                            {
                                $ret->status = "access denied";
                                $ret->message = "You do not have the required privilage to complete the operation";
                            }
                        }
                    }
                    else
                    {
                        $ret->status = "login";
                        $ret->data = "login";
                    }

	echo json_encode($ret);