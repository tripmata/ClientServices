<?php

	$ret = new stdClass();

					if($GLOBALS['user']->Id != "")
					{
                        

						if($GLOBALS['user']->Role->Settings->WriteAccess)
						{
							$site = new Site($GLOBALS['subscriber']);
							$site->PrimaryColor = $_REQUEST['primarycolor'];
							$site->SecondaryColor = $_REQUEST['secondarycolor'];
							$site->TextFont = $_REQUEST['primaryfont'];
							$site->SecondaryFont = $_REQUEST['secondaryfont'];
							$site->BoldFont = $_REQUEST['boldfont'];
							$site->LightFont = $_REQUEST['sleakfont'];
							$site->Save();

							$ret->status = "success";
							$ret->message = "Settings saved successfully";
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