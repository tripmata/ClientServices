<?php

	$ret = new stdClass();


					if(!Customer::EmailExist($_REQUEST['email'], $GLOBALS['subscriber']))
					{
						if(!Customer::PhoneExist($_REQUEST['phone'], $GLOBALS['subscriber']))
						{
							$customer = new Customer($GLOBALS['subscriber']);

							$names = explode(" ", $_REQUEST['names']);

							$customer->Name = $names[0];
							if(count($names) > 1)
							{
								$customer->Surname = $names[1];
							}
							$customer->Email = trim(strtolower($_REQUEST['email']));
							$customer->Phone = trim(strtolower($_REQUEST['phone']));
							$customer->SetPassword(md5($_REQUEST['password']));

							$customer->Save();

                            $context = Context::Create($customer);
                            $event = new Event($GLOBALS['subscriber'], Event::CustomerAccountCreated, $context);
                            Event::Fire($event);


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
							$ret->message = "Customer have been added successfully";
						}
						else
						{
							$ret->status = "error";
							$ret->message = "Phone number exist";
							$ret->data = "";
						}
					}
					else
					{
						$ret->status = "error";
						$ret->message = "Email have been used";
						$ret->data = "";
					}


	echo json_encode($ret);