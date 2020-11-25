<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Webfront->WriteAccess)
                        {
                            $module = new Modules($GLOBALS['subscriber']);
                            $module->Aboutus = Convert::ToBool($_REQUEST['aboutus']);
                            $module->Bakery = Convert::ToBool($_REQUEST['bakery']);
                            $module->Bar = Convert::ToBool($_REQUEST['bar']);
                            $module->Booking = Convert::ToBool($_REQUEST['booking']);
                            $module->Contactus = Convert::ToBool($_REQUEST['contactus']);
                            $module->Customers = Convert::ToBool($_REQUEST['customer']);
                            $module->Discount = Convert::ToBool($_REQUEST['discount']);
                            $module->Facilities = Convert::ToBool($_REQUEST['facilities']);
                            $module->Faq = Convert::ToBool($_REQUEST['faq']);
                            $module->Gallery = Convert::ToBool($_REQUEST['gallery']);
                            $module->Kitchen = Convert::ToBool($_REQUEST['kitchen']);
                            $module->Laundry = Convert::ToBool($_REQUEST['laundry']);
                            $module->Lodging = Convert::ToBool($_REQUEST['lodging']);
                            $module->Newsletter = Convert::ToBool($_REQUEST['newsletter']);
                            $module->Testimonials = Convert::ToBool($_REQUEST['testimonials']);
                            $module->Terms = Convert::ToBool($_REQUEST['terms']);
                            $module->Team = Convert::ToBool($_REQUEST['team']);
                            $module->Policy = Convert::ToBool($_REQUEST['policy']);
                            $module->Pagetext = Convert::ToBool($_REQUEST['pagetext']);
                            $module->Services = Convert::ToBool($_REQUEST['services']);

                            $module->Save();

                            $ret->status = "success";
                            $ret->message = "Module settings have been saved successfully";
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