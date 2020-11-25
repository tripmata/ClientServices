<?php

	$ret = new stdClass();

                    $doc = new stdClass();
                    $doc->Audit = $_REQUEST['auditid'];
                    $doc->Type = $_REQUEST['itemtype'];

                    $printer = Printer::SafePrint($GLOBALS['subscriber'], $doc, "audit");

                    $ret->status = "success";
                    $ret->URL = $GLOBALS['subscriber']->Domain."/print/".$printer->Meta;

	echo json_encode($ret);