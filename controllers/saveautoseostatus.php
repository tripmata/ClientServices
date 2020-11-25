<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Webconfig->WriteAccess)
                        {
                            $seo = new Seo($GLOBALS['subscriber']);
                            $seo->Autoseo = Convert::ToBool($_REQUEST['Autoseo']);
                            $seo->Save();

                            $ret->status = "success";
                            $ret->message = "Suto SEO saved successfully";
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