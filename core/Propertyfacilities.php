<?php
	/* Generated by Wixnit Class Builder 
	// Apr, 14/2020
	// Building class for Propertyfacilities
	*/

	class Propertyfacilities
	{
		public $Id = "";
		public $Created = 0;
		public $Facility = "";
		public $Description = "";
		public $Status = false;

		function __construct($arg=null)
		{
			if($arg != null)
			{
				$db = DB::GetDB();

				$res = $db->query("SELECT * FROM propertyfacilities WHERE propertyfacilitiesid='$arg'");

				if($res->num_rows > 0)
				{
					$row = $res->fetch_assoc();
				
					$this->Id = $row['propertyfacilitiesid'];
					$this->Created = new WixDate($row['created']);
					$this->Facility = $row['facility'];
					$this->Status = Convert::ToBool($row['status']);
					$this->Description = $row['description'];
				}
			}
		}

		public function Save()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$created = time();
			$facility = addslashes($this->Facility);
			$status = Convert::ToInt($this->Status);
			$description = addslashes($this->Description);

			if($res = $db->query("SELECT propertyfacilitiesid FROM propertyfacilities WHERE propertyfacilitiesid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE propertyfacilities SET facility='$facility',status='$status',description='$description' WHERE propertyfacilitiesid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT propertyfacilitiesid FROM propertyfacilities WHERE propertyfacilitiesid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO propertyfacilities(propertyfacilitiesid,created,facility,status,description) VALUES ('$id','$created','$facility','$status','$description')");
			}
		}

		public function Delete()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM propertyfacilities WHERE propertyfacilitiesid='$id'");
		}

		public static function Search($term='')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT propertyfacilitiesid FROM propertyfacilities WHERE facility LIKE '%$term%' OR status LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Propertyfacilities($row['propertyfacilitiesid']);
				$i++;
			}
			return $ret;
		}

		public static function Filter($term='', $field='propertyfacilitiesid')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM propertyfacilities WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Propertyfacilities();
                $ret[$i]->Id = $row['propertyfacilitiesid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Facility = $row['facility'];
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Description = $row['description'];
                $i++;
			}
			return $ret;
		}

		public static function Order($field='id', $order='DESC')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT propertyfacilitiesid FROM propertyfacilities ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Propertyfacilities($row['propertyfacilitiesid']);
				$i++;
			}
			return $ret;
		}

		public static function All()
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM propertyfacilities");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Propertyfacilities();
				$ret[$i]->Id = $row['propertyfacilitiesid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Facility = $row['facility'];
				$ret[$i]->Status = Convert::ToBool($row['status']);
				$i++;
			}
			return $ret;
		}
	}
