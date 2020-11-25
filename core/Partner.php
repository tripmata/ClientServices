<?php
	/* Generated by Wixnit Class Builder 
	// Apr, 06/2020
	// Building class for Partner
	*/

	class Partner
	{
		public $Id = "";
		public $Created = 0;
		public $Salutation = "";
		public $Name = "";
		public $Surname = "";
		public $Phone = "";
		public $Email = "";
		public $Password = "";
		public $Profilepic = "";
		public $Gender = "";
		public $Country = "";
		public $State = "";
		public $City = "";
		public $Address = "";
		public $Status = false;

		public $Bank = "";
		public $AccountNumber = "";
		public $AccountName = "";

		public $Type = "partner";

		function __construct($arg=null)
		{
			if($arg != null)
			{
				$db = DB::GetDB();

				$res = $db->query("SELECT * FROM partner WHERE partnerid='$arg'");

				if($res->num_rows > 0)
				{
					$row = $res->fetch_assoc();
				
					$this->Id = $row['partnerid'];
					$this->Created = new WixDate($row['created']);
					$this->Salutation = $row['salutation'];
					$this->Name = $row['name'];
					$this->Surname = $row['surname'];
					$this->Phone = $row['phone'];
					$this->Email = $row['email'];
					$this->Password = $row['password'];
					$this->Profilepic = $row['profilepic'];
					$this->Gender = $row['gender'];
					$this->Country = $row['country'];
					$this->State = $row['state'];
					$this->City = $row['city'];
					$this->Address = $row['address'];
					$this->Status = Convert::ToBool($row['status']);

					$this->Bank = $row['bank'];
					$this->AccountName = $row['accountname'];
					$this->AccountNumber = $row['accountnumber'];
				}
			}
		}

		public function Save()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$created = time();
			$salutation = addslashes($this->Salutation);
			$name = addslashes($this->Name);
			$surname = addslashes($this->Surname);
			$phone = addslashes($this->Phone);
			$email = addslashes($this->Email);
			$password = addslashes($this->Password);
			$profilepic = addslashes($this->Profilepic);
			$gender = addslashes($this->Gender);
			$country = addslashes($this->Country);
			$state = addslashes($this->State);
			$city = addslashes($this->City);
			$address = addslashes($this->Address);
			$status = Convert::ToInt($this->Status);

            $bank = $this->Bank;
            $accountName = $this->AccountName;
            $accountNumber = $this->AccountNumber;

			if($res = $db->query("SELECT partnerid FROM partner WHERE partnerid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE partner SET salutation='$salutation',name='$name',surname='$surname',phone='$phone',email='$email',password='$password',profilepic='$profilepic',gender='$gender',country='$country',state='$state',city='$city',address='$address',status='$status',bank='$bank',accountname='$accountName',accountnumber='$accountNumber' WHERE partnerid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT partnerid FROM partner WHERE partnerid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO partner(partnerid,created,salutation,name,surname,phone,email,password,profilepic,gender,country,state,city,address,status,bank,accountname,accountnumber) VALUES ('$id','$created','$salutation','$name','$surname','$phone','$email','$password','$profilepic','$gender','$country','$state','$city','$address','$status','$bank','$accountName','$accountNumber')");
			}
		}

		public function Delete()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM partner WHERE partnerid='$id'");
		}

		public static function Search($term='')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT partnerid FROM partner WHERE salutation LIKE '%$term%' OR name LIKE '%$term%' OR surname LIKE '%$term%' OR phone LIKE '%$term%' OR email LIKE '%$term%' OR password LIKE '%$term%' OR profilepic LIKE '%$term%' OR gender LIKE '%$term%' OR country LIKE '%$term%' OR state LIKE '%$term%' OR city LIKE '%$term%' OR address LIKE '%$term%' OR status LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Partner($row['partnerid']);
				$i++;
			}
			return $ret;
		}

		public static function Filter($term='', $field='partnerid')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT partnerid FROM partner WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Partner($row['partnerid']);
				$i++;
			}
			return $ret;
		}

		public static function Order($field='id', $order='DESC')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT partnerid FROM partner ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Partner($row['partnerid']);
				$i++;
			}
			return $ret;
		}

		public static function All()
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM partner");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Partner();
				$ret[$i]->Id = $row['partnerid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Salutation = $row['salutation'];
				$ret[$i]->Name = $row['name'];
				$ret[$i]->Surname = $row['surname'];
				$ret[$i]->Phone = $row['phone'];
				$ret[$i]->Email = $row['email'];
				$ret[$i]->Password = $row['password'];
				$ret[$i]->Profilepic = $row['profilepic'];
				$ret[$i]->Gender = $row['gender'];
				$ret[$i]->Country = $row['country'];
				$ret[$i]->State = $row['state'];
				$ret[$i]->City = $row['city'];
				$ret[$i]->Address = $row['address'];
				$ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Bank = $row['bank'];
                $ret[$i]->AccountName = $row['accountname'];
                $ret[$i]->AccountNumber = $row['accountnumber'];
				$i++;
			}
			return $ret;
		}

		public static function GetUser($user)
        {
            $us = trim(strtolower($user));

            $db = DB::GetDB();
            $ret = null;

            $res = $db->query("SELECT * FROM partner WHERE phone='$us' OR email='$us'");

            if($res->num_rows > 0)
            {
                $row = $res->fetch_assoc();

                $ret = new Partner();
                $ret->Id = $row['partnerid'];
                $ret->Created = new WixDate($row['created']);
                $ret->Salutation = $row['salutation'];
                $ret->Name = $row['name'];
                $ret->Surname = $row['surname'];
                $ret->Phone = $row['phone'];
                $ret->Email = $row['email'];
                $ret->Password = $row['password'];
                $ret->Profilepic = $row['profilepic'];
                $ret->Gender = $row['gender'];
                $ret->Country = $row['country'];
                $ret->State = $row['state'];
                $ret->City = $row['city'];
                $ret->Address = $row['address'];
                $ret->Status = Convert::ToBool($row['status']);
                $ret->Bank = $row['bank'];
                $ret->AccountName = $row['accountname'];
                $ret->AccountNumber = $row['accountnumber'];
            }
            return $ret;
        }
	}