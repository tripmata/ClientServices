<?php


    class Sms
    {
        public $From = "";
        public $To = "";
        public $Body = "";

        public static function Send(Subscriber $subscriber, Sms $sms)
        {
            return true;
        }
    }