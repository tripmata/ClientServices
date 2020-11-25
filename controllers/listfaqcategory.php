<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->data = Faqcategory::All($GLOBALS['subscriber']);

	echo json_encode($ret);