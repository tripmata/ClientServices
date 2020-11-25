<?php

	$ret = new stdClass();


                    $room = new Roomcategory($GLOBALS['subscriber']);
                    $room->Initialize($_REQUEST['room']);

                    if(($room->Id == "") || ($room->Status))
                    {
                        if($room->Reservable)
                        {
                            $ret->data = new stdClass();
                            $ret->data->Room = $room->Id;
                            if(($_REQUEST['checkin'] == "null") || ($_REQUEST['checkin'] == null) || ($_REQUEST['checkin'] == "undefined"))
                            {
                                $ret->data->Checkin = "";
                            }
                            else
                            {
                                $ret->data->Checkin = $_REQUEST['checkin'];
                            }
                            if(($_REQUEST['checkout'] == "null") || ($_REQUEST['checkout'] == null) || ($_REQUEST['checkout'] == "undefined"))
                            {
                                $ret->data->Checkout = "";
                            }
                            else
                            {
                                $ret->data->Checkout = $_REQUEST['checkout'];
                            }
                            $ret->status = "success";
                        }
                        else
                        {
                            $ret->status = "failed";
                            $ret->message = "Selected room cannot be booked right now. Try again later";
                        }
                    }
                    else
                    {
                        $ret->status = "failed";
                        $ret->message = "Invalid room selected";
                    }

	echo json_encode($ret);