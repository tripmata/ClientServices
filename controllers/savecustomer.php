<?php

	$ret = new stdClass();

					if($GLOBALS['user']->Id != "")
					{
                        

						if($GLOBALS['user']->Role->Customers->WriteAccess)
						{
							$customer = new Customer($GLOBALS['subscriber']);
							$customer->Initialize($_REQUEST['customerid']);

							if((!Customer::EmailExist($_REQUEST['email'], $GLOBALS['subscriber'])) || ($customer->Id !== ""))
							{
								if((!Customer::PhoneExist($_REQUEST['phone'], $GLOBALS['subscriber'])) || ($customer->Id !== ""))
								{
									$customer->Name = ucwords(strtolower($_REQUEST['name']));
									$customer->Surname = ucwords(strtolower($_REQUEST['surname']));
									$customer->Phone = $_REQUEST['phone'];
									$customer->Email = strtolower(trim($_REQUEST['email']));
									$customer->Country = $_REQUEST['country'];
									$customer->State = $_REQUEST['state'];
									$customer->City = $_REQUEST['city'];
									$customer->Street = $_REQUEST['street'];
									$customer->Sex = $_REQUEST['sex'];
									$customer->Status = true;
									$customer->Guestid = $_REQUEST['guestid'];

									if($customer->Guestid == "")
									{
										$customer->Guestid = strtoupper(Random::GenerateId(10));

										while(Customer::GuestExist($customer->Guestid, $GLOBALS['subscriber']))
										{
											$customer->Guestid = strtoupper(Random::GenerateId(10));
										}
									}

									if($customer->Id == "")
									{
										$customer->SetPassword(md5($_REQUEST['password']));
									}

									$customer->Newsletter = Convert::ToBool($_REQUEST['newletter']);

									if($customer->Newsletter == true)
									{
										Newsletter::Subscribe($customer, $GLOBALS['subscriber']);
									}

									$customer->Lastseen = time();

									$customer->Save();

									$ret->status = "success";
									$ret->data = "success";
									$ret->message = "Role saved";
								}
								else
								{
									$ret->status = "success";
									$ret->data = "failed";
									$ret->message = "Phone number exist already";
								}
							}
							else
							{
								$ret->status = "success";
								$ret->data = "failed";
								$ret->message = "Email exists already";
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