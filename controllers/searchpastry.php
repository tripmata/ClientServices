<?php

	$ret = new stdClass();

                    $ret->status = "success";
                    $ret->success = true;
                    $ret->results = array();

                    $pastry = Pastry::Search($GLOBALS['subscriber'], $_REQUEST['q']);

                    for($i = 0; $i < count($pastry); $i++)
                    {
                        if(($pastry[$i]->Status) && ($pastry[$i]->Onsite))
                        {
                            $ret->results[$i] = new stdClass();
                            $ret->results[$i]->title = $pastry[$i]->Name;
                            $ret->results[$i]->name = $pastry[$i]->Name;
                            $ret->results[$i]->value = $pastry[$i]->Id;
                            $ret->results[$i]->description = $GLOBALS['subscriber']->Currency->Symbol.number_format($pastry[$i]->Price, 2);
                            if(count($pastry[$i]->Images))
                            {
                                $ret->results[$i]->image = Router::ResolvePath("maverick/files/".$pastry[$i]->Images[0], $path);
                            }
                            $ret->results[$i]->text = $pastry[$i]->Name;
                        }
                    }

	echo json_encode($ret);