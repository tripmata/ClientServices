<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Webconfig->WriteAccess)
                        {
                            $words = explode(",", $_REQUEST['keyword']);

                            $seo = new Seo($GLOBALS['subscriber']);
                            $seo->Homekeywords = array();

                            for($i = 0; $i < count($words); $i++)
                            {
                                if($words[$i] != "")
                                {
                                    array_push($seo->Homekeywords, $words[$i]);
                                }
                            }
                            $seo->Homedescription = $_REQUEST['description'];
                            $seo->Save();

                            $ret->status = "success";
                            $ret->message = "Home page SEO saved successfully";
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