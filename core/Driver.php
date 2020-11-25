<?php
	/* Generated by Wixnit Class Builder 
	// Apr, 06/2020
	// Building class for Driver
	*/

	class Driver
	{
		public $Id = "";
		public $Created = 0;
		public $Name = "";
		public $Surname = "";
		public $Phone = "";
		public $Email = "";
		public $Password = "";
		public $Profilepic = "";
		public $Gender = "";
		public $Dob = 0;
		public $Address = "";
		public $City = "";
		public $State = "";
		public $Available = false;
		public $Status = false;

		public $Age = 0;

		function __construct($arg=null)
		{
			if($arg != null)
			{
				$db = DB::GetDB();

				$res = $db->query("SELECT * FROM driver WHERE driverid='$arg'");

				if($res->num_rows > 0)
				{
					$row = $res->fetch_assoc();
				
					$this->Id = $row['driverid'];
					$this->Created = new WixDate($row['created']);
					$this->Name = $row['name'];
					$this->Surname = $row['surname'];
					$this->Phone = $row['phone'];
					$this->Email = $row['email'];
					$this->Password = $row['password'];
					$this->Profilepic = $row['profilepic'];
					$this->Gender = $row['gender'];
					$this->Dob = $row['dob'];
					$this->Address = $row['address'];
					$this->City = $row['city'];
					$this->State = $row['state'];
					$this->Available = Convert::ToBool($row['available']);
					$this->Status = Convert::ToBool($row['status']);

					$this->Age = ((time() - $this->Dob) / (((60 * 60) * 24) * 365));
				}
			}
		}

		public function Save()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$created = time();
			$name = addslashes($this->Name);
			$surname = addslashes($this->Surname);
			$phone = addslashes($this->Phone);
			$email = addslashes($this->Email);
			$password = addslashes($this->Password);
			$profilepic = addslashes($this->Profilepic);
			$gender = addslashes($this->Gender);
			$dob = Convert::ToInt($this->Dob);
			$address = addslashes($this->Address);
			$city = addslashes($this->City);
			$state = addslashes($this->State);
			$available = Convert::ToInt($this->Available);
			$status = Convert::ToInt($this->Status);

			if($res = $db->query("SELECT driverid FROM driver WHERE driverid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE driver SET name='$name',surname='$surname',phone='$phone',email='$email',password='$password',profilepic='$profilepic',gender='$gender',dob='$dob',address='$address',city='$city',state='$state',available='$available',status='$status' WHERE driverid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT driverid FROM driver WHERE driverid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO driver(driverid,created,name,surname,phone,email,password,profilepic,gender,dob,address,city,state,available,status) VALUES ('$id','$created','$name','$surname','$phone','$email','$password','$profilepic','$gender','$dob','$address','$city','$state','$available','$status')");
			}
		}

		public function Delete()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM driver WHERE driverid='$id'");
		}

		public static function Search($term='')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT driverid FROM driver WHERE name LIKE '%$term%' OR surname LIKE '%$term%' OR phone LIKE '%$term%' OR email LIKE '%$term%' OR password LIKE '%$term%' OR profilepic LIKE '%$term%' OR gender LIKE '%$term%' OR dob LIKE '%$term%' OR address LIKE '%$term%' OR city LIKE '%$term%' OR state LIKE '%$term%' OR available LIKE '%$term%' OR status LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Driver($row['driverid']);
				$i++;
			}
			return $ret;
		}

		public static function Filter($term='', $field='driverid')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT driverid FROM driver WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Driver($row['driverid']);
				$i++;
			}
			return $ret;
		}

		public static function Order($field='id', $order='DESC')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT driverid FROM driver ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Driver($row['driverid']);
				$i++;
			}
			return $ret;
		}

		public static function All()
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM driver");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Driver();
				$ret[$i]->Id = $row['driverid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Name = $row['name'];
				$ret[$i]->Surname = $row['surname'];
				$ret[$i]->Phone = $row['phone'];
				$ret[$i]->Email = $row['email'];
				$ret[$i]->Password = $row['password'];
				$ret[$i]->Profilepic = $row['profilepic'];
				$ret[$i]->Gender = $row['gender'];
				$ret[$i]->Dob = $row['dob'];
				$ret[$i]->Address = $row['address'];
				$ret[$i]->City = $row['city'];
				$ret[$i]->State = $row['state'];
				$ret[$i]->Available = Convert::ToBool($row['available']);
				$ret[$i]->Status = Convert::ToBool($row['status']);
				$i++;
			}
			return $ret;
		}
	}