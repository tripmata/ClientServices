<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Booking->ReadAccess)
                        {
                            $event = new Eventlistener($GLOBALS['subscriber']);
                            $event->Initialize($_REQUEST['id']);

                            $event->Title = $_REQUEST['title'];
                            $event->Message = new Messagetemplate($GLOBALS['subscriber']);
                            $event->Message->Initialize($_REQUEST['message']);
                            $event->Event = $_REQUEST['event'];
                            $event->Delayhours = Convert::ToInt($_REQUEST['delayhours']);
                            $event->Delaymins = Convert::ToInt($_REQUEST['delaymins']);
                            $event->Contextuser = Convert::ToBool($_REQUEST['contextuser']);
                            $event->Status = Convert::ToBool($_REQUEST['status']);
                            $event->Issystem = false;


                            $event->Contactlist = array();

                            $l = explode(",", $_REQUEST['contactcollection']);
                            for($i = 0; $i < count($l); $i++)
                            {
                                $x = explode("\n", $l[$i]);
                                for($j = 0; $j < count($x); $j++)
                                {
                                    if($x[$j] != "")
                                    {
                                        array_push($event->Contactlist, trim(strtolower($x[$j])));
                                    }
                                }
                            }


                            $contacts = explode(",", $_REQUEST['contacts']);

                            $event->Guest = in_array("guest", $contacts);
                            $event->Customer = in_array("customers", $contacts);
                            $event->Staff = in_array("staff", $contacts);
                            $event->Subscribers = in_array("subscribers", $contacts);
                            $event->Contactform = in_array("contactus", $contacts);

                            $event->Customlist = array();


                            for($i = 0; $i < count($contacts); $i++)
                            {
                                if($contacts[$i] != "")
                                {
                                    if(($contacts[$i] != "guest") && ($contacts[$i] != "customers") && ($contacts[$i] != "staff")
                                        && ($contacts[$i] != "subscribers") && ($contacts[$i] != "contactus"))
                                    {
                                        array_push($event->Customlist, $contacts[$i]);
                                    }
                                }
                            }

                            $event->Save();

                            $ret->status = "success";
                            $ret->data = null;
                            $ret->message = "Event ";
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