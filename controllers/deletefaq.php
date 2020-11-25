<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
	if ($GLOBALS['user']->Role->Webfront->WriteAccess)
	{
		$faq = new Faq($GLOBALS['subscriber']);
		$faq->Initialize($_REQUEST['Faqid']);

		$faq->Delete();

		$ret->status = "success";
		$ret->data = "success";
		$ret->message = "FAQ have been deleted";
	}
	else
	{
		$ret->status = "access denied";
		$ret->message = "You do not have the required privilege to complete the operation";
	}
}
else
{
	$ret->status = "login";
	$ret->data = "login";
}

echo json_encode($ret);