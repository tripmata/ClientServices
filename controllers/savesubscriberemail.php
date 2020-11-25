<?php

	$ret = new stdClass();


                    $contact = new Contact($GLOBALS['subscriber']);
                    $contact->Email = $_REQUEST['email'];
                    $contact->Save();

                    $ret->status = "success";
                    $ret->message = "Email saved succcessfully";


	echo json_encode($ret);