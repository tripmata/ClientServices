<?php
	/* Generated by Wixnit Class Builder 
	// Sep, 03/2019
	// Building class for Room
	*/

	class Room
	{
		public $Id = "";
		public $Created = 0;
		public $Number = "";
		public $Category = "";
		public $Status = "";
		public $Features = [];
		
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

				$res = $db->query("SELECT * FROM room WHERE roomid='$arg'");

				if($res->num_rows > 0)
				{
					$row = $res->fetch_assoc();
				
					$this->Id = $row['roomid'];
					$this->Created = new WixDate($row['created']);
					$this->Number = $row['number'];
					$this->Category = new Roomcategory($this->subscriber);
					$this->Category->Initialize($row['category']);
					$this->Status = $row['status'];
                    $this->Features = json_decode($row['features']);
				}
			}
		}

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$number = addslashes($this->Number);
			$category = addslashes(is_a($this->Category, "Roomcategory") ? $this->Category->Id : $this->Category);
			$status = addslashes($this->Status);

			$f = [];

			for($i = 0; $i < count($this->Features); $i++)
            {
                if($this->Features[$i] != "")
                {
                    array_push($f, $this->Features[$i]);
                }
            }

			$features = json_encode($f);

			if($res = $db->query("SELECT roomid FROM room WHERE roomid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE room SET number='$number',category='$category',status='$status',features='$features' WHERE roomid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT roomid FROM room WHERE roomid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO room(roomid,created,number,category,status,features) VALUES ('$id','$created','$number','$category','$status','$features')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM room WHERE roomid='$id'");

			//Deleting Associated Objects
			/*n			$this->Category->Delete();
			*/
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM room WHERE number LIKE '%$term%' OR category LIKE '%$term%' OR status LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Room($subscriber);
                $ret[$i]->Id = $row['roomid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Number = $row['number'];
                $ret[$i]->Category = new Roomcategory($subscriber);
                $ret[$i]->Category->Initialize($row['category']);
                $ret[$i]->Status = $row['status'];
                $ret[$i]->Features = json_decode($row['features']);
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='roomid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM room WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Room($subscriber);
                $ret[$i]->Id = $row['roomid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Number = $row['number'];
                $ret[$i]->Category = new Roomcategory($subscriber);
                $ret[$i]->Category->Initialize($row['category']);
                $ret[$i]->Status = $row['status'];
                $ret[$i]->Features = json_decode($row['features']);
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM room ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Room($subscriber);
                $ret[$i]->Id = $row['roomid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Number = $row['number'];
                $ret[$i]->Category = new Roomcategory($subscriber);
                $ret[$i]->Category->Initialize($row['category']);
                $ret[$i]->Status = $row['status'];
                $ret[$i]->Features = json_decode($row['features']);
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM room");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Room($subscriber);
				$ret[$i]->Id = $row['roomid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Number = $row['number'];
				$ret[$i]->Category = new Roomcategory($subscriber);
				$ret[$i]->Category->Initialize($row['category']);
				$ret[$i]->Status = $row['status'];
                $ret[$i]->Features = json_decode($row['features']);
				$i++;
			}
			return $ret;
		}


		public static function RoomCount($subscriber)
        {
            $db = $subscriber->GetDB();
            $i = $db->query("SELECT * FROM room")->num_rows;
            $db->close();
            return $i;
        }
		
		public static function Exist(Subscriber $subscriber, $number, $category)
		{
			$db = $subscriber->GetDB();
			$res = $db->query("SELECT number FROM room WHERE number='$number' AND category='$category'");
			$db->close();
			return $res->num_rows > 0 ? true : false;
		}
		
		
		//Hand crafted method
		
		public function isOccupied()
		{
			return false;
		}
	}