<?php

	$ret = new stdClass();


                    $doc = new stdClass();
                    $doc->Startdate = $_REQUEST['startdate'];
                    $doc->Stopdate = $_REQUEST['stopdate'];
                    $doc->Item = $_REQUEST['itemid'];
                    $doc->Type = $_REQUEST['itemtype'];
                    $doc->Filter = $_REQUEST['filter'];

                    $printer = Printer::SafePrint($GLOBALS['subscriber'], $doc, "item timeline");

                    
                    $ret->status = "success";
                    $ret->URL = $GLOBALS['subscriber']->Domain."/print/".$printer->Meta;


	echo json_encode($ret);