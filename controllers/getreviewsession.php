<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Messaging->ReadAccess)
                        {
                            $sess = new Reviewsession($GLOBALS['subscriber']);
                            $sess->Initialize($_REQUEST['sessionid']);

                            $ret->User = new Customer($GLOBALS['subscriber']);
                            $ret->User->Initialize($sess->User);

                            $ret->Session = $sess;

                            $ret->data = $sess->Getresponses();


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
                        $ret->data = "login & try again";
                    }

	echo json_encode($ret);