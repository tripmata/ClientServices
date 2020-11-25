<?php

	$ret = new stdClass();


                    $reviewsession  = new Reviewsession($GLOBALS['subscriber']);
                    $reviewsession->Initialize($_REQUEST['sessionid']);
                    $reviewsession->Responsechannel = $_REQUEST['channel'];

                    $x = explode(",", $_REQUEST['data']);

                    $data = [];

                    for($i = 0; $i < count($x); $i++)
                    {
                        if($x[$i] != "")
                        {
                            array_push($data,$x[$i]);
                        }
                    }

                    for($i = 0; $i < count($data); $i++)
                    {
                        $d = explode(":", $data[$i]);

                        if(count($d) > 2)
                        {
                            $response = new Reviewresponse($GLOBALS['subscriber']);
                            $response->User = $reviewsession->User;
                            $response->Sessionid = $reviewsession->Id;
                            $response->Itemid = $d[0];
                            $response->Type = $d[1];
                            $response->Reviewid = $reviewsession->Reviewid;
                            $response->Responsedate = new WixDate(time());

                            if($response->Type == "star-rating")
                            {
                                $response->Rating = Convert::ToInt($d[2]);
                            }
                            if($response->Type == "heart-rating")
                            {
                                $response->Rating = Convert::ToInt($d[2]);
                            }
                            if($response->Type == "multiple-select")
                            {
                                $response->Options = array();

                                for($j = 2; $j < count($d); $j++)
                                {
                                    array_push($response->Options, $d[$j]);
                                }
                            }
                            if($response->Type == "single-select")
                            {
                                array_push($response->Options, $d[2]);
                            }
                            if($response->Type == "comment-box")
                            {
                                $response->Comment = $d[2];
                            }
                            $response->Save();
                        }
                    }
                    $reviewsession->Responded = true;
                    $reviewsession->Responsedate = time();
                    $reviewsession->Save();

                    $ret->status = "success";
                    $ret->message = "Response received";

	echo json_encode($ret);