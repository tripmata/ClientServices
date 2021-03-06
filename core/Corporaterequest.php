<?php
	/* Generated by Wixnit Class Builder 
	// Jul, 12/2020
	// Building class for Corporaterequest
	*/

	class Corporaterequest
	{
		public $Id = "";
		public $Created = 0;
		public $Company = "";
		public $Email = "";
		public $Phone = "";
		public $City = "";
		public $State = "";
		public $Status = false;
		public $Approved = false;
		public $Customer = "";
		public $Credit = 0;

		function __construct($arg=null)
		{
			if($arg != null)
			{
				$db = DB::GetDB();

				$res = $db->query("SELECT * FROM corporaterequest WHERE corporaterequestid='$arg'");

				if($res->num_rows > 0)
				{
					$row = $res->fetch_assoc();
				
					$this->Id = $row['corporaterequestid'];
					$this->Created = new WixDate($row['created']);
					$this->Company = $row['company'];
					$this->Email = $row['email'];
					$this->Phone = $row['phone'];
					$this->City = $row['city'];
					$this->State = $row['state'];
					$this->Status = Convert::ToBool($row['status']);
					$this->Approved = Convert::ToBool($row['approved']);
					$this->Customer = new Customer($row['customer']);
					$this->Credit = $row['credit'];
				}
			}
		}

		public function Save()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$created = time();
			$company = addslashes($this->Company);
			$email = addslashes($this->Email);
			$phone = addslashes($this->Phone);
			$city = addslashes($this->City);
			$state = addslashes($this->State);
			$status = Convert::ToInt($this->Status);
			$approved = Convert::ToInt($this->Approved);
			$customer = addslashes(is_a($this->Customer, "Customer") ? $this->Customer->Id : $this->Customer);
			$credit = floatval($this->Credit);

			if($res = $db->query("SELECT corporaterequestid FROM corporaterequest WHERE corporaterequestid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE corporaterequest SET company='$company',email='$email',phone='$phone',city='$city',state='$state',status='$status',approved='$approved',customer='$customer',credit='$credit' WHERE corporaterequestid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT corporaterequestid FROM corporaterequest WHERE corporaterequestid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO corporaterequest(corporaterequestid,created,company,email,phone,city,state,status,approved,customer,credit) VALUES ('$id','$created','$company','$email','$phone','$city','$state','$status','$approved','$customer','$credit')");
			}
		}

		public function Delete()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM corporaterequest WHERE corporaterequestid='$id'");

			//Deleting Associated Objects
			/*n			$this->Customer->Delete();
			*/
		}

		public static function Search($term='')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT corporaterequestid FROM corporaterequest WHERE company LIKE '%$term%' OR email LIKE '%$term%' OR phone LIKE '%$term%' OR city LIKE '%$term%' OR state LIKE '%$term%' OR status LIKE '%$term%' OR approved LIKE '%$term%' OR customer LIKE '%$term%' OR credit LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Corporaterequest($row['corporaterequestid']);
				$i++;
			}
			return $ret;
		}

		public static function Filter($term='', $field='corporaterequestid')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT corporaterequestid FROM corporaterequest WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Corporaterequest($row['corporaterequestid']);
				$i++;
			}
			return $ret;
		}

		public static function Order($field='id', $order='DESC')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT corporaterequestid FROM corporaterequest ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Corporaterequest($row['corporaterequestid']);
				$i++;
			}
			return $ret;
		}

		public static function All()
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM corporaterequest");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Corporaterequest();
				$ret[$i]->Id = $row['corporaterequestid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Company = $row['company'];
				$ret[$i]->Email = $row['email'];
				$ret[$i]->Phone = $row['phone'];
				$ret[$i]->City = $row['city'];
				$ret[$i]->State = $row['state'];
				$ret[$i]->Status = Convert::ToBool($row['status']);
				$ret[$i]->Approved = Convert::ToBool($row['approved']);
				$ret[$i]->Customer = new Customer($row['customer']);
				$ret[$i]->Credit = $row['credit'];
				$i++;
			}
			return $ret;
		}

        public static function FindRequest($customer)
        {
            $db = DB::GetDB();
            $ret = null;

            $id = is_a($customer, "Customer") ? $customer->Id : $customer;

            $res = $db->query("SELECT * FROM corporaterequest WHERE customer='$id'");
            if($res->num_rows > 0)
            {
                $row = $res->fetch_assoc();

                $ret = new Corporaterequest();
                $ret->Id = $row['corporaterequestid'];
                $ret->Created = new WixDate($row['created']);
                $ret->Company = $row['company'];
                $ret->Email = $row['email'];
                $ret->Phone = $row['phone'];
                $ret->City = $row['city'];
                $ret->State = $row['state'];
                $ret->Status = Convert::ToBool($row['status']);
                $ret->Approved = Convert::ToBool($row['approved']);
                $ret->Customer = new Customer($row['customer']);
                $ret->Credit = $row['credit'];
            }
            return $ret;
        }
	}
