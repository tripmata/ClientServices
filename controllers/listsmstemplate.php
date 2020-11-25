<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->data = messagetemplate::SMS($GLOBALS['subscriber']);

	echo json_encode($ret);