<?php

	$ret = new stdClass();


                    $doc = new stdClass();
                    $doc->Note = $_REQUEST['noteid'];
                    $doc->Type = $_REQUEST['itemtype'];

                    $printer = Printer::SafePrint($GLOBALS['subscriber'], $doc, "supplier credit");


                    $ret->status = "success";
                    $ret->URL = $GLOBALS['subscriber']->Domain."/print/".$printer->Meta;



	echo json_encode($ret);