<?php

	$ret = new stdClass();


                    $doc = new stdClass();
                    $doc->Quotation = $_REQUEST['quoteid'];
                    $doc->Type = $_REQUEST['itemtype'];
                    $doc->Filter = $_REQUEST['filter'];

                    $printer = Printer::SafePrint($GLOBALS['subscriber'], $doc, "quotation");


                    $ret->status = "success";
                    $ret->URL = $GLOBALS['subscriber']->Domain."/print/".$printer->Meta;

	echo json_encode($ret);