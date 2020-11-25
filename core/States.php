<?php
	/* Generated by Wixnit Class Builder 
	// Jul, 06/2019
	// Building class for States
	*/

	class States
	{
		public $Id = "";
		public $Created = 0;
		public $Code = "";
		public $Name = "";
		public $Country = "";
		public $Subdivition = array();

		function __construct($arg=null)
		{
			if($arg != null)
			{
				$db = DB::GetDB();

				$res = $db->query("SELECT * FROM states WHERE statesid='$arg'");

				if($res->num_rows > 0)
				{
					$row = $res->fetch_assoc();
				
					$this->Id = $row['statesid'];
					$this->Created = new WixDate($row['created']);
					$this->Code = $row['code'];
					$this->Name = $row['name'];
					$this->Country = $row['country'];
					$this->Subdivition = json_decode($row['subdivition']);
				}
                $db->close();
			}
		}

		public function Save()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$created = time();
			$code = addslashes($this->Code);
			$name = addslashes($this->Name);
			$country = addslashes($this->Country);
			$subdivition = addslashes(json_encode($this->Subdivition));

			if($res = $db->query("SELECT statesid FROM states WHERE statesid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE states SET code='$code',name='$name',country='$country',subdivition='$subdivition' WHERE statesid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT statesid FROM states WHERE statesid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO states(statesid,created,code,name,country,subdivition) VALUES ('$id','$created','$code','$name','$country','$subdivition')");
			}
            $db->close();
		}

		public function Delete()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM states WHERE statesid='$id'");
		}

		public static function Search($term='')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM states WHERE name LIKE '%$term%'");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new States();
                $ret[$i]->Id = $row['statesid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Code = $row['code'];
                $ret[$i]->Name = ucwords($row['name']);
                $ret[$i]->Country = $row['country'];
                $ret[$i]->Subdivition = json_decode($row['subdivition']);
                $i++;
            }
            $db->close();
            return $ret;
		}

		public static function Filter($term='', $field='statesid')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT statesid FROM states WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = $row['statesid'];
				$i++;
			}
            $db->close();
			return States::GroupInitialize($ret);
		}

		public static function Order($field='id', $order='DESC')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM states ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new States();
                $ret[$i]->Id = $row['statesid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Code = $row['code'];
                $ret[$i]->Name = ucwords($row['name']);
                $ret[$i]->Country = $row['country'];
                $ret[$i]->Subdivition = json_decode($row['subdivition']);
                $i++;
			}
            $db->close();
			return $ret;
		}

		public static function GroupInitialize($array=null, $orderBy='id', $order='DESC')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$query = "";

			if(is_array($array) === true)
			{
				if(count($array) == 0)
				{
					return $ret;
				}
				else
				{
					for($i = 0; $i < count($array); $i++)
					{
						if($query == "")
						{
							$query = " WHERE Statesid='".$array[$i]."'";
						}
						else
						{
							$query .= " OR Statesid ='".$array[$i]."'";
						}
					}
				}
			}
			$i = 0;
			$res = $db->query("SELECT * FROM states".$query." ORDER BY ".$orderBy." ".$order);
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new States();
				$ret[$i]->Id = $row['statesid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Code = $row['code'];
				$ret[$i]->Name = ucwords($row['name']);
				$ret[$i]->Country = $row['country'];
				$ret[$i]->Subdivition = json_decode($row['subdivition']);
				$i++;
			}
            $db->close();
			return $ret;
		}

		public static function FIlterCountry($country)
        {
            $code = is_a($country, "Country") ? strtolower($country->Code) : strtolower($country);
            $ret = array();
            $i = 0;

            $res = DB::GetDB()->query("SELECT statesid FROM states WHERE country='$code'");

            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = $row['statesid'];
                $i++;
            }

            return States::GroupInitialize($ret, "name", "ASC");
        }
	}
