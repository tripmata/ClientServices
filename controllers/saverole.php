<?php

	$ret = new stdClass();

    if($GLOBALS['user']->Id != "")
    {
        if($GLOBALS['user']->Id == "adxc0")
        {
            $role = new Role(new Subscriber());
            $role->Initialize($_REQUEST['Roleid']);
            $role->Name = $_REQUEST['name'];
            

            $role->Booking = new Access();
            $role->Booking->ReadAccess = Convert::ToBool($_REQUEST['booking_read']);
            $role->Booking->WriteAccess = Convert::ToBool($_REQUEST['booking_write']);

            $role->Discount = new Access();
            $role->Discount->ReadAccess = Convert::ToBool($_REQUEST['coupon_read']);
            $role->Discount->WriteAccess = Convert::ToBool($_REQUEST['coupon_write']);

            $role->Customers = new Access();
            $role->Customers->ReadAccess = Convert::ToBool($_REQUEST['customer_read']);
            $role->Customers->WriteAccess = Convert::ToBool($_REQUEST['customer_write']);

            $role->Staff = new Access();
            $role->Staff->ReadAccess = Convert::ToBool($_REQUEST['staff_read']);
            $role->Staff->WriteAccess = Convert::ToBool($_REQUEST['staff_write']);

            $role->Rooms = new Access();
            $role->Rooms->ReadAccess = Convert::ToBool($_REQUEST['rooms_read']);
            $role->Rooms->WriteAccess = Convert::ToBool($_REQUEST['rooms_write']);

            $role->Kitchen = new Access();
            $role->Kitchen->ReadAccess = Convert::ToBool($_REQUEST['kitchen_read']);
            $role->Kitchen->WriteAccess = Convert::ToBool($_REQUEST['kitchen_write']);

            $role->Bakery = new Access();
            $role->Bakery->ReadAccess = Convert::ToBool($_REQUEST['bakery_read']);
            $role->Bakery->WriteAccess = Convert::ToBool($_REQUEST['bakery_write']);

            $role->Bar = new Access();
            $role->Bar->ReadAccess = Convert::ToBool($_REQUEST['bar_read']);
            $role->Bar->WriteAccess = Convert::ToBool($_REQUEST['bar_write']);

            $role->Laundry = new Access();
            $role->Laundry->ReadAccess = Convert::ToBool($_REQUEST['laundry_read']);
            $role->Laundry->WriteAccess = Convert::ToBool($_REQUEST['laundry_write']);

            $role->Housekeeping = new Access();
            $role->Housekeeping->ReadAccess = Convert::ToBool($_REQUEST['housekeeping_read']);
            $role->Housekeeping->WriteAccess = Convert::ToBool($_REQUEST['housekeeping_write']);

            $role->Pool = new Access();
            $role->Pool->ReadAccess = Convert::ToBool($_REQUEST['pool_read']);
            $role->Pool->WriteAccess = Convert::ToBool($_REQUEST['pool_write']);

            $role->Store = new Access();
            $role->Store->ReadAccess = Convert::ToBool($_REQUEST['store_read']);
            $role->Store->WriteAccess = Convert::ToBool($_REQUEST['store_write']);

            $role->Event = new Access();
            $role->Event->ReadAccess = Convert::ToBool($_REQUEST['event_read']);
            $role->Event->WriteAccess = Convert::ToBool($_REQUEST['event_write']);

            $role->Finance = new Access();
            $role->Finance->ReadAccess = Convert::ToBool($_REQUEST['finance_read']);
            $role->Finance->WriteAccess = Convert::ToBool($_REQUEST['finance_write']);

            $role->Branch = new Access();
            $role->Branch->ReadAccess = Convert::ToBool($_REQUEST['branch_read']);
            $role->Branch->WriteAccess = Convert::ToBool($_REQUEST['branch_write']);

            $role->Log = new Access();
            $role->Log->ReadAccess = Convert::ToBool($_REQUEST['log_read']);
            $role->Log->WriteAccess = Convert::ToBool($_REQUEST['log_write']);

            $role->Report = new Access();
            $role->Report->ReadAccess = Convert::ToBool($_REQUEST['reporting_read']);
            $role->Report->WriteAccess = Convert::ToBool($_REQUEST['reporting_write']);

            $role->Messaging = new Access();
            $role->Messaging->ReadAccess = Convert::ToBool($_REQUEST['messaging_read']);
            $role->Messaging->WriteAccess = Convert::ToBool($_REQUEST['messaging_write']);

            $role->Webfront = new Access();
            $role->Webfront->ReadAccess = Convert::ToBool($_REQUEST['webfront_read']);
            $role->Webfront->WriteAccess = Convert::ToBool($_REQUEST['webfront_write']);

            $role->Webconfig = new Access();
            $role->Webconfig->ReadAccess = Convert::ToBool($_REQUEST['webconfig_read']);
            $role->Webconfig->WriteAccess = Convert::ToBool($_REQUEST['webconfig_write']);

            $role->Settings = new Access();
            $role->Settings->ReadAccess = Convert::ToBool($_REQUEST['settings_read']);
            $role->Settings->WriteAccess = Convert::ToBool($_REQUEST['settings_write']);

            $role->Frontdesk = new Access();
            $role->Frontdesk->ReadAccess = Convert::ToBool($_REQUEST['frontdesk']);
            $role->Frontdesk->WriteAccess = Convert::ToBool($_REQUEST['frontdesk']);

            $role->Bakerypos = new Access();
            $role->Bakerypos->ReadAccess = Convert::ToBool($_REQUEST['bakery_pos']);
            $role->Bakerypos->WriteAccess = Convert::ToBool($_REQUEST['bakery_pos']);

            $role->Kitchenpos = new Access();
            $role->Kitchenpos->ReadAccess = Convert::ToBool($_REQUEST['kitchen_pos']);
            $role->Kitchenpos->WriteAccess = Convert::ToBool($_REQUEST['kitchen_pos']);

            $role->Poolpos = new Access();
            $role->Poolpos->ReadAccess = Convert::ToBool($_REQUEST['pools_pos']);
            $role->Poolpos->WriteAccess = Convert::ToBool($_REQUEST['pools_pos']);

            $role->Laundrypos = new Access();
            $role->Laundrypos->ReadAccess = Convert::ToBool($_REQUEST['laundry_pos']);
            $role->Laundrypos->WriteAccess = Convert::ToBool($_REQUEST['laundry_pos']);

            $role->Barpos = new Access();
            $role->Barpos->ReadAccess = Convert::ToBool($_REQUEST['bar_pos']);
            $role->Barpos->WriteAccess = Convert::ToBool($_REQUEST['bar_pos']);
            
            $role->Property = $_REQUEST['property'];

            $role->Save();

            $ret->status = "success";
            $ret->data = "success";
            $ret->message = "Role saved";
        }
        else
        {
            $ret->status = "access denied";
            $ret->message = "You do not have the required privilage to complete the operation";
        }
    }
    else
    {
        $ret->status = "login";
        $ret->data = "login";
    }
	echo json_encode($ret);