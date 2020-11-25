<?php

    $ret = new stdClass();
    $ret->status = "success";
    $ret->data = [];

    $faq = Partnerfaq::Order($GLOBALS['subscriber'], 'sort', 'DESC');

    for($i = 0; $i < count($faq); $i++)
    {
        if($faq[$i]->Status === true)
        {
            array_push($ret->data, $faq[$i]);
        }
    }
    echo json_encode($ret);