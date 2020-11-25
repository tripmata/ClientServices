<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->data = Drink::All($GLOBALS['subscriber']);

	echo json_encode($ret);