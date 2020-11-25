<?php

	$ret = new stdClass();

                    if($GLOBALS['user']->Id != "")
                    {
                        

                        if ($GLOBALS['user']->Role->Staff->ReadAccess)
                        {
                            $ret->status = "success";
                            $ret->data = array();

                            $suppliers = Supplier::All($GLOBALS['subscriber']);
                            for ($i = 0; $i < count($suppliers); $i++)
                            {
                                $r = new stdClass();
                                $r->Name = $suppliers[$i]->Company != "" ? $suppliers[$i]->Company : $suppliers[$i]->Contactperson;
                                $r->Id = $suppliers[$i]->Id;
                                $ret->data[$i] = $r;
                            }
                        }
                    }

	echo json_encode($ret);