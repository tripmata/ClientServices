<?php

	$ret = new stdClass();


					$customer = Customer::ByEmail($GLOBALS['subscriber'], $_REQUEST['email']);

					if($customer->Id != "")
					{
						if($customer->GetPassword() == md5($_REQUEST['password']))
						{
							$pack = new stdClass();
							$pack->Status = "success";
							$pack->Data = new stdClass();
							$pack->Data->setMethod = "session";
							$pack->Data->setName = "custsess";
							$pack->Data->setValue = $customer->Id;
							$pack->Data->Status = "success";

							$ret->Type = "set";
							$ret->Content = $pack;

							$ret->status = "success";
							$ret->message = "Customer logged in successfully";

                            $context = Context::Create($customer);
                            $event = new Event($GLOBALS['subscriber'], Event::CustomerLoggedIn, $context);
                            Event::Fire($event);
						}
						else
						{
							$ret->status = "failed";
							$ret->message = "Invalid credentials";
						}
					}
					else
					{
						$ret->status = "failed";
						$ret->message = "Invalid credentials";
					}

	echo json_encode($ret);