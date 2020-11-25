<?php
	/* Generated by Wixnit Class Builder 
	// Apr, 27/2020
	// Building class for Roombooking
	*/

	class Roombooking
	{
		public $Id = "";
		public $Created = 0;
		public $Roomcategory = "";
		public $Number = 0;

		function __construct($arg=null)
		{
			if($arg != null)
			{
				$db = DB::GetDB();

				$res = $db->query("SELECT * FROM roombooking WHERE roombookingid='$arg'");

				if($res->num_rows > 0)
				{
					$row = $res->fetch_assoc();
				
					$this->Id = $row['roombookingid'];
					$this->Created = new WixDate($row['created']);
					$this->Roomcategory = $row['roomcategory'];
					$this->Number = $row['number'];
				}
			}
		}

		public function Save()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$created = time();
			$roomcategory = addslashes($this->Roomcategory);
			$number = Convert::ToInt($this->Number);

			if($res = $db->query("SELECT roombookingid FROM roombooking WHERE roombookingid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE roombooking SET roomcategory='$roomcategory',number='$number' WHERE roombookingid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT roombookingid FROM roombooking WHERE roombookingid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO roombooking(roombookingid,created,roomcategory,number) VALUES ('$id','$created','$roomcategory','$number')");
			}
		}

		public function Delete()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM roombooking WHERE roombookingid='$id'");
		}

		public static function Search($term='')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT roombookingid FROM roombooking WHERE roomcategory LIKE '%$term%' OR number LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Roombooking($row['roombookingid']);
				$i++;
			}
			return $ret;
		}

		public static function Filter($term='', $field='roombookingid')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT roombookingid FROM roombooking WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Roombooking($row['roombookingid']);
				$i++;
			}
			return $ret;
		}

		public static function Order($field='id', $order='DESC')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT roombookingid FROM roombooking ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Roombooking($row['roombookingid']);
				$i++;
			}
			return $ret;
		}

		public static function All()
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM roombooking");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Roombooking();
				$ret[$i]->Id = $row['roombookingid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Roomcategory = $row['roomcategory'];
				$ret[$i]->Number = $row['number'];
				$i++;
			}
			return $ret;
		}
	}