<?php

	$ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Role->Messaging->ReadAccess)
        {
            $ret->status = "success";
            $ret->data = array();

            $page = $_REQUEST['Page'];
            $perpage = $_REQUEST['Perpage'];
            $filter = $_REQUEST['Filter'];
            $filtervalue = $_REQUEST['Filtervalue'];

            $store = array();

            $ret->Page = $page;
            $ret->Perpage = $perpage;


            //if($filter == "search list")
            //{
                $store = Review::All($GLOBALS['subscriber']);
            //}
            $ret->Total = count($store);

            $start = (($ret->Page - 1) * $ret->Perpage);
            $stop = (($start + $ret->Perpage) - 1);

            $x = 0;
            for($i = $start; $i < count($store); $i++)
            {
                $ret->data[$x] = $store[$i];
                if($i == $stop){break;}
                $x++;
            }

            $ret->Totalresponsecount = Reviewsession::Responsecount($GLOBALS['subscriber']);
            $ret->Totalsentreviews = Reviewsession::Sentcount($GLOBALS['subscriber']);

            $ret->status = "success";
            $ret->message = "Message retrieved successfully";


            $ret->Span = [];
            $span = Timespan::Monthspan(time())->splitSpan(20);

            for($i = 0; $i < count($span); $i++)
            {
                array_push($ret->Span, Reviewsession::Responseinspan($GLOBALS['subscriber'], $span[$i]->Start, $span[$i]->Stop));
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