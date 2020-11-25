<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->success = true;
                    $ret->results = array();

                    $drink = Drink::Search($GLOBALS['subscriber'], $_REQUEST['q']);

                    for($i = 0; $i < count($drink); $i++)
                    {
                        if(($drink[$i]->Status) && ($drink[$i]->Onsite))
                        {
                            $ret->results[$i] = new stdClass();
                            $ret->results[$i]->title = $drink[$i]->Name;
                            $ret->results[$i]->name = $drink[$i]->Name;
                            $ret->results[$i]->value = $drink[$i]->Id;
                            $ret->results[$i]->description = $GLOBALS['subscriber']->Currency->Symbol . number_format($drink[$i]->Price, 2);
                            if (count($drink[$i]->Images)) {
                                $ret->results[$i]->image = Router::ResolvePath("maverick/files/" . $drink[$i]->Images[0], $path);
                            }
                            $ret->results[$i]->text = $drink[$i]->Name;
                        }
                    }

	echo json_encode($ret);