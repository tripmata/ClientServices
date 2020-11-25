<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->data = Roomcategory::All($GLOBALS['subscriber']);

	echo json_encode($ret);