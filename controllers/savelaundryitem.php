<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Laundry->WriteAccess)
                        {
                            $laundry = new Laundry($GLOBALS['subscriber']);
                            $laundry->Initialize($_REQUEST['id']);

                            $laundry->Name = $_REQUEST['name'];
                            $laundry->Price = floatval($_REQUEST['price']);
                            $laundry->Status = Convert::ToBool($_REQUEST['status']);
                            $laundry->Tax = floatval($_REQUEST['tax']);
                            $laundry->Onsite = Convert::ToBool($_REQUEST['onsite']);

                            $laundry->Save();

                            $ret->status = "success";
                            $ret->data = null;
                            $ret->message = "Review has been deleted successfully";
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