<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->data = Department::All($GLOBALS['subscriber']);

	echo json_encode($ret);