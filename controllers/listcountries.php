<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->success = true;
                    $ret->results = array();

                    $ret->data = Country::GroupInitialize(null);

	echo json_encode($ret);