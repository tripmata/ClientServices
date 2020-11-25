<?php

	class Invoice
	{
		public $Id = "";
		
		/**
		#param Entity
		**/
		public $InvoiceHolder = null;
		
		public $Items = array();

		private $subscriber = null;

		function __construct(Subscriber $subscriber)
        {
            $this->subscriber = $subscriber;
        }

        public function Initialize($arg=null)
        {

        }

        function __function()
		{
			
		}
		
		public function Paid()
		{
			
		}
	}