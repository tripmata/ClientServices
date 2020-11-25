<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Customers->WriteAccess)
                        {
                            $review = new Review($GLOBALS['subscriber']);
                            $review->Initialize($_REQUEST['reviewid']);
                            $review->Title = $_REQUEST['title'];
                            $review->Body = $_REQUEST['body'];
                            $review->Save();

                            $items = explode(",", $_REQUEST['data']);

                            $reviewitems = array();

                            for($i = 0; $i < count($items); $i++)
                            {
                                if($items[$i] != "")
                                {
                                    $dv = explode(":", $items[$i]);

                                    $it = new Reviewitem($GLOBALS['subscriber']);
                                    $it->Initialize($dv[0]);

                                    $it->Type = $dv[1];
                                    $it->Question = $dv[2];

                                    if($it->Type == "star-rating")
                                    {
                                        $it->Maxrating = Convert::ToInt($dv[3]);
                                    }
                                    if($it->Type == "heart-rating")
                                    {
                                        $it->Maxrating = Convert::ToInt($dv[3]);
                                    }
                                    if($it->Type == "multiple-select")
                                    {
                                        $it->Options = array();

                                        for($h = 3; $h < count($dv); $h++)
                                        {
                                            array_push($it->Options, $dv[$h]);
                                        }
                                    }
                                    if($it->Type == "single-select")
                                    {
                                        $it->Options = array();

                                        for($h = 3; $h < count($dv); $h++)
                                        {
                                            array_push($it->Options, $dv[$h]);
                                        }
                                    }

                                    array_push($reviewitems, $it);
                                }

                                $review->Additems($reviewitems);
                            }

                            $ret->status = "success";
                            $ret->message = "Review have been saved successfully";
                            $ret->data = null;
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