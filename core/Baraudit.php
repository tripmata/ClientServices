<?php
	/* Generated by Wixnit Class Builder 
	// Feb, 15/2020
	// Building class for Baraudit
	*/

	class Baraudit
	{
		public $Id = "";
		public $Created = 0;
		public $Title = "";
		public $Items = array();
		public $Surplus = 0;
		public $Shortage = 0;
		public $Surplustotal = 0;
		public $Shortagetotal = 0;

		private $subscriber = null;

        public $Accuratestock = 0;
        public $Shortagestock = 0;
        public $Surplusstock = 0;

		public $Type = "bar_audit";

		function __construct(Subscriber $subscriber)
		{
			$this->subscriber = $subscriber;
		}

		public function Initialize($arg=null)
        {
            if($arg != null)
            {
                $db = $this->subscriber->GetDB();

                $res = $db->query("SELECT * FROM baraudit WHERE barauditid='$arg'");

                if($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['barauditid'];
                    $this->Created = new WixDate($row['created']);
                    $this->Title = $row['title'];
                    $this->Items = [];
                    $this->Surplus = $row['surplus'];
                    $this->Shortage = $row['shortage'];
                    $this->Surplustotal = $row['surplustotal'];
                    $this->Shortagetotal = $row['shortagetotal'];


                    $it = json_decode($row['items']);

                    for($i = 0; $i < count($it); $i++)
                    {
                        if($it[$i] != "")
                        {
                            $t = new Audititem($this->subscriber);
                            $t->Initialize($it[$i]);

                            array_push($this->Items, $t);
                        }
                    }
                }
            }
        }

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$title = addslashes($this->Title);

			$surplus = Convert::ToInt($this->Surplus);
			$shortage = Convert::ToInt($this->Shortage);
			$surplustotal = Convert::ToInt($this->Surplustotal);
			$shortagetotal = Convert::ToInt($this->Shortagetotal);

            $it = [];
            for($i = 0; $i < count($this->Items); $i++)
            {
                if(is_a($this->Items[$i], "Audititem"))
                {
                    array_push($it, $this->Items[$i]->Id);
                }
                else
                {
                    array_push($it, $this->Items[$i]);
                }
            }
            $items = addslashes(json_encode($it));

			if($res = $db->query("SELECT barauditid FROM baraudit WHERE barauditid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE baraudit SET title='$title',items='$items',surplus='$surplus',shortage='$shortage',surplustotal='$surplustotal',shortagetotal='$shortagetotal' WHERE barauditid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT barauditid FROM baraudit WHERE barauditid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO baraudit(barauditid,created,title,items,surplus,shortage,surplustotal,shortagetotal) VALUES ('$id','$created','$title','$items','$surplus','$shortage','$surplustotal','$shortagetotal')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM baraudit WHERE barauditid='$id'");
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM baraudit WHERE title LIKE '%$term%' OR items LIKE '%$term%' OR surplus LIKE '%$term%' OR shortage LIKE '%$term%' OR surplustotal LIKE '%$term%' OR shortagetotal LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Baraudit($subscriber);
                $ret[$i]->Id = $row['barauditid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Title = $row['title'];
                $ret[$i]->Items = json_decode($row['items']);
                $ret[$i]->Surplus = $row['surplus'];
                $ret[$i]->Shortage = $row['shortage'];
                $ret[$i]->Surplustotal = $row['surplustotal'];
                $ret[$i]->Shortagetotal = $row['shortagetotal'];
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='barauditid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM baraudit WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Baraudit($subscriber);
                $ret[$i]->Id = $row['barauditid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Title = $row['title'];
                $ret[$i]->Items = json_decode($row['items']);
                $ret[$i]->Surplus = $row['surplus'];
                $ret[$i]->Shortage = $row['shortage'];
                $ret[$i]->Surplustotal = $row['surplustotal'];
                $ret[$i]->Shortagetotal = $row['shortagetotal'];
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM baraudit ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Baraudit($subscriber);
                $ret[$i]->Id = $row['barauditid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Title = $row['title'];
                $ret[$i]->Items = json_decode($row['items']);
                $ret[$i]->Surplus = $row['surplus'];
                $ret[$i]->Shortage = $row['shortage'];
                $ret[$i]->Surplustotal = $row['surplustotal'];
                $ret[$i]->Shortagetotal = $row['shortagetotal'];
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM baraudit");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Baraudit($subscriber);
				$ret[$i]->Id = $row['barauditid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Title = $row['title'];
				$ret[$i]->Items = json_decode($row['items']);
				$ret[$i]->Surplus = $row['surplus'];
				$ret[$i]->Shortage = $row['shortage'];
				$ret[$i]->Surplustotal = $row['surplustotal'];
				$ret[$i]->Shortagetotal = $row['shortagetotal'];
				$i++;
			}
			return $ret;
		}


        public function InitItems()
        {
            for($i = 0; $i < count($this->Items); $i++)
            {
                if(!is_a($this->Items[$i], "Audititem"))
                {
                    $it = $this->Items[$i];
                    $this->Items[$i] = new Audititem($this->subscriber);
                    $this->Items[$i]->Initialize($it);
                }
            }
        }

        public function InitInnerItems()
        {
            $this->InitItems();

            for($i = 0; $i < count($this->Items); $i++)
            {
                if(is_a($this->Items[$i], "Audititem"))
                {
                    $it = $this->Items[$i]->Item;
                    $this->Items[$i]->Item = new Baritem($this->subscriber);
                    $this->Items[$i]->Item->Initialize($it);
                }
            }
        }

        public function initStockCount()
        {
            $this->Accuratestock = $this->AccurateStockCount();
            $this->Shortagestock = $this->ShortageStockCount();
            $this->Surplusstock = $this->SurplusStockCount();
        }


        public function AccurateStockCount()
        {
            $ret = 0;
            $this->InitItems();
            for($i = 0; $i < count($this->Items); $i++)
            {
                if(Convert::ToInt($this->Items[$i]->Counted) == Convert::ToInt($this->Items[$i]->Stock))
                {
                    $ret++;
                }
            }
            return $ret;
        }

        public function SurplusStockCount()
        {
            $ret = 0;
            $this->InitItems();
            for($i = 0; $i < count($this->Items); $i++)
            {
                if(Convert::ToInt($this->Items[$i]->Counted) > Convert::ToInt($this->Items[$i]->Stock))
                {
                    $ret++;
                }
            }
            return $ret;
        }

        public function ShortageStockCount()
        {
            $ret = 0;
            $this->InitItems();
            for($i = 0; $i < count($this->Items); $i++)
            {
                if(Convert::ToInt($this->Items[$i]->Counted) < Convert::ToInt($this->Items[$i]->Stock))
                {
                    $ret++;
                }
            }
            return $ret;
        }
	}
