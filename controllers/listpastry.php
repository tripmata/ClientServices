<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->data = Pastry::All($GLOBALS['subscriber']);

	echo json_encode($ret);