<?php


    class Subscriber
    {
		public $isValid = false;
        public $Key = "";
        public $Id = "";
        public $Name = "";
        public $Surname = "";
        public $Logo = "logo.png";
        public $Phone = "08012345678";
        public $Email = "hotel1@gmail.com";
        public $Address = "hotel2@hotmail.com";
        public $Domain = "centurion.com";
        public $Theme = "default";
        public $Color = "red";
        public $Currency = "ngn";
        public $Rates = 0;
        public $DatabaseName = "";
        public $DataBaseUser = "";
        public $DataBasepassword = "";
        public $RunningEnvironment = "";
        public $BusinessName = "";
        public $BusinessEmail = "";
        public $BusinessAddress = "";
        public $Country = "";
        public $CountryShort = "";
        public $ClientTheme = "";

        public $Smsunit = 0;

        public $AllowPRDelete = false;

        public $Phone1 = "";
        public $Phone2 = "";
        public $Email1 = "";
        public $Email2 = "";
        public $State = "";
        public $City = "";
        public $MessagingDomain = '';

		
		public $Attendancemethod = "fingerprint";

        public $HasImage = false;
        /**
         * @var UserType
         */
        public $Type = null;


        function __construct($databaseName="", $databaseUser="", $databasepassword="")
        {
            $site = new Site();
            $this->Currency = $site->Currency;
            $this->Phone1 = $site->Phone1;
            $this->Phone2 = $site->Phone2;
            $this->Email1 = $site->Email1;
            $this->Email2 = $site->Email2;

            // $this->DatabaseName = $databaseName;
            // $this->DataBaseUser = $databaseUser;
            // $this->DataBasepassword = $databasepassword;

            $this->MessagingDomain = Configuration::url()->messaging;
            $this->Key = '9050dsvdadsvebsrhfhsdgadysry';
        }


        public function GetDB()
        {
            if(($this->DataBasepassword == "") && ($this->DatabaseName == "") && ($this->DataBaseUser == ""))
            {
                return DB::GetDB();
            }
            else
            {
                return new mysqli("localhost", $this->DataBaseUser, $this->DataBasepassword, $this->DatabaseName);
            }
        }
    }