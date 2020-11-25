<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->data = array();
                    $i = 0;

                    $curr = Currency::GroupInitialize(null);

                    for($j = 0; $j < count($curr); $j++)
                    {
                        if($curr[$j]->Name != "")
                        {
                            $ret->data[$i] = new stdClass();
                            if($curr[$j]->Symbol != "")
                            {
                                $ret->data[$i]->Name = $curr[$j]->Name." - (".$curr[$j]->Symbol.")";
                            }
                            else
                            {
                                $ret->data[$i]->Name = $curr[$j]->Name." - (".$curr[$j]->Code.")";
                            }
                            $ret->data[$i]->Id = $curr[$j]->Code;
                            $i++;
                        }
                    }

	echo json_encode($ret);