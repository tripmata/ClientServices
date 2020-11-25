<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->data = Drinkcategory::All($GLOBALS['subscriber']);

	echo json_encode($ret);