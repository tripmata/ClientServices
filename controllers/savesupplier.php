<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if($GLOBALS['user']->Role->Messaging->ReadAccess)
                        {
                            $supplier = new Supplier($GLOBALS['subscriber']);
                            $supplier->Initialize($_REQUEST['id']);
                            $supplier->Company = $_REQUEST['company'];
                            $supplier->Phone = $_REQUEST['phone'];
                            $supplier->Email = $_REQUEST['email'];
                            $supplier->Contactperson = $_REQUEST['name']." ".$_REQUEST['surname'];
                            $supplier->Address = $_REQUEST['address'];
                            $supplier->Save();

                            $ret->data = null;
                            $ret->status = "success";
                            $ret->message = "Supplier saved";
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