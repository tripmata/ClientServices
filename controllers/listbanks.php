<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->data = array();
                    $ret->data[0] = "Diamond Bank";
                    $ret->data[1] = "First Bank";
                    $ret->data[2] = "Zenith Bank";
                    $ret->data[3] = "United Bank of Africa";
                    $ret->data[4] = "Sterling Bank";
                    $ret->data[5] = "Access Bank";
                    $ret->data[6] = "Union Bank";
                    $ret->data[7] = "Eco Bank";
                    $ret->data[8] = "Jaiz Bank";
                    $ret->data[9] = "GT Bank";
                    $ret->data[10] = "FCMB";
                    $ret->data[11] = " Bank";
                    $ret->data[12] = "Polaris Bank";
                    $ret->data[13] = "Afri Bank";

	echo json_encode($ret);