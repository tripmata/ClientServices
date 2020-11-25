<?php
	/* Generated by Wixnit Class Builder 
	// Jan, 29/2020
	// Building class for Systemlog
	*/

	class Systemlog
	{
		public $Id = "";
		public $Created = 0;
		public $Source = "";
		public $Event = "";
		public $Description = "";

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

                $res = $db->query("SELECT * FROM systemlog WHERE systemlogid='$arg'");

                if($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['systemlogid'];
                    $this->Created = new WixDate($row['created']);
                    $this->Source = $row['source'];
                    $this->Event = $row['event'];
                    $this->Description = $row['description'];
                }
            }
        }

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$source = addslashes($this->Source);
			$event = addslashes($this->Event);
			$description = addslashes($this->Description);

			if($res = $db->query("SELECT systemlogid FROM systemlog WHERE systemlogid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE systemlog SET source='$source',event='$event',description='$description' WHERE systemlogid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT systemlogid FROM systemlog WHERE systemlogid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO systemlog(systemlogid,created,source,event,description) VALUES ('$id','$created','$source','$event','$description')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM systemlog WHERE systemlogid='$id'");
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM systemlog WHERE source LIKE '%$term%' OR event LIKE '%$term%' OR description LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = $row['systemlogid'];
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='systemlogid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM systemlog WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = $row['systemlogid'];
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT systemlogid FROM systemlog ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = $row['systemlogid'];
				$i++;
			}
			return $ret;
		}

		public static function GroupInitialize(Subscriber $subscriber, $array=null, $orderBy='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
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
							$query = " WHERE Systemlogid='".$array[$i]."'";
						}
						else
						{
							$query .= " OR Systemlogid ='".$array[$i]."'";
						}
					}
				}
			}
			$i = 0;
			$res = $db->query("SELECT * FROM systemlog".$query." ORDER BY ".$orderBy." ".$order);
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Systemlog($subscriber);
				$ret[$i]->Id = $row['systemlogid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Source = $row['source'];
				$ret[$i]->Event = $row['event'];
				$ret[$i]->Description = $row['description'];
				$i++;
			}
			return $ret;
		}


		public static function All(Subscriber $subscriber)
        {
            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $res = $db->query("SELECT * FROM systemlog");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Systemlog($subscriber);
                $ret[$i]->Id = $row['systemlogid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Source = $row['source'];
                $ret[$i]->Event = $row['event'];
                $ret[$i]->Description = $row['description'];
                $i++;
            }
            return $ret;
        }


        public static function Searchspan(Subscriber $subscriber, Timespan $timespan, $term='')
        {
            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $start = $timespan->Start;
            $stop = $timespan->Stop;

            $res = $db->query("SELECT * FROM systemlog WHERE (created >= '$start') AND (created <= '$stop') AND (source LIKE '%$term%' OR event LIKE '%$term%' OR description LIKE '%$term%') ORDER BY id DESC");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Systemlog($subscriber);
                $ret[$i]->Id = $row['systemlogid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Source = $row['source'];
                $ret[$i]->Event = $row['event'];
                $ret[$i]->Description = $row['description'];
                $i++;
            }
            return $ret;
        }

        public static function Log(Subscriber $subscriber, $event, $source, $description)
        {
            $log = new Fraudlog($subscriber);
            $log->Event = $event;
            $log->Source = $source;
            $log->Description = $description;
            $log->Save();
        }
	}
