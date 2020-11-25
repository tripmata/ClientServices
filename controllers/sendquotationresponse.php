<?php

	$ret = new stdClass();


                    $session = new Quotationsession($GLOBALS['subscriber']);
                    $session->Initialize($_REQUEST['sessionid']);

                    $quotation = null;

                    if($session->Type == "kitchen_item")
                    {
                        $quotation = new Kitchenquotation($GLOBALS['subscriber']);
                    }
                    if($session->Type == "bar_item")
                    {
                        $quotation = new Barquotation($GLOBALS['subscriber']);
                    }
                    if($session->Type == "laundry_item")
                    {
                        $quotation = new Laundryquotation($GLOBALS['subscriber']);
                    }
                    if($session->Type == "pastry_item")
                    {
                        $quotation = new Pastryquotation($GLOBALS['subscriber']);
                    }
                    if($session->Type == "pool_item")
                    {
                        $quotation = new Poolquotation($GLOBALS['subscriber']);
                    }
                    if($session->Type == "room_item")
                    {
                        $quotation = new Roomquotation($GLOBALS['subscriber']);
                    }
                    if($session->Type == "store_item")
                    {
                        $quotation = new Storequotation($GLOBALS['subscriber']);
                    }
                    $quotation->Initialize($session->Quotation);

                    $x = explode(",", $_REQUEST['data']);

                    //clean data
                    $data = [];
                    for($i = 0; $i < count($x); $i++)
                    {
                        if($x[$i] != "")
                        {
                            array_push($data, $x[$i]);
                        }
                    }


                    for($i = 0; $i  < count($quotation->Items); $i++)
                    {
                        for($j = 0; $j < count($data); $j++)
                        {
                            $dv = explode(":", $data[$j]);

                            if(count($dv) == 2)
                            {
                                if($quotation->Items[$i]->Item->Id == $dv[0])
                                {
                                    $quotation->Items[$i]->addPrice($session->Supplier, $dv[1]);
                                    $quotation->Items[$i]->Save();
                                }
                            }
                        }
                    }

                    $session->Responded = true;
                    $session->Responsedate = time();
                    $session->Save();



                    $ret->status = "success";
                    $ret->message = "Response received";



	echo json_encode($ret);