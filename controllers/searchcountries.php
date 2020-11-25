<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->success = true;
                    $ret->results = array();

                    $countries = Country::Search($_REQUEST['q']);

                    for($i = 0; $i < count($countries); $i++)
                    {
                        $ret->results[$i] = new stdClass();
                        $ret->results[$i]->name = $countries[$i]->Name;
                        $ret->results[$i]->value = $countries[$i]->Code;
                        $ret->results[$i]->text = $countries[$i]->Name;
                    }

	echo json_encode($ret);