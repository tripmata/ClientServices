<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->success = true;
                    $ret->results = array();

                    $food = Food::Search($GLOBALS['subscriber'], $_REQUEST['q']);

                    for($i = 0; $i < count($food); $i++)
                    {
                        if(($food[$i]->Status) && ($food[$i]->Onsite))
                        {
                            $ret->results[$i] = new stdClass();
                            $ret->results[$i]->title = $food[$i]->Name;
                            $ret->results[$i]->name = $food[$i]->Name;
                            $ret->results[$i]->value = $food[$i]->Id;
                            $ret->results[$i]->description = $GLOBALS['subscriber']->Currency->Symbol . number_format($food[$i]->Price, 2);
                            if (count($food[$i]->Images)) {
                                $ret->results[$i]->image = Router::ResolvePath("maverick/files/" . $food[$i]->Images[0], $path);
                            }
                            $ret->results[$i]->text = $food[$i]->Name;
                        }
                    }

	echo json_encode($ret);