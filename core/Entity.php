<?php

	/*
		An Entity Could be 
		A Staff,
		An Admin User,
		A Customer
		A Guest
		Main Admin OR
		Guest   *guest*
	*/
	
	class  Entity
	{
	    public $Id = "";
		public $Type = "unknown";
		public $Value = null;
		
		
		function __construct($entity=null)
		{
			$this->Value = $entity;
			
			if($entity != null)
			{
				if(is_a($entity, "Customer"))
				{
					$this->Type = "customer";
				}
				if(is_a($entity, "User"))
				{
					$this->Type = "admin_user";
				}
                if(is_a($entity, "Staff"))
                {
                    $this->Type = "staff";
                }
				if(is_a($entity, "Guest"))
				{
					$this->Type = "guest";
				}
				if($entity === "admin_cox")
				{
					$this->Type = "main_admin";
				}
			}
		}


		public static function getUser(Subscriber $subscriber, $id, $type)
        {
            $ret = $id;

            switch ($type)
            {
                case "customer":
                    $ret = new Customer($subscriber);
                    $ret->Initialize($id);
                    break;
                case "staff":
                    $ret = new Staff($subscriber);
                    $ret->Initialize($id);
                    break;
                case "guest":
                    $ret = new Guest($subscriber);
                    $ret->Initialize($id);
                    break;
                case "subguest":
                    $ret = new Subguest($subscriber);
                    $ret->Initialize($id);
                    break;
                case "subscriber":
                    $ret = new Contact($subscriber);
                    $ret->Initialize($id);
                    break;
                case "message":
                    $ret = new Message($subscriber);
                    $ret->Initialize($id);
                    break;
                case "supplier":
                    $ret = new Supplier($subscriber);
                    $ret->Initialize($id);
                    break;
            }

            return $ret;
        }
	}