<?php

    $ret = new stdClass();
    $ret->status = "success";
    $ret->data = new stdClass();

    $ret->data->site = new Site();
    $ret->data->banner = Banner::All($GLOBALS['subscriber']);
    $ret->data->testimonial = Testimonial::All($GLOBALS['subscriber']);
    $ret->data->integrations = new Integration($GLOBALS['subscriber']);
    $ret->data->banner = Banner::Order($GLOBALS['subscriber'], 'sort', 'ASC');
    $ret->data->testimonial = Testimonial::Order($GLOBALS['subscriber'], 'sort', 'ASC');
    $ret->data->gallery = Gallery::Order($GLOBALS['subscriber'], 'sort', 'ASC');
    $ret->data->propertyCount = Property::countActiveListing();

    $ret->data->customer = null;

    if($_REQUEST['customer'])
    {
        if($_REQUEST['customer'] != "")
        {
            if(Session::Exist($_REQUEST['customer']))
            {
                $session = Session::Get($_REQUEST['customer']);
                $ret->data->customer = new Customer($GLOBALS['subscriber']);
                $ret->data->customer->Initialize($session->User);
            }
        }
    }


    echo json_encode($ret);