<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->success = true;
                    $ret->results = array();
                    $ret->data = Extraservice::GroupInitialize($GLOBALS['subscriber'], null);



	echo json_encode($ret);