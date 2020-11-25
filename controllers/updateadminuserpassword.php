<?php

	$ret = new stdClass();

					if($GLOBALS['user']->Id != "")
					{
                        

						if($GLOBALS['user']->Role->Rooms->WriteAccess)
						{
							if($GLOBALS['subscriber']->isPassword($_REQUEST['old']))
							{
								$GLOBALS['subscriber']->UpdatePassword(md5($_REQUEST['new']));
								$ret->status = "success";
								$ret->data = "success";
							}
							else
							{
								$ret->status = "failed";
								$ret->message = "Invalid old password";
							}
						}
						else if($GLOBALS['user']->Id != "")
						{
							if($GLOBALS['user']->isPassword($_REQUEST['old']))
							{
								$GLOBALS['user']->Updatepassword($_REQUEST['new']);
								$ret->status = "success";
								$ret->data = "success";
							}
							else
							{
								$ret->status = "failed";
								$ret->message = "Invalid old password";
							}
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