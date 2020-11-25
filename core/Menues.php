<?php

    class Menues
    {
        private  $sub;
        private $menues = Array();

        function __construct(Subscriber $subscriber)
        {
            $this->sub = $subscriber;
        }

        public function UserCustom($user)
        {
            $ret = Array();

            return $ret;
        }

        public function AdminMenu()
        {
            $ret = Array();

            $id = $this->sub->Id;

            $res = DB::Query("SELECT * FROM features WHERE userid='$id'");

            if($res->num_rows > 0)
            {
                $row = $res->fetch_assoc();

                $ret[0] = json_decode($row['dashboard']);
                $ret[1] = json_decode($row['booking']);
                $ret[2] = json_decode($row['discount']);
                $ret[3] = json_decode($row['customers']);
                $ret[4] = json_decode($row['staffs']);
                $ret[5] = json_decode($row['rooms']);
                $ret[6] = json_decode($row['kitchen']);
                $ret[7] = json_decode($row['bakery']);
                $ret[8] = json_decode($row['bar']);
				$ret[9] = json_decode($row['laundry']);
                $ret[10] = json_decode($row['housekeeping']);
                $ret[11] = json_decode($row['pool']);
                $ret[12] = json_decode($row['store']);
                $ret[13] = json_decode($row['event']);
                $ret[14] = json_decode($row['finances']);
                $ret[15] = json_decode($row['branch']);
                $ret[16] = json_decode($row['log']);
                $ret[17] = json_decode($row['report']);
                $ret[18] = json_decode($row['messaging']);
                $ret[19] = json_decode($row['webfront']);
                $ret[20] = json_decode($row['webconfig']);
                $ret[21] = json_decode($row['settings']);
                $ret[22] = json_decode($row['admin']);
            }

            return $ret;
        }


        public function AddAllMenue()
        {
            $dashboard = new Menu();
            $dashboard->Name = "Dashboard";
            $dashboard->Active = true;
            $dashboard->Hash = "#dashboard";
            $dashboard->Icon = "tachometer alternate";
            $menu1 = json_encode($dashboard);


            $booking = new Menu();
            $booking->Name = "Booking";
            $booking->Active = true;
            $booking->Hash = "";
            $booking->Icon = "calendar alternate outline";
            $booking->SubMenu[0] = new Menu();
            $booking->SubMenu[0]->Name = "Reservations";
            $booking->SubMenu[0]->Active = true;
            $booking->SubMenu[0]->Hash = "#reservations";

            $booking->SubMenu[1] = new Menu();
            $booking->SubMenu[1]->Name = "Lodging";
            $booking->SubMenu[1]->Active = true;
            $booking->SubMenu[1]->Hash = "#lodging";

            $booking->SubMenu[2] = new Menu();
            $booking->SubMenu[2]->Name = "Guests";
            $booking->SubMenu[2]->Active = true;
            $booking->SubMenu[2]->Hash = "#guests";

            $booking->SubMenu[3] = new Menu();
            $booking->SubMenu[3]->Name = "Guests";
            $booking->SubMenu[3]->Active = true;
            $booking->SubMenu[3]->Hash = "#guests";

            $booking->SubMenu[3] = new Menu();
            $booking->SubMenu[3]->Name = "Frontdesk settings";
            $booking->SubMenu[3]->Active = true;
            $booking->SubMenu[3]->Hash = "#frontdesk-settings";

            $menu2 = json_encode($booking);


            $discount = new Menu();
            $discount->Name = "Discount";
            $discount->Active = true;
            $discount->Hash = "";
            $discount->Icon = "money bill alternate outline";
            $discount->SubMenu[0] = new Menu();
            $discount->SubMenu[0]->Name = "Discount";
            $discount->SubMenu[0]->Active = true;
            $discount->SubMenu[0]->Hash = "#discount";

            $discount->SubMenu[1] = new Menu();
            $discount->SubMenu[1]->Name = "Coupon";
            $discount->SubMenu[1]->Active = true;
            $discount->SubMenu[1]->Hash = "#coupon";
            $menu3 = json_encode($discount);



            $customer = new Menu();
            $customer->Name = "Customers";
            $customer->Hash = "";
            $customer->Active = true;
            $customer->Icon = "group";

            $customer->SubMenu[0] = new Menu();
            $customer->SubMenu[0]->Name = "All customers";
            $customer->SubMenu[0]->Active = true;
            $customer->SubMenu[0]->Hash = "#customers";

            $customer->SubMenu[1] = new Menu();
            $customer->SubMenu[1]->Name = "Add customer";
            $customer->SubMenu[1]->Active = true;
            $customer->SubMenu[1]->Hash = "#add-customer";

            $customer->SubMenu[2] = new Menu();
            $customer->SubMenu[2]->Name = "Customer Review";
            $customer->SubMenu[2]->Active = true;
            $customer->SubMenu[2]->Hash = "#customer-review";

            $menu4 = json_encode($customer);


            $staffs = new Menu();
            $staffs->Name = "Staff";
            $staffs->Active = true;
            $staffs->Hash = "";
            $staffs->Icon = "user circle";

            $staffs->SubMenu[0] = new Menu();
            $staffs->SubMenu[0]->Name = "Staff list";
            $staffs->SubMenu[0]->Active = true;
            $staffs->SubMenu[0]->Hash = "#staff";

			$staffs->SubMenu[1] = new Menu();
            $staffs->SubMenu[1]->Name = "Departments & Shifts";
            $staffs->SubMenu[1]->Active = true;
            $staffs->SubMenu[1]->Hash = "#staff-department-shift";

            $staffs->SubMenu[2] = new Menu();
            $staffs->SubMenu[2]->Name = "Attendance";
            $staffs->SubMenu[2]->Active = true;
            $staffs->SubMenu[2]->Hash = "#attendance";

			$staffs->SubMenu[3] = new Menu();
            $staffs->SubMenu[3]->Name = "Announcements";
            $staffs->SubMenu[3]->Active = true;
            $staffs->SubMenu[3]->Hash = "#announcement";

			$staffs->SubMenu[4] = new Menu();
            $staffs->SubMenu[4]->Name = "Polls";
            $staffs->SubMenu[4]->Active = true;
            $staffs->SubMenu[4]->Hash = "#staff-polls";

			$staffs->SubMenu[5] = new Menu();
            $staffs->SubMenu[5]->Name = "Leave";
            $staffs->SubMenu[5]->Active = true;
            $staffs->SubMenu[5]->Hash = "#staff-leave";

            $staffs->SubMenu[6] = new Menu();
            $staffs->SubMenu[6]->Name = "Bonuses";
            $staffs->SubMenu[6]->Active = true;
            $staffs->SubMenu[6]->Hash = "#staff-bonus";

            $staffs->SubMenu[7] = new Menu();
            $staffs->SubMenu[7]->Name = "Surcharge";
            $staffs->SubMenu[7]->Active = true;
            $staffs->SubMenu[7]->Hash = "#staff-surcharge";

			$staffs->SubMenu[8] = new Menu();
            $staffs->SubMenu[8]->Name = "Report";
            $staffs->SubMenu[8]->Active = true;
            $staffs->SubMenu[8]->Hash = "#staff-report";

            $menu5 = json_encode($staffs);


            $rooms = new Menu();
            $rooms->Name = "Rooms";
            $rooms->Hash = "";
            $rooms->Active = true;
            $rooms->Icon = "bed";

            $rooms->SubMenu[0] = new Menu();
            $rooms->SubMenu[0]->Name = "Room list";
            $rooms->SubMenu[0]->Hash = "#rooms";
            $rooms->SubMenu[0]->Active = true;

            $rooms->SubMenu[1] = new Menu();
            $rooms->SubMenu[1]->Name = "Room categories";
            $rooms->SubMenu[1]->Hash = "#room-categories";
            $rooms->SubMenu[1]->Active = true;

            $rooms->SubMenu[2] = new Menu();
            $rooms->SubMenu[2]->Name = "Room inventory";
            $rooms->SubMenu[2]->Hash = "#room-inventory";
            $rooms->SubMenu[2]->Active = true;

            $rooms->SubMenu[3] = new Menu();
            $rooms->SubMenu[3]->Name = "Room maintenance";
            $rooms->SubMenu[3]->Hash = "#room-maintainance";
            $rooms->SubMenu[3]->Active = true;

            $rooms->SubMenu[4] = new Menu();
            $rooms->SubMenu[4]->Name = "Extra services";
            $rooms->SubMenu[4]->Hash = "#extra-services";
            $rooms->SubMenu[4]->Active = true;

            $rooms->SubMenu[4] = new Menu();
            $rooms->SubMenu[4]->Name = "Report";
            $rooms->SubMenu[4]->Hash = "#room-report";
            $rooms->SubMenu[4]->Active = true;

            $menu6 = json_encode($rooms);


            $kitchen = new Menu();
            $kitchen->Name = "Kitchen";
            $kitchen->Hash = "";
            $kitchen->Active = true;
            $kitchen->Icon = "utensils";

            $kitchen->SubMenu[0] = new Menu();
            $kitchen->SubMenu[0]->Name = "Kitchen POS";
            $kitchen->SubMenu[0]->Hash = "#kitchen-pos";
            $kitchen->SubMenu[0]->Active = true;

            $kitchen->SubMenu[1] = new Menu();
            $kitchen->SubMenu[1]->Name = "Manage food";
            $kitchen->SubMenu[1]->Hash = "#food";
            $kitchen->SubMenu[1]->Active = true;

            $kitchen->SubMenu[2] = new Menu();
            $kitchen->SubMenu[2]->Name = "Inventory";
            $kitchen->SubMenu[2]->Hash = "#kitchen-inventory";
            $kitchen->SubMenu[2]->Active = true;

            $kitchen->SubMenu[3] = new Menu();
            $kitchen->SubMenu[3]->Name = "Report";
            $kitchen->SubMenu[3]->Hash = "#kitchen-report";
            $kitchen->SubMenu[3]->Active = true;

            $kitchen->SubMenu[4] = new Menu();
            $kitchen->SubMenu[4]->Name = "Settings";
            $kitchen->SubMenu[4]->Hash = "#kitchen-settings";
            $kitchen->SubMenu[4]->Active = true;

            $menu7 = json_encode($kitchen);



            $bakery = new Menu();
            $bakery->Name = "Bakery";
            $bakery->Hash = "";
            $bakery->Active = true;
            $bakery->Icon = "birthday cake";

            $bakery->SubMenu[0] = new Menu();
            $bakery->SubMenu[0]->Name = "Bakery POS";
            $bakery->SubMenu[0]->Hash = "#bakery";
            $bakery->SubMenu[0]->Active = true;

            $bakery->SubMenu[1] = new Menu();
            $bakery->SubMenu[1]->Name = "Manage pastries";
            $bakery->SubMenu[1]->Hash = "#pastries";
            $bakery->SubMenu[1]->Active = true;

            $bakery->SubMenu[2] = new Menu();
            $bakery->SubMenu[2]->Name = "Inventory";
            $bakery->SubMenu[2]->Hash = "#bakery-inventory";
            $bakery->SubMenu[2]->Active = true;

            $bakery->SubMenu[3] = new Menu();
            $bakery->SubMenu[3]->Name = "Report";
            $bakery->SubMenu[3]->Hash = "#bakery-report";
            $bakery->SubMenu[3]->Active = true;

            $bakery->SubMenu[4] = new Menu();
            $bakery->SubMenu[4]->Name = "Settings";
            $bakery->SubMenu[4]->Hash = "#bakery-settings";
            $bakery->SubMenu[4]->Active = true;

            $menu8 = json_encode($bakery);



            $bar = new Menu();
            $bar->Name = "Bar";
            $bar->Active = true;
            $bar->Hash = "";
            $bar->Icon = "glass martini icon";

            $bar->SubMenu[0] = new Menu();
            $bar->SubMenu[0]->Name = "Bar POS";
            $bar->SubMenu[0]->Hash = "#bar";
            $bar->SubMenu[0]->Active = true;

            $bar->SubMenu[1] = new Menu();
            $bar->SubMenu[1]->Name = "Manage drinks";
            $bar->SubMenu[1]->Hash = "#bar-drinks";
            $bar->SubMenu[1]->Active = true;

            $bar->SubMenu[2] = new Menu();
            $bar->SubMenu[2]->Name = "Inventory";
            $bar->SubMenu[2]->Hash = "#bar-inventory";
            $bar->SubMenu[2]->Active = true;

            $bar->SubMenu[3] = new Menu();
            $bar->SubMenu[3]->Name = "Report";
            $bar->SubMenu[3]->Hash = "#bar-report";
            $bar->SubMenu[3]->Active = true;

            $bar->SubMenu[4] = new Menu();
            $bar->SubMenu[4]->Name = "Settings";
            $bar->SubMenu[4]->Hash = "#bar-settings";
            $bar->SubMenu[4]->Active = true;
            $menu9 = json_encode($bar);



            $laundry = new Menu();
            $laundry->Name = "Laundry";
            $laundry->Hash = "";
            $laundry->Active = true;
            $laundry->Icon = "industry";

            $laundry->SubMenu[0] = new Menu();
            $laundry->SubMenu[0]->Name = "Laundry POS";
            $laundry->SubMenu[0]->Hash = "#laundry";
            $laundry->SubMenu[0]->Active = true;

            $laundry->SubMenu[1] = new Menu();
            $laundry->SubMenu[1]->Name = "Inventory";
            $laundry->SubMenu[1]->Hash = "#laundry-inventory";
            $laundry->SubMenu[1]->Active = true;

            $laundry->SubMenu[2] = new Menu();
            $laundry->SubMenu[2]->Name = "Report";
            $laundry->SubMenu[2]->Hash = "#laundry-report";
            $laundry->SubMenu[2]->Active = true;

            $laundry->SubMenu[3] = new Menu();
            $laundry->SubMenu[3]->Name = "Settings";
            $laundry->SubMenu[3]->Hash = "#laundry-settings";
            $laundry->SubMenu[3]->Active = true;

            $menu10 = json_encode($laundry);


            $housekeeping = new Menu();
            $housekeeping->Name = "House keeping";
            $housekeeping->Active = false;
            $housekeeping->Hash = "";
            $housekeeping->Icon = "male";

            $housekeeping->SubMenu[0] = new Menu();
            $housekeeping->SubMenu[0]->Name = "Printer";
            $housekeeping->SubMenu[0]->Active = false;
            $housekeeping->SubMenu[0]->Hash = "#printer";

            $housekeeping->SubMenu[1] = new Menu();
            $housekeeping->SubMenu[1]->Name = "Sales agent";
            $housekeeping->SubMenu[1]->Active = false;
            $housekeeping->SubMenu[1]->Hash = "#sales-agent";

            $housekeeping->SubMenu[2] = new Menu();
            $housekeeping->SubMenu[2]->Name = "Print store branch";
            $housekeeping->SubMenu[2]->Active = false;
            $housekeeping->SubMenu[2]->Hash = "#branch";
            $menu11 = json_encode($housekeeping);


            $pool = new Menu();
            $pool->Name = "Pool";
            $pool->Hash = "";
            $pool->Active = true;
            $pool->Icon = "life ring outline";
            $pool->SubMenu[0] = new Menu();
			$pool->SubMenu[0]->Name = "Pool POS";
			$pool->SubMenu[0]->Hash = "#pool";
			$pool->SubMenu[0]->Active = true;

            $pool->SubMenu[1] = new Menu();
            $pool->SubMenu[1]->Name = "Inventory";
            $pool->SubMenu[1]->Hash = "#pool-inventory";
            $pool->SubMenu[1]->Active = true;


            $pool->SubMenu[2] = new Menu();
			$pool->SubMenu[2]->Name = "Report";
			$pool->SubMenu[2]->Hash = "#pool-report";
			$pool->SubMenu[2]->Active = true;

			$pool->SubMenu[3] = new Menu();
			$pool->SubMenu[3]->Name = "Settings";
			$pool->SubMenu[3]->Hash = "#pool-settings";
			$pool->SubMenu[3]->Active = true;
            $menu12 = json_encode($pool);



            $store = new Menu();
            $store->Name = "Store";
            $store->Active = true;
            $store->Hash = "";
            $store->Icon = "archive";

            $store->SubMenu[0] = new Menu();
            $store->SubMenu[0]->Name = "Products overview";
            $store->SubMenu[0]->Active = true;
            $store->SubMenu[0]->Hash = "#store-inventory";

            $store->SubMenu[1] = new Menu();
            $store->SubMenu[1]->Name = "Product timeline";
            $store->SubMenu[1]->Active = true;
            $store->SubMenu[1]->Hash = "#store-product-timeline";

            $store->SubMenu[2] = new Menu();
            $store->SubMenu[2]->Name = "Purchase request";
            $store->SubMenu[2]->Active = true;
            $store->SubMenu[2]->Hash = "#store-purchase-request";

            $store->SubMenu[3] = new Menu();
            $store->SubMenu[3]->Name = "Quotation request";
            $store->SubMenu[3]->Active = true;
            $store->SubMenu[3]->Hash = "#store-price-enquiry";

            $store->SubMenu[4] = new Menu();
            $store->SubMenu[4]->Name = "Auditing";
            $store->SubMenu[4]->Active = true;
            $store->SubMenu[4]->Hash = "#store-inventory-auditing";

            $store->SubMenu[5] = new Menu();
            $store->SubMenu[5]->Name = "Suppliers";
            $store->SubMenu[5]->Active = true;
            $store->SubMenu[5]->Hash = "#suppliers";

            $store->SubMenu[6] = new Menu();
            $store->SubMenu[6]->Name = "Inventory report";
            $store->SubMenu[6]->Active = true;
            $store->SubMenu[6]->Hash = "#store-report";

            $menu13 = json_encode($store);



            $event = new Menu();
            $event->Name = "Event";
            $event->Hash = "";
            $event->Active = false;
            $event->Icon = "calendar";
            $event->SubMenu[0] = new Menu();
            $event->SubMenu[0]->Name = "Event POS";
            $event->SubMenu[0]->Hash = "#event-pos";
            $event->SubMenu[0]->Active = false;

            $event->SubMenu[1] = new Menu();
            $event->SubMenu[1]->Name = "Manage event";
            $event->SubMenu[1]->Hash = "#manage-event";
            $event->SubMenu[1]->Active = false;

            $event->SubMenu[2] = new Menu();
            $event->SubMenu[2]->Name = "Inventory";
            $event->SubMenu[2]->Hash = "#event-inventory";
            $event->SubMenu[2]->Active = false;

            $event->SubMenu[3] = new Menu();
            $event->SubMenu[3]->Name = "Report";
            $event->SubMenu[3]->Hash = "#event-report";
            $event->SubMenu[3]->Active = false;

            $event->SubMenu[4] = new Menu();
            $event->SubMenu[4]->Name = "Settings";
            $event->SubMenu[4]->Hash = "#event-settings";
            $event->SubMenu[4]->Active = false;
            $menu14 = json_encode($event);



            $finances = new Menu();
            $finances->Name = "Finances";
            $finances->Hash = "";
            $finances->Active = true;
            $finances->Icon = "money";
            $finances->SubMenu[0] = new Menu();
            $finances->SubMenu[0]->Name = "Accounts";
            $finances->SubMenu[0]->Active = true;
            $finances->SubMenu[0]->Hash = "#accounts";

            $finances->SubMenu[1] = new Menu();
            $finances->SubMenu[1]->Name = "Payroll";
            $finances->SubMenu[1]->Active = true;
            $finances->SubMenu[1]->Hash = "#payroll";

            $finances->SubMenu[2] = new Menu();
            $finances->SubMenu[2]->Name = "Invoices / Expenses";
            $finances->SubMenu[2]->Active = true;
            $finances->SubMenu[2]->Hash = "#invoices";//"#customers-finances";

            $finances->SubMenu[3] = new Menu();
            $finances->SubMenu[3]->Name = "Transactions";
            $finances->SubMenu[3]->Active = true;
            $finances->SubMenu[3]->Hash = "#transactions";//"#partners-finances";

            $finances->SubMenu[4] = new Menu();
            $finances->SubMenu[4]->Name = "Report";
            $finances->SubMenu[4]->Active = true;
            $finances->SubMenu[4]->Hash = "#report";//"#finances-log";
            $menu15 = json_encode($finances);



			$branch = new Menu();
            $branch->Name = "Branch";
            $branch->Hash = "";
            $branch->Active = false;
            $branch->Icon = "building";
            $branch->SubMenu[0] = new Menu();
            $branch->SubMenu[0]->Name = "Manage branch";
            $branch->SubMenu[0]->Active = true;
            $branch->SubMenu[0]->Hash = "#manage-branch";

            $branch->SubMenu[1] = new Menu();
            $branch->SubMenu[1]->Name = "Add branch";
            $branch->SubMenu[1]->Active = true;
            $branch->SubMenu[1]->Hash = "#add-branch";
            $menu16 = json_encode($branch);



			$report = new Menu();
            $report->Name = "Report";
            $report->Hash = "";
            $report->Active = true;
            $report->Icon = "pie chart";


            $report->SubMenu[0] = new Menu();
            $report->SubMenu[0]->Name = "Products & Sales";
            $report->SubMenu[0]->Active = true;
            $report->SubMenu[0]->Hash = "#sales-report";

            $report->SubMenu[1] = new Menu();
            $report->SubMenu[1]->Name = "Finances";
            $report->SubMenu[1]->Active = true;
            $report->SubMenu[1]->Hash = "#financial-report";

            $report->SubMenu[2] = new Menu();
            $report->SubMenu[2]->Name = "Customers";
            $report->SubMenu[2]->Active = true;
            $report->SubMenu[2]->Hash = "#customers-report";

            $report->SubMenu[3] = new Menu();
            $report->SubMenu[3]->Name = "General report";
            $report->SubMenu[3]->Active = true;
            $report->SubMenu[3]->Hash = "#general-report";

            $report->SubMenu[4] = new Menu();
            $report->SubMenu[4]->Name = "Business Analytics";
            $report->SubMenu[4]->Active = true;
            $report->SubMenu[4]->Hash = "#report-analytics";

            $menu17 = json_encode($report);




			$log = new Menu();
            $log->Name = "Log";
            $log->Hash = "";
            $log->Active = true;
            $log->Icon = "bug";

            $log->SubMenu[0] = new Menu();
            $log->SubMenu[0]->Name = "Event log";
            $log->SubMenu[0]->Active = true;
            $log->SubMenu[0]->Hash = "#event-log";

            $log->SubMenu[1] = new Menu();
            $log->SubMenu[1]->Name = "System log";
            $log->SubMenu[1]->Active = true;
            $log->SubMenu[1]->Hash = "#system-log";

            $log->SubMenu[2] = new Menu();
            $log->SubMenu[2]->Name = "Reminder";
            $log->SubMenu[2]->Active = false;
            $log->SubMenu[2]->Hash = "#reminder-log";



            $menu18 = json_encode($log);




			$payment = new Menu();
            $payment->Name = "payments";
            $payment->Hash = "";
            $payment->Active = false;
            $payment->Icon = "credit card outline";


            $payment->SubMenu[0] = new Menu();
            $payment->SubMenu[0]->Name = "Sales";
            $payment->SubMenu[0]->Active = true;
            $payment->SubMenu[0]->Hash = "#sales-payment";

            $payment->SubMenu[1] = new Menu();
            $payment->SubMenu[1]->Name = "Product";
            $payment->SubMenu[1]->Active = true;
            $payment->SubMenu[1]->Hash = "#product-payment";

            $payment->SubMenu[2] = new Menu();
            $payment->SubMenu[2]->Name = "Customers";
            $payment->SubMenu[2]->Active = true;
            $payment->SubMenu[2]->Hash = "";//"#customers-payment";

            $payment->SubMenu[3] = new Menu();
            $payment->SubMenu[3]->Name = "Partners";
            $payment->SubMenu[3]->Active = true;
            $payment->SubMenu[3]->Hash = "";//"#partners-payment";

            $payment->SubMenu[4] = new Menu();
            $payment->SubMenu[4]->Name = "Log";
            $payment->SubMenu[4]->Active = true;
            $payment->SubMenu[4]->Hash = "";//"#payment-log";

            $menu19 = json_encode($payment);





			$messaging = new Menu();
            $messaging->Name = "Messaging";
            $messaging->Hash = "";
            $messaging->Active = true;
            $messaging->Icon = "envelope open";


            $messaging->SubMenu[0] = new Menu();
            $messaging->SubMenu[0]->Name = "Messages Template";
            $messaging->SubMenu[0]->Active = true;
            $messaging->SubMenu[0]->Hash = "#messages-template";

            $messaging->SubMenu[1] = new Menu();
            $messaging->SubMenu[1]->Name = "Contact list";
            $messaging->SubMenu[1]->Active = true;
            $messaging->SubMenu[1]->Hash = "#contact-list";

            $messaging->SubMenu[2] = new Menu();
            $messaging->SubMenu[2]->Name = "Send Messages";
            $messaging->SubMenu[2]->Active = true;
            $messaging->SubMenu[2]->Hash = "#send-messages";

            $messaging->SubMenu[3] = new Menu();
            $messaging->SubMenu[3]->Name = "Scheduler";
            $messaging->SubMenu[3]->Active = true;
            $messaging->SubMenu[3]->Hash = "#reminders";

            $messaging->SubMenu[4] = new Menu();
            $messaging->SubMenu[4]->Name = "Received message";
            $messaging->SubMenu[4]->Active = true;
            $messaging->SubMenu[4]->Hash = "#received-message";

            $messaging->SubMenu[5] = new Menu();
            $messaging->SubMenu[5]->Name = "Message settings";
            $messaging->SubMenu[5]->Active = true;
            $messaging->SubMenu[5]->Hash = "#message-settings";

            $menu20 = json_encode($messaging);





			$webfront = new Menu();
            $webfront->Name = "Web front";
            $webfront->Hash = "";
            $webfront->Active = true;
            $webfront->Icon = "code";


            $webfront->SubMenu[0] = new Menu();
            $webfront->SubMenu[0]->Name = "Themes";
            $webfront->SubMenu[0]->Active = true;
            $webfront->SubMenu[0]->Hash = "#themes";

            $webfront->SubMenu[1] = new Menu();
            $webfront->SubMenu[1]->Name = "Banners";
            $webfront->SubMenu[1]->Active = true;
            $webfront->SubMenu[1]->Hash = "#banners";

            $webfront->SubMenu[2] = new Menu();
            $webfront->SubMenu[2]->Name = "FAQ";
            $webfront->SubMenu[2]->Active = true;
            $webfront->SubMenu[2]->Hash = "#faq";

            $webfront->SubMenu[3] = new Menu();
            $webfront->SubMenu[3]->Name = "Content";
            $webfront->SubMenu[3]->Active = true;
            $webfront->SubMenu[3]->Hash = "#web-content";

            $menu21 = json_encode($webfront);


			$webconfig = new Menu();
            $webconfig->Name = "Web config";
            $webconfig->Hash = "";
            $webconfig->Active = true;
            $webconfig->Icon = "wrench";

            $webconfig->SubMenu[0] = new Menu();
            $webconfig->SubMenu[0]->Name = "Integrations";
            $webconfig->SubMenu[0]->Active = true;
            $webconfig->SubMenu[0]->Hash = "#integrations";

            $webconfig->SubMenu[1] = new Menu();
            $webconfig->SubMenu[1]->Name = "SEO";
            $webconfig->SubMenu[1]->Active = true;
            $webconfig->SubMenu[1]->Hash = "#seo";

            $webconfig->SubMenu[2] = new Menu();
            $webconfig->SubMenu[2]->Name = "Currency & payment";
            $webconfig->SubMenu[2]->Active = true;
            $webconfig->SubMenu[2]->Hash = "#currency-payment";

			$webconfig->SubMenu[3] = new Menu();
            $webconfig->SubMenu[3]->Name = "promotional content";
            $webconfig->SubMenu[3]->Active = false;
            $webconfig->SubMenu[3]->Hash = "#promotional-content";

            $menu22 = json_encode($webconfig);





			$settings = new Menu();
            $settings->Name = "Settings";
            $settings->Hash = "";
            $settings->Active = true;
            $settings->Icon = "cog";


            $settings->SubMenu[0] = new Menu();
            $settings->SubMenu[0]->Name = "General settings";
            $settings->SubMenu[0]->Active = true;
            $settings->SubMenu[0]->Hash = "#general-setting";

			$settings->SubMenu[1] = new Menu();
            $settings->SubMenu[1]->Name = "Modules";
            $settings->SubMenu[1]->Active = true;
            $settings->SubMenu[1]->Hash = "#modules";

            $settings->SubMenu[2] = new Menu();
            $settings->SubMenu[2]->Name = "Terms & Conditions";
            $settings->SubMenu[2]->Active = true;
            $settings->SubMenu[2]->Hash = "#t&c";

            $settings->SubMenu[3] = new Menu();
            $settings->SubMenu[3]->Name = "Privacy Policy";
            $settings->SubMenu[3]->Active = true;
            $settings->SubMenu[3]->Hash = "#privacy-policy";

            $menu23 = json_encode($settings);


            $admin = new Menu();
            $admin->Active = true;
            $admin->Hash = "";
            $admin->Name = "Admin";
            $admin->Icon = "unlock";

            $admin->SubMenu[0] = new Menu();
            $admin->SubMenu[0]->Name = "Security";
            $admin->SubMenu[0]->Active = true;
            $admin->SubMenu[0]->Hash = "#security";

            $admin->SubMenu[1] = new Menu();
            $admin->SubMenu[1]->Name = "Admin users";
            $admin->SubMenu[1]->Active = true;
            $admin->SubMenu[1]->Hash = "#admin-users";

            $admin->SubMenu[2] = new Menu();
            $admin->SubMenu[2]->Name = "Admin group role";
            $admin->SubMenu[2]->Active = true;
            $admin->SubMenu[2]->Hash = "#admin-group-role";

            $menu24 = json_encode($admin);

            $id = $this->sub->Id;

            if(DB::Query("SELECT userid FROM features WHERE userid='$id'")->num_rows > 0)
            {
                DB::Query("UPDATE features SET dashboard='$menu1',booking='$menu2',
				discount='$menu3',customers='$menu4',staffs='$menu5',rooms='$menu6',kitchen='$menu7',bakery='$menu8',bar='$menu9',laundry='$menu10',
				housekeeping='$menu11',pool='$menu12',store='$menu13',event='$menu14',finances='$menu15',branch='$menu16',report='$menu17',log='$menu18',
				payments='$menu19',messaging='$menu20',webfront='$menu21',webconfig='$menu22',settings='$menu23',admin='$menu24' WHERE userid='$id'");
            }
            else
            {
                DB::Query("INSERT INTO features(userid,dashboard,booking,discount,customers,
				staffs,rooms,kitchen,bakery,bar,laundry,housekeeping,pool,store,event,finances,
				branch,report,log,payments,messaging,webfront,webconfig,settings,admin)VALUES
                ('$id','$menu1','$menu2','$menu3','$menu4','$menu5','$menu6','$menu7','$menu8','$menu9','$menu10','$menu11'
                ,'$menu12','$menu13','$menu14','$menu15','$menu16','$menu17','$menu18','$menu19','$menu20','$menu21'
				,'$menu22','$menu23','$menu24')");
            }
        }

        public  function  ByRole(Role $role)
        {
            $menu = $this->AdminMenu();

            if(!$role->Booking->ReadAccess)
            {
                $menu[1]->Active = false;
            }
            if(!$role->Discount->ReadAccess)
            {
                $menu[2]->Active = false;
            }
            if(!$role->Customers->ReadAccess)
            {
                $menu[3]->Active = false;
            }
            if(!$role->Staff->ReadAccess)
            {
                $menu[4]->Active = false;
            }
            if(!$role->Rooms->ReadAccess)
            {
                $menu[5]->Active = false;
            }
            if(!$role->Kitchen->ReadAccess)
            {
                $menu[6]->Active = false;
            }
            if(!$role->Bakery->ReadAccess)
            {
                $menu[7]->Active = false;
            }
            if(!$role->Bar->ReadAccess)
            {
                $menu[8]->Active = false;
            }
            if(!$role->Laundry->ReadAccess)
            {
                $menu[9]->Active = false;
            }
            if(!$role->Housekeeping->ReadAccess)
            {
                $menu[10]->Active = false;
            }
            if(!$role->Pool->ReadAccess)
            {
                $menu[11]->Active = false;
            }
            if(!$role->Store->ReadAccess)
            {
                $menu[12]->Active = false;
            }
            if(!$role->Event->ReadAccess)
            {
                $menu[13]->Active = false;
            }
            if(!$role->Finance->ReadAccess)
            {
                $menu[14]->Active = false;
            }
            if(!$role->Branch->ReadAccess)
            {
                $menu[15]->Active = false;
            }
            if(!$role->Log->ReadAccess)
            {
                $menu[16]->Active = false;
            }
            if(!$role->Report->ReadAccess)
            {
                $menu[17]->Active = false;
            }
            if(!$role->Messaging->ReadAccess)
            {
                $menu[18]->Active = false;
            }
            if(!$role->Webfront->ReadAccess)
            {
                $menu[19]->Active = false;
            }
            if(!$role->Webconfig->ReadAccess)
            {
                $menu[20]->Active = false;
            }
            if(!$role->Settings->ReadAccess)
            {
                $menu[21]->Active = false;
            }

            $menu[22]->SubMenu[1]->Active = false;
            $menu[22]->SubMenu[2]->Active = false;


            return $menu;
        }
    }