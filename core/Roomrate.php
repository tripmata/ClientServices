<?php
	/* Generated by Wixnit Class Builder 
	// May, 01/2020
	// Building class for Roomrate
	*/

	class Roomrate
	{
		public $Id = "";
		public $Created = 0;
		public $Room = "";
		public $Startdate = 0;
		public $Stopdate = 0;
		public $Rate = 0;
		public $Status = false;

		private $subscriber = null;

		function __construct(Subscriber $subscriber)
        {
            $this->subscriber = $subscriber;
        }

		public function Initialize($arg=null)
		{
			if($arg != null)
			{
				$db = $this->subscriber->GetDB();

				$res = $db->query("SELECT * FROM roomrate WHERE roomrateid='$arg'");

				if($res->num_rows > 0)
				{
					$row = $res->fetch_assoc();
				
					$this->Id = $row['roomrateid'];
					$this->Created = new WixDate($row['created']);
					$this->Room = new Roomcategory($this->subscriber);
					$this->Room->Initialize($row['room']);
					$this->Startdate = new WixDate($row['startdate']);
					$this->Stopdate = new WixDate($row['stopdate']);
					$this->Rate = doubleval($row['rate']);
					$this->Status = Convert::ToBool($row['status']);
				}
			}
		}

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$room = addslashes(is_a($this->Room, "Roomcategory") ? $this->Room->Id : $this->Room);
			$startdate = Convert::ToInt($this->Startdate);
			$stopdate = Convert::ToInt($this->Stopdate);
			$rate = floatval($this->Rate);
			$status = Convert::ToInt($this->Status);

			if($res = $db->query("SELECT roomrateid FROM roomrate WHERE roomrateid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE roomrate SET room='$room',startdate='$startdate',stopdate='$stopdate',rate='$rate',status='$status' WHERE roomrateid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT roomrateid FROM roomrate WHERE roomrateid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO roomrate(roomrateid,created,room,startdate,stopdate,rate,status) VALUES ('$id','$created','$room','$startdate','$stopdate','$rate','$status')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM roomrate WHERE roomrateid='$id'");

			//Deleting Associated Objects
			/*n			$this->Room->Delete();
			*/
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM roomrate WHERE room LIKE '%$term%' OR startdate LIKE '%$term%' OR stopdate LIKE '%$term%' OR rate LIKE '%$term%' OR status LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Roomrate($subscriber);
                $ret[$i]->Id = $row['roomrateid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Room = new Roomcategory($subscriber);
                $ret[$i]->Room->Initialize($row['room']);
                $ret[$i]->Startdate = new WixDate($row['startdate']);
                $ret[$i]->Stopdate = new WixDate($row['stopdate']);
                $ret[$i]->Rate = doubleval($row['rate']);
                $ret[$i]->Status = Convert::ToBool($row['status']);
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='roomrateid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM roomrate WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Roomrate($subscriber);
                $ret[$i]->Id = $row['roomrateid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Room = new Roomcategory($subscriber);
                $ret[$i]->Room->Initialize($row['room']);
                $ret[$i]->Startdate = new WixDate($row['startdate']);
                $ret[$i]->Stopdate = new WixDate($row['stopdate']);
                $ret[$i]->Rate = doubleval($row['rate']);
                $ret[$i]->Status = Convert::ToBool($row['status']);
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM roomrate ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Roomrate($subscriber);
                $ret[$i]->Id = $row['roomrateid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Room = new Roomcategory($subscriber);
                $ret[$i]->Room->Initialize($row['room']);
                $ret[$i]->Startdate = new WixDate($row['startdate']);
                $ret[$i]->Stopdate = new WixDate($row['stopdate']);
                $ret[$i]->Rate = doubleval($row['rate']);
                $ret[$i]->Status = Convert::ToBool($row['status']);
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM roomrate");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Roomrate($subscriber);
				$ret[$i]->Id = $row['roomrateid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Room = new Roomcategory($subscriber);
				$ret[$i]->Room->Initialize($row['room']);
				$ret[$i]->Startdate = new WixDate($row['startdate']);
				$ret[$i]->Stopdate = new WixDate($row['stopdate']);
				$ret[$i]->Rate = doubleval($row['rate']);
				$ret[$i]->Status = Convert::ToBool($row['status']);
				$i++;
			}
			return $ret;
		}

        public static function ByRoomtype(Subscriber $subscriber, $room, $constructCategory=true)
        {
            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

			$id = is_a($room, "Roomcategory") ? $room->Id : $room;

			$res = $db->query("SELECT * FROM roomrate WHERE room='$id'");
			
			if (is_object($res) && $res->num_rows > 0) :

				while(($row = $res->fetch_assoc()) != null)
				{
					$ret[$i] = new Roomrate($subscriber);
					$ret[$i]->Id = $row['roomrateid'];
					$ret[$i]->Created = new WixDate($row['created']);
					if($constructCategory === true)
					{
						$ret[$i]->Room = new Roomcategory($subscriber);
						$ret[$i]->Room->Initialize($row['room']);
					}
					else
					{
						$ret[$i]->Room = $row['room'];
					}
					$ret[$i]->Startdate = new WixDate($row['startdate']);
					$ret[$i]->Stopdate = new WixDate($row['stopdate']);
					$ret[$i]->Rate = doubleval($row['rate']);
					$ret[$i]->Status = Convert::ToBool($row['status']);
					$i++;
				}
			
			endif;
			
            return $ret;
        }
	}
