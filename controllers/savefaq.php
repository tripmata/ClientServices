<?php

	$ret = new stdClass();

					if($GLOBALS['user']->Id != "")
					{
                        

						if($GLOBALS['user']->Role->Webfront->WriteAccess)
						{
							$faq = new Faq($GLOBALS['subscriber']);
							$faq->Initialize($_REQUEST['faqid']);

							$faq->Question = $_REQUEST['question'];
							$faq->Answer = $_REQUEST['answer'];
							$faq->Category = $_REQUEST['category'];
							$faq->Sort = Convert::ToInt($_REQUEST['sort']);
							$faq->Status = Convert::ToBool($_REQUEST['status']);

							$faq->Save();

							$ret->status = "success";
							$ret->message = "FAQ is saved";
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