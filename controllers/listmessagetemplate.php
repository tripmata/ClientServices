<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->data = messagetemplate::All($GLOBALS['subscriber']);

	echo json_encode($ret);