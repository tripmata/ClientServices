<?php
	/* Generated by Wixnit Class Builder 
	// Apr, 06/2020
	// Building list routine for class Partner
	*/


	session_start();
	//---------- Include files

	//require_once("../db.php");

	//---------- End of include


	$partners = Partner::All();

	$ret = new stdClass();
	$ret->Status = "ACCESS_DENIED";
	$ret->Data = array();
	$ret->Message = "Please login again";

	//If user verification is used
	//if(isset($_SESSION['']) === true)
	//{
		$ret->Status = "SUCCESS";
		$ret->Data = $partners;
		$ret->Message= "DONE";
	//}
	echo json_encode($ret);
	
