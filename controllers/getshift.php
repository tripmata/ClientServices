<?php

	$ret = new stdClass();


                    $ret->data = array();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Staff->ReadAccess)
                        {
                            $shift = Shift::All($GLOBALS['subscriber']);

                            for($i = 0; $i < count($shift); $i++)
                            {
                                $h = $shift[$i]->Hours();

                                $r = new stdClass();
                                $r->Shift = $shift[$i];
                                $r->Period = $shift[$i]->PerioToString();
                                $r->Hours = $h->Hours."hrs ".$h->Minuites."mins";
                                $ret->data[$i] = $r;
                            }

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