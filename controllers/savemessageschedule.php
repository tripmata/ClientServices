<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Booking->ReadAccess)
                        {
                            $msgSchedule = new Messageschedule($GLOBALS['subscriber']);
                            $msgSchedule->Initialize($_REQUEST['id']);

                            $msgSchedule->Title = $_REQUEST['title'];
                            $msgSchedule->Message = new Messagetemplate($GLOBALS['subscriber']);
                            $msgSchedule->Message->Initialize($_REQUEST['message']);

                            $msgSchedule->Year = Convert::ToInt($_REQUEST['year']);
                            $msgSchedule->Month = Convert::MonthToNumber($_REQUEST['month']);
                            $msgSchedule->Day = Convert::ToInt($_REQUEST['day']);
                            $msgSchedule->Hour = Convert::ToInt($_REQUEST['hour']);
                            $msgSchedule->Minuet = Convert::ToInt($_REQUEST['min']);
                            $msgSchedule->Status = Convert::ToBool($_REQUEST['status']);
                            $msgSchedule->Meridian = $_REQUEST['gmt'];
                            $msgSchedule->Continuous = Convert::ToBool($_REQUEST['inifinity']);
                            $msgSchedule->Autodelete = Convert::ToBool($_REQUEST['autodelete']);
                            $msgSchedule->Execcount = Convert::ToInt($_REQUEST['executions']);
                            $msgSchedule->Issystem = false;


                            $msgSchedule->Contactlist = array();

                            $l = explode(",", $_REQUEST['contactcollection']);
                            for($i = 0; $i < count($l); $i++)
                            {
                                $x = explode("\n", $l[$i]);
                                for($j = 0; $j < count($x); $j++)
                                {
                                    if($x[$j] != "")
                                    {
                                        array_push($msgSchedule->Contactlist, trim(strtolower($x[$j])));
                                    }
                                }
                            }


                            $contacts = explode(",", $_REQUEST['contacts']);

                            $msgSchedule->Guest = in_array("guest", $contacts);
                            $msgSchedule->Customers = in_array("customers", $contacts);
                            $msgSchedule->Staff = in_array("staff", $contacts);
                            $msgSchedule->Subscribers = in_array("subscribers", $contacts);
                            $msgSchedule->Contactus = in_array("contactus", $contacts);

                            $msgSchedule->Customlist = array();


                            for($i = 0; $i < count($contacts); $i++)
                            {
                                if($contacts[$i] != "")
                                {
                                    if(($contacts[$i] != "guest") && ($contacts[$i] != "customers") && ($contacts[$i] != "staff")
                                        && ($contacts[$i] != "subscribers") && ($contacts[$i] != "contactus"))
                                    {
                                        array_push($msgSchedule->Customlist, $contacts[$i]);
                                    }
                                }
                            }

                            $msgSchedule->Save();

                            $ret->status = "success";
                            $ret->data = null;
                            $ret->message = "Message schedule saved successfully ";
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