<?php


    class Event
    {
        const CustomerAccountCreated = "109";
        const GuestCheckedIn = "101";
        const GuestCheckedOut = "102";
        const GuestStays25 = "103";
        const GuestStays50 = "104";
        const GuestStays75 = "105";
        const GuestStays100 = "106";
        const SaffLoggedIn = "107";
        const CustomerLoggedIn = "108";
        const CustomerCreatesAccount = "109";
        const StaffIsAdded = "201";
        const StaffSignsInAtTheHotel = "202";
        const ItsUsersBirthday = "203";
        const CustomerCompletesReservation = "204";
        const CustomerCancelsReservation = "205";
        const Day1ToCustomersArrival = "206";
        const Days2ToCustomersArrival = "207";
        const week1ToCustomersArrival = "208";
        const CouponIsUsed = "209";
        const StaffLogsOut = "301";
        const CustomerLogsOut = "302";
        const UserSendsMessage = "303";
        const GuestMakesOrderWhileLodging = "304";
        const UserCompletesReview = "305";
        const CustomerUpdatesInfo = "306";
        const GuestOrdersFoodWhileLodging = "307";
        const GuestOrdersDrinkWhileLodging = "308";
        const GuestOrdersPastryWhileLodging = "309";
        const GuestOrdersLaundryWhileLodging = "401";


        //internal Events
        const ItemIsOutOfStock = "010";
        const ItemIsLowStock = "020";
        const ItemIsAdded = "030";

        function __construct($eventname, Context $eventcontext)
        {

        }

        public static function Fire(Event $event)
        {

        }
    }