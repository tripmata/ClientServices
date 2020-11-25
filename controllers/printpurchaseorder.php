<?php

	$ret = new stdClass();


                    $doc = new stdClass();
                    $doc->Order = $_REQUEST['orderid'];
                    $doc->Type = $_REQUEST['itemtype'];

                    $printer = Printer::SafePrint($GLOBALS['subscriber'], $doc, "purchase order");


                    $ret->status = "success";
                    $ret->URL = $GLOBALS['subscriber']->Domain."/print/".$printer->Meta;


	echo json_encode($ret);