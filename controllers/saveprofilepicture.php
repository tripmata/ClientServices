<?php

	$ret = new stdClass();

                    $customer = new Customer($GLOBALS['subscriber']);

                    if(isset($_REQUEST['custsess']))
                    {
                        $customer->Initialize($_REQUEST['custsess']);
                    }

                    if($customer->Id != "")
                    {
                        $customer->Profilepic = $_REQUEST['img'];
                        $customer->Save();

                        $ret->status = "success";
                        $ret->message = "Profile picture updated successfully";
                    }
                    else
                    {
                        $ret->status = "failed";
                        $ret->message = "Invalid customer account";
                        Fraudlog::Log($GLOBALS['subscriber'], "Fraud detected", "User Account", "Attempt to update user profile image");
                    }

				default:
					$ret->data = "This is the part I hate the most";
			}
		}
		else if(($router->Page == "hms-pos") || ($p == "hms-pos"))
		{
            switch ($_REQUEST['job'])
            {
	echo json_encode($ret);