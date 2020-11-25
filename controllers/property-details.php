<?php

    $ret = new stdClass();
    $ret->data = new stdClass();
    $ret->data->property = Property::ByMeta($_REQUEST['property']);
    $ret->data->rooms = $ret->data->property->GetRoomCategories();
    $ret->data->property->Views += 1;
    $ret->data->property->Save();
    $ret->status = "success";
    $ret->message = "";

    echo json_encode($ret);

