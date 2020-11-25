<?php

$ret = new stdClass();

if($GLOBALS['user']->Id != "")
{
	if($GLOBALS['subscriber']->Id == $_REQUEST['usersess'])
	{
		$role = new Role($GLOBALS['subscriber']);
		$role->Initialize($_REQUEST['Roleid']);
		$role->Delete();

		$ret->status = "success";
		$ret->data = "success";
		$ret->message = "Role have been deleted";
	}
	else
	{
		$ret->status = "access denied";
		$ret->message = "You do not have the required privilage to complete the operation";
	}
}
else
{
	$ret->status = "login";
	$ret->data = "login";
}

echo json_encode($ret);