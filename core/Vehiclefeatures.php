<?php
	/* Generated by Wixnit Class Builder 
	// Apr, 12/2020
	// Building class for Vehiclefeatures
	*/

	class Vehiclefeatures
	{
		public $Id = "";
		public $Created = 0;
		public $Feature = "";
		public $Status = false;

		function __construct($arg=null)
		{
			if($arg != null)
			{
				$db = DB::GetDB();

				$res = $db->query("SELECT * FROM vehiclefeatures WHERE vehiclefeaturesid='$arg'");

				if($res->num_rows > 0)
				{
					$row = $res->fetch_assoc();
				
					$this->Id = $row['vehiclefeaturesid'];
					$this->Created = new WixDate($row['created']);
					$this->Feature = $row['feature'];
					$this->Status = Convert::ToBool($row['status']);
				}
			}
		}

		public function Save()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$created = time();
			$feature = addslashes($this->Feature);
			$status = Convert::ToInt($this->Status);

			if($res = $db->query("SELECT vehiclefeaturesid FROM vehiclefeatures WHERE vehiclefeaturesid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE vehiclefeatures SET feature='$feature',status='$status' WHERE vehiclefeaturesid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT vehiclefeaturesid FROM vehiclefeatures WHERE vehiclefeaturesid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO vehiclefeatures(vehiclefeaturesid,created,feature,status) VALUES ('$id','$created','$feature','$status')");
			}
		}

		public function Delete()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM vehiclefeatures WHERE vehiclefeaturesid='$id'");
		}

		public static function Search($term='')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM vehiclefeatures WHERE feature LIKE '%$term%' OR status LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Vehiclefeatures();
                $ret[$i]->Id = $row['vehiclefeaturesid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Feature = $row['feature'];
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $i++;
			}
			return $ret;
		}

		public static function Filter($term='', $field='vehiclefeaturesid')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM vehiclefeatures WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Vehiclefeatures();
                $ret[$i]->Id = $row['vehiclefeaturesid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Feature = $row['feature'];
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $i++;
			}
			return $ret;
		}

		public static function Order($field='id', $order='DESC')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM vehiclefeatures ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Vehiclefeatures();
                $ret[$i]->Id = $row['vehiclefeaturesid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Feature = $row['feature'];
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $i++;
			}
			return $ret;
		}

		public static function All()
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM vehiclefeatures");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Vehiclefeatures();
				$ret[$i]->Id = $row['vehiclefeaturesid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Feature = $row['feature'];
				$ret[$i]->Status = Convert::ToBool($row['status']);
				$i++;
			}
			return $ret;
		}
	}