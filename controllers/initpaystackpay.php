<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        



                        if($GLOBALS['user']->Role->Barpos->ReadAccess)
                            || ($GLOBALS['user']->Role->Kitchenpos->ReadAccess) || ($GLOBALS['user']->Role->Laundrypos->ReadAccess)
                            || ($GLOBALS['user']->Role->Bakerypos->ReadAccess)|| ($GLOBALS['user']->Role->Poolpos->ReadAccess)
                        {
                            if(doubleval($_REQUEST['amount']) > 0)
                            {
                                $payment = new Paygateway($GLOBALS['subscriber']);

                                $ret->status = "success";
                                $ret->data = new stdClass();
                                $ret->data->Currency = $GLOBALS['subscriber']->Currency->Code;
                                $ret->data->Amount = (doubleval($_REQUEST['amount'])) * 100;
                                $ret->data->Email = $GLOBALS['subscriber']->Email;
                                $ret->data->Key = $payment->Paystackpublic;
                                $ret->Method = "PAYSTACK";
                                $ret->data->Ref = Random::GenerateId(10);
                            }
                            else
                            {
                                $ret->data = null;
                                $ret->status = "failed";
                                $ret->message = "Invalid amount. Enter a valid amount and try again";
                            }
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
                        $ret->data = "login & try again";
                    }


	echo json_encode($ret);