<?php

	$ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        

        if ( ($GLOBALS['user']->Role->Staff->ReadAccess)
            || ($GLOBALS['user']->Role->Kitchenpos->ReadAccess) || ($GLOBALS['user']->Role->Frontdesk->ReadAccess)
            || ($GLOBALS['user']->Role->Laundrypos->ReadAccess) || ($GLOBALS['user']->Role->Bakerypos->ReadAccess)
            || ($GLOBALS['user']->Role->Poolpos->ReadAccess) || ($GLOBALS['user']->Role->Barpos->ReadAccess) )
        {
            $ret->status = "success";
            $ret->data = array();

            ////TODO:
            /// Change the customer::All be low to guest and add subguest

            $store = Customer::All($GLOBALS['subscriber']);
            for ($i = 0; $i < count($store); $i++)
            {
                $r = new stdClass();
                $r->Name = $store[$i]->Name . " " . $store[$i]->Surname;
                $r->Id = $store[$i]->Id;
                $ret->data[$i] = $r;
            }
        }
    }

	echo json_encode($ret);