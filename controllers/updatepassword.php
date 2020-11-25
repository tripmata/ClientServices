<?php

	$ret = new stdClass();


						$customer = new Customer($GLOBALS['subscriber']);

						if(isset($_REQUEST['custsess']))
						{
							$customer->Initialize($_REQUEST['custsess']);

							if($customer->GetPassword() == md5($_REQUEST['oldpassword']))
							{
								$customer->SetPassword(md5($_REQUEST['newpassword']));
								$customer->Save();
								$ret->status = "success";
							}
							else
							{
								$ret->message = "Invalid old password";
								$ret->status = "failed";
							}
						}

	echo json_encode($ret);