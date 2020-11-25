<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->data = Role::GroupInitialize($GLOBALS['subscriber'], null);

	echo json_encode($ret);