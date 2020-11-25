<?php

	$ret = new stdClass();

					if($GLOBALS['user']->Id != "")
					{
                        

						if($GLOBALS['user']->Role->Webfront->WriteAccess)
						{
							$faqcat = new Faqcategory($GLOBALS['subscriber']);
							$faqcat->Initialize($_REQUEST['catid']);
							$faqcat->Name = $_REQUEST['title'];
							$faqcat->Sort = Convert::ToInt($_REQUEST['sort']);
							$faqcat->Status = Convert::ToBool($_REQUEST['status']);

							$faqcat->Save();

							$ret->status = "success";
							$ret->message = "";
							$ret->data = "";
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