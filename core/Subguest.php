<?php
	/* Generated by Wixnit Class Builder 
	// Feb, 03/2020
	// Building class for Subguest
	*/

	class Subguest
	{
		public $Id = "";
		public $Created = 0;
		public $Name = "";
		public $Surname = "";
		public $Phone = "";
		public $Email = "";
		public $Country = "";
		public $State = "";
		public $City = "";
		public $Occupation = "";
		public $Kinname = "";
		public $Kinsurname = "";
		public $Organization = "";
		public $Zip = "";
		public $Lastseen = 0;
		public $Dateofbirth = 0;
		public $Monthofbirth = 0;
		public $Dayofbirth = 0;
		public $Newsletter = false;
		public $Active = false;
		public $Status = false;
		public $Sex = "";
		public $Guestid = "";
		public $Salutation = "";
		public $Profilepic = "";
		public $Idtype = "";
		public $Idnumber = "";
		public $Idimage = "";
		public $Street = "";
		public $Kinaddress = "";
		public $Destination = "";
		public $Origination = "";

		private $subscriber = null;

        public $Type = "subguest";

		function __construct(Subscriber $subscriber)
		{
			$this->subscriber = $subscriber;
		}

		public function Initialize($arg=null)
        {
            if($arg != null)
            {
                $db = $this->subscriber->GetDB();

                $res = $db->query("SELECT * FROM subguest WHERE subguestid='$arg'");

                if($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['subguestid'];
                    $this->Created = new WixDate($row['created']);
                    $this->Name = $row['name'];
                    $this->Surname = $row['surname'];
                    $this->Phone = $row['phone'];
                    $this->Email = $row['email'];
                    $this->Country = $row['country'];
                    $this->State = $row['state'];
                    $this->City = $row['city'];
                    $this->Occupation = $row['occupation'];
                    $this->Kinname = $row['kinname'];
                    $this->Kinsurname = $row['kinsurname'];
                    $this->Organization = $row['organization'];
                    $this->Zip = $row['zip'];
                    $this->Lastseen = new WixDate($row['lastseen']);
                    $this->Dateofbirth = new WixDate($row['dateofbirth']);
                    $this->Monthofbirth = $row['monthofbirth'];
                    $this->Dayofbirth = $row['dayofbirth'];
                    $this->Newsletter = Convert::ToBool($row['newsletter']);
                    $this->Active = Convert::ToBool($row['active']);
                    $this->Status = Convert::ToBool($row['status']);
                    $this->Sex = $row['sex'];
                    $this->Guestid = $row['guestid'];
                    $this->Salutation = $row['salutation'];
                    $this->Profilepic = $row['profilepic'];
                    $this->Idtype = $row['idtype'];
                    $this->Idnumber = $row['idnumber'];
                    $this->Idimage = $row['idimage'];
                    $this->Street = $row['street'];
                    $this->Kinaddress = $row['kinaddress'];
                    $this->Destination = $row['destination'];
                    $this->Origination = $row['origination'];
                }
            }
        }

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$name = addslashes($this->Name);
			$surname = addslashes($this->Surname);
			$phone = addslashes($this->Phone);
			$email = addslashes($this->Email);
			$country = addslashes($this->Country);
			$state = addslashes($this->State);
			$city = addslashes($this->City);
			$occupation = addslashes($this->Occupation);
			$kinname = addslashes($this->Kinname);
			$kinsurname = addslashes($this->Kinsurname);
			$organization = addslashes($this->Organization);
			$zip = addslashes($this->Zip);
			$lastseen = Convert::ToInt($this->Lastseen);
			$dateofbirth = Convert::ToInt($this->Dateofbirth);
			$monthofbirth = Convert::ToInt($this->Monthofbirth);
			$dayofbirth = Convert::ToInt($this->Dayofbirth);
			$newsletter = Convert::ToInt($this->Newsletter);
			$active = Convert::ToInt($this->Active);
			$status = Convert::ToInt($this->Status);
			$sex = addslashes($this->Sex);
			$guestid = addslashes($this->Guestid);
			$salutation = addslashes($this->Salutation);
			$profilepic = addslashes($this->Profilepic);
			$idtype = addslashes($this->Idtype);
			$idnumber = addslashes($this->Idnumber);
			$idimage = addslashes($this->Idimage);
			$street = addslashes($this->Street);
			$kinaddress = addslashes($this->Kinaddress);
			$destination = addslashes($this->Destination);
			$origination = addslashes($this->Origination);

			if($res = $db->query("SELECT subguestid FROM subguest WHERE subguestid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE subguest SET name='$name',surname='$surname',phone='$phone',email='$email',country='$country',state='$state',city='$city',occupation='$occupation',kinname='$kinname',kinsurname='$kinsurname',organization='$organization',zip='$zip',lastseen='$lastseen',dateofbirth='$dateofbirth',monthofbirth='$monthofbirth',dayofbirth='$dayofbirth',newsletter='$newsletter',active='$active',status='$status',sex='$sex',guestid='$guestid',salutation='$salutation',profilepic='$profilepic',idtype='$idtype',idnumber='$idnumber',idimage='$idimage',street='$street',kinaddress='$kinaddress',destination='$destination',origination='$origination' WHERE subguestid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT subguestid FROM subguest WHERE subguestid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO subguest(subguestid,created,name,surname,phone,email,country,state,city,occupation,kinname,kinsurname,organization,zip,lastseen,dateofbirth,monthofbirth,dayofbirth,newsletter,active,status,sex,guestid,salutation,profilepic,idtype,idnumber,idimage,street,kinaddress,destination,origination) VALUES ('$id','$created','$name','$surname','$phone','$email','$country','$state','$city','$occupation','$kinname','$kinsurname','$organization','$zip','$lastseen','$dateofbirth','$monthofbirth','$dayofbirth','$newsletter','$active','$status','$sex','$guestid','$salutation','$profilepic','$idtype','$idnumber','$idimage','$street','$kinaddress','$destination','$origination')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM subguest WHERE subguestid='$id'");
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM subguest WHERE name LIKE '%$term%' OR surname LIKE '%$term%' OR phone LIKE '%$term%' OR email LIKE '%$term%' OR country LIKE '%$term%' OR state LIKE '%$term%' OR city LIKE '%$term%' OR occupation LIKE '%$term%' OR kinname LIKE '%$term%' OR kinsurname LIKE '%$term%' OR organization LIKE '%$term%' OR zip LIKE '%$term%' OR lastseen LIKE '%$term%' OR dateofbirth LIKE '%$term%' OR monthofbirth LIKE '%$term%' OR dayofbirth LIKE '%$term%' OR newsletter LIKE '%$term%' OR active LIKE '%$term%' OR status LIKE '%$term%' OR sex LIKE '%$term%' OR guestid LIKE '%$term%' OR salutation LIKE '%$term%' OR profilepic LIKE '%$term%' OR idtype LIKE '%$term%' OR idnumber LIKE '%$term%' OR idimage LIKE '%$term%' OR street LIKE '%$term%' OR kinaddress LIKE '%$term%' OR destination LIKE '%$term%' OR origination LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Subguest($subscriber);
                $ret[$i]->Id = $row['subguestid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Surname = $row['surname'];
                $ret[$i]->Phone = $row['phone'];
                $ret[$i]->Email = $row['email'];
                $ret[$i]->Country = $row['country'];
                $ret[$i]->State = $row['state'];
                $ret[$i]->City = $row['city'];
                $ret[$i]->Occupation = $row['occupation'];
                $ret[$i]->Kinname = $row['kinname'];
                $ret[$i]->Kinsurname = $row['kinsurname'];
                $ret[$i]->Organization = $row['organization'];
                $ret[$i]->Zip = $row['zip'];
                $ret[$i]->Lastseen = new WixDate($row['lastseen']);
                $ret[$i]->Dateofbirth = new WixDate($row['dateofbirth']);
                $ret[$i]->Monthofbirth = $row['monthofbirth'];
                $ret[$i]->Dayofbirth = $row['dayofbirth'];
                $ret[$i]->Newsletter = Convert::ToBool($row['newsletter']);
                $ret[$i]->Active = Convert::ToBool($row['active']);
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Sex = $row['sex'];
                $ret[$i]->Guestid = $row['guestid'];
                $ret[$i]->Salutation = $row['salutation'];
                $ret[$i]->Profilepic = $row['profilepic'];
                $ret[$i]->Idtype = $row['idtype'];
                $ret[$i]->Idnumber = $row['idnumber'];
                $ret[$i]->Idimage = $row['idimage'];
                $ret[$i]->Street = $row['street'];
                $ret[$i]->Kinaddress = $row['kinaddress'];
                $ret[$i]->Destination = $row['destination'];
                $ret[$i]->Origination = $row['origination'];
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='subguestid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM subguest WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Subguest($subscriber);
                $ret[$i]->Id = $row['subguestid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Surname = $row['surname'];
                $ret[$i]->Phone = $row['phone'];
                $ret[$i]->Email = $row['email'];
                $ret[$i]->Country = $row['country'];
                $ret[$i]->State = $row['state'];
                $ret[$i]->City = $row['city'];
                $ret[$i]->Occupation = $row['occupation'];
                $ret[$i]->Kinname = $row['kinname'];
                $ret[$i]->Kinsurname = $row['kinsurname'];
                $ret[$i]->Organization = $row['organization'];
                $ret[$i]->Zip = $row['zip'];
                $ret[$i]->Lastseen = new WixDate($row['lastseen']);
                $ret[$i]->Dateofbirth = new WixDate($row['dateofbirth']);
                $ret[$i]->Monthofbirth = $row['monthofbirth'];
                $ret[$i]->Dayofbirth = $row['dayofbirth'];
                $ret[$i]->Newsletter = Convert::ToBool($row['newsletter']);
                $ret[$i]->Active = Convert::ToBool($row['active']);
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Sex = $row['sex'];
                $ret[$i]->Guestid = $row['guestid'];
                $ret[$i]->Salutation = $row['salutation'];
                $ret[$i]->Profilepic = $row['profilepic'];
                $ret[$i]->Idtype = $row['idtype'];
                $ret[$i]->Idnumber = $row['idnumber'];
                $ret[$i]->Idimage = $row['idimage'];
                $ret[$i]->Street = $row['street'];
                $ret[$i]->Kinaddress = $row['kinaddress'];
                $ret[$i]->Destination = $row['destination'];
                $ret[$i]->Origination = $row['origination'];
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM subguest ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Subguest($subscriber);
                $ret[$i]->Id = $row['subguestid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Surname = $row['surname'];
                $ret[$i]->Phone = $row['phone'];
                $ret[$i]->Email = $row['email'];
                $ret[$i]->Country = $row['country'];
                $ret[$i]->State = $row['state'];
                $ret[$i]->City = $row['city'];
                $ret[$i]->Occupation = $row['occupation'];
                $ret[$i]->Kinname = $row['kinname'];
                $ret[$i]->Kinsurname = $row['kinsurname'];
                $ret[$i]->Organization = $row['organization'];
                $ret[$i]->Zip = $row['zip'];
                $ret[$i]->Lastseen = new WixDate($row['lastseen']);
                $ret[$i]->Dateofbirth = new WixDate($row['dateofbirth']);
                $ret[$i]->Monthofbirth = $row['monthofbirth'];
                $ret[$i]->Dayofbirth = $row['dayofbirth'];
                $ret[$i]->Newsletter = Convert::ToBool($row['newsletter']);
                $ret[$i]->Active = Convert::ToBool($row['active']);
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Sex = $row['sex'];
                $ret[$i]->Guestid = $row['guestid'];
                $ret[$i]->Salutation = $row['salutation'];
                $ret[$i]->Profilepic = $row['profilepic'];
                $ret[$i]->Idtype = $row['idtype'];
                $ret[$i]->Idnumber = $row['idnumber'];
                $ret[$i]->Idimage = $row['idimage'];
                $ret[$i]->Street = $row['street'];
                $ret[$i]->Kinaddress = $row['kinaddress'];
                $ret[$i]->Destination = $row['destination'];
                $ret[$i]->Origination = $row['origination'];
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM subguest");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Subguest($subscriber);
				$ret[$i]->Id = $row['subguestid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Name = $row['name'];
				$ret[$i]->Surname = $row['surname'];
				$ret[$i]->Phone = $row['phone'];
				$ret[$i]->Email = $row['email'];
				$ret[$i]->Country = $row['country'];
				$ret[$i]->State = $row['state'];
				$ret[$i]->City = $row['city'];
				$ret[$i]->Occupation = $row['occupation'];
				$ret[$i]->Kinname = $row['kinname'];
				$ret[$i]->Kinsurname = $row['kinsurname'];
				$ret[$i]->Organization = $row['organization'];
				$ret[$i]->Zip = $row['zip'];
				$ret[$i]->Lastseen = new WixDate($row['lastseen']);
				$ret[$i]->Dateofbirth = new WixDate($row['dateofbirth']);
				$ret[$i]->Monthofbirth = $row['monthofbirth'];
				$ret[$i]->Dayofbirth = $row['dayofbirth'];
				$ret[$i]->Newsletter = Convert::ToBool($row['newsletter']);
				$ret[$i]->Active = Convert::ToBool($row['active']);
				$ret[$i]->Status = Convert::ToBool($row['status']);
				$ret[$i]->Sex = $row['sex'];
				$ret[$i]->Guestid = $row['guestid'];
				$ret[$i]->Salutation = $row['salutation'];
				$ret[$i]->Profilepic = $row['profilepic'];
				$ret[$i]->Idtype = $row['idtype'];
				$ret[$i]->Idnumber = $row['idnumber'];
				$ret[$i]->Idimage = $row['idimage'];
				$ret[$i]->Street = $row['street'];
				$ret[$i]->Kinaddress = $row['kinaddress'];
				$ret[$i]->Destination = $row['destination'];
				$ret[$i]->Origination = $row['origination'];
				$i++;
			}
			return $ret;
		}
	}
