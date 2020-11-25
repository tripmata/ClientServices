<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->data = Shift::All($GLOBALS['subscriber']);

	echo json_encode($ret);