<?php
	/* Generated by Wixnit Class Builder 
	// Feb, 11/2020
	// Building class for Kitcheninventoryactivity
	*/

	class Kitcheninventoryactivity
	{
		public $Id = "";
		public $Created = 0;
		public $Initialstock = 0;
		public $Newstock = 0;
		public $Difference = 0;
		public $Order = "";
		public $Type = "";
		public $Increment = false;
		public $User = "";
		public $Note = "";
		public $Item = "";

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

                $res = $db->query("SELECT * FROM kitcheninventoryactivity WHERE kitcheninventoryactivityid='$arg'");

                if($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['kitcheninventoryactivityid'];
                    $this->Created = new WixDate($row['created']);
                    $this->Initialstock = $row['initialstock'];
                    $this->Newstock = $row['newstock'];
                    $this->Difference = $row['difference'];
                    $this->Order = $row['order_reference'];
                    $this->Type = $row['type'];
                    $this->Increment = Convert::ToBool($row['increment']);
                    $this->User = new User($this->subscriber);
                    $this->User->Initialize($row['user']);
                    $this->Note = $row['note'];
                    $this->Item = new Kitchenitem($this->subscriber);
                    $this->Item->Initialize($row['item']);
                }
            }
        }

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$initialstock = floatval($this->Initialstock);
			$newstock = floatval($this->Newstock);
			$difference = floatval($this->Difference);
			$order = addslashes($this->Order);
			$type = addslashes($this->Type);
			$increment = Convert::ToInt($this->Increment);
			$user = addslashes(is_a($this->User, "User") ? $this->User->Id : $this->User);
			$note = addslashes($this->Note);
			$item = is_a($this->Item, "Kitchenitem") ? $this->Item->Id : $this->Item;

			if($res = $db->query("SELECT kitcheninventoryactivityid FROM kitcheninventoryactivity WHERE kitcheninventoryactivityid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE kitcheninventoryactivity SET initialstock='$initialstock',newstock='$newstock',difference='$difference',order_reference='$order',type='$type',increment='$increment',user='$user',note='$note',item='$item' WHERE kitcheninventoryactivityid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT kitcheninventoryactivityid FROM kitcheninventoryactivity WHERE kitcheninventoryactivityid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO kitcheninventoryactivity(kitcheninventoryactivityid,created,initialstock,newstock,difference,order_reference,type,increment,user,note,item) VALUES ('$id','$created','$initialstock','$newstock','$difference','$order','$type','$increment','$user','$note','$item')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM kitcheninventoryactivity WHERE kitcheninventoryactivityid='$id'");

			//Deleting Associated Objects
			/*n			$this->User->Delete();
			*/
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM kitcheninventoryactivity WHERE initialstock LIKE '%$term%' OR newstock LIKE '%$term%' OR difference LIKE '%$term%' OR order_reference LIKE '%$term%' OR type LIKE '%$term%' OR increment LIKE '%$term%' OR user LIKE '%$term%' OR note LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Kitcheninventoryactivity($subscriber);
                $ret[$i]->Id = $row['kitcheninventoryactivityid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Initialstock = $row['initialstock'];
                $ret[$i]->Newstock = $row['newstock'];
                $ret[$i]->Difference = $row['difference'];
                $ret[$i]->Order = $row['order_reference'];
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Increment = Convert::ToBool($row['increment']);
                $ret[$i]->User = new User($row['user']);
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Item = $row['item'];
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='kitcheninventoryactivityid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM kitcheninventoryactivity WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc( )) != null)
			{
                $ret[$i] = new Kitcheninventoryactivity($subscriber);
                $ret[$i]->Id = $row['kitcheninventoryactivityid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Initialstock = $row['initialstock'];
                $ret[$i]->Newstock = $row['newstock'];
                $ret[$i]->Difference = $row['difference'];
                $ret[$i]->Order = $row['order_reference'];
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Increment = Convert::ToBool($row['increment']);
                $ret[$i]->User = new User($row['user']);
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Item = $row['item'];
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM kitcheninventoryactivity ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Kitcheninventoryactivity($subscriber);
                $ret[$i]->Id = $row['kitcheninventoryactivityid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Initialstock = $row['initialstock'];
                $ret[$i]->Newstock = $row['newstock'];
                $ret[$i]->Difference = $row['difference'];
                $ret[$i]->Order = $row['order_reference'];
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Increment = Convert::ToBool($row['increment']);
                $ret[$i]->User = new User($row['user']);
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Item = $row['item'];
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM kitcheninventoryactivity");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Kitcheninventoryactivity($subscriber);
				$ret[$i]->Id = $row['kitcheninventoryactivityid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Initialstock = $row['initialstock'];
				$ret[$i]->Newstock = $row['newstock'];
				$ret[$i]->Difference = $row['difference'];
				$ret[$i]->Order = $row['order_reference'];
				$ret[$i]->Type = $row['type'];
				$ret[$i]->Increment = Convert::ToBool($row['increment']);
				$ret[$i]->User = new User($row['user']);
				$ret[$i]->Note = $row['note'];
                $ret[$i]->Item = $row['item'];
				$i++;
			}
			return $ret;
		}

        public static function TimelineAll(Subscriber $subscriber, Timespan $span, $item)
        {
            $start = $span->Start;
            $stop = $span->Stop;

            $id = is_a($item, "Kitchenitem") ? $item->Id : $item;

            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $res = $db->query("SELECT * FROM kitcheninventoryactivity WHERE item='$id' AND (created >= '$start') AND (created <= '$stop') ORDER BY created DESC");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Kitcheninventoryactivity($subscriber);
                $ret[$i]->Id = $row['kitcheninventoryactivityid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Initialstock = $row['initialstock'];
                $ret[$i]->Newstock = $row['newstock'];
                $ret[$i]->Difference = $row['difference'];

                ////TODO:
                ///  Add order referece
                $ret[$i]->Order = $row['order_reference'];
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Increment = Convert::ToBool($row['increment']);
                $ret[$i]->User = new User($subscriber);
                $ret[$i]->User->Initialize($row['user']);
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Item = $row['item'];
                $i++;
            }
            return $ret;
        }

        public static function TimelineUsage(Subscriber $subscriber, Timespan $span, $item)
        {
            $start = $span->Start;
            $stop = $span->Stop;

            $id = is_a($item, "Kitchenitem") ? $item->Id : $item;

            $filter = Inventoryactivity::Usage;

            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $res = $db->query("SELECT * FROM kitcheninventoryactivity WHERE item='$id' AND (created >= '$start') AND (created <= '$stop') AND type='$filter' ORDER BY created DESC");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Kitcheninventoryactivity($subscriber);
                $ret[$i]->Id = $row['kitcheninventoryactivityid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Initialstock = $row['initialstock'];
                $ret[$i]->Newstock = $row['newstock'];
                $ret[$i]->Difference = $row['difference'];
                $ret[$i]->Order = $row['order_reference'];
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Increment = Convert::ToBool($row['increment']);
                $ret[$i]->User = new User($subscriber);
                $ret[$i]->User->Initialize($row['user']);
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Item = $row['item'];
                $i++;
            }
            return $ret;
        }

        public static function TimelineRestocking(Subscriber $subscriber, Timespan $span, $item)
        {
            $start = $span->Start;
            $stop = $span->Stop;

            $id = is_a($item, "Kitchenitem") ? $item->Id : $item;

            $filter = Inventoryactivity::Restocking;

            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $res = $db->query("SELECT * FROM kitcheninventoryactivity WHERE item='$id' AND (created >= '$start') AND (created <= '$stop') AND type='$filter' ORDER BY created DESC");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Kitcheninventoryactivity($subscriber);
                $ret[$i]->Id = $row['kitcheninventoryactivityid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Initialstock = $row['initialstock'];
                $ret[$i]->Newstock = $row['newstock'];
                $ret[$i]->Difference = $row['difference'];

                ////TODO:
                // Add order referece
                $ret[$i]->Order = $row['order_reference'];
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Increment = Convert::ToBool($row['increment']);
                $ret[$i]->User = new User($subscriber);
                $ret[$i]->User->Initialize($row['user']);
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Item = $row['item'];
                $i++;
            }
            return $ret;
        }

        public static function TimelineSurplus(Subscriber $subscriber, Timespan $span, $item)
        {
            $start = $span->Start;
            $stop = $span->Stop;

            $id = is_a($item, "Kitchenitem") ? $item->Id : $item;

            $filter = Inventoryactivity::Surplus;

            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $res = $db->query("SELECT * FROM kitcheninventoryactivity WHERE item='$id' AND (created >= '$start') AND (created <= '$stop') AND type='$filter' ORDER BY created DESC");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Kitcheninventoryactivity($subscriber);
                $ret[$i]->Id = $row['kitcheninventoryactivityid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Initialstock = $row['initialstock'];
                $ret[$i]->Newstock = $row['newstock'];
                $ret[$i]->Difference = $row['difference'];
                $ret[$i]->Order = $row['order_reference'];
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Increment = Convert::ToBool($row['increment']);
                $ret[$i]->User = new User($subscriber);
                $ret[$i]->User->Initialize($row['user']);
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Item = $row['item'];
                $i++;
            }
            return $ret;
        }

        public static function TimelineDamages(Subscriber $subscriber, Timespan $span, $item)
        {
            $start = $span->Start;
            $stop = $span->Stop;

            $id = is_a($item, "Kitchenitem") ? $item->Id : $item;

            $filter = Inventoryactivity::Damage;

            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $res = $db->query("SELECT * FROM kitcheninventoryactivity WHERE item='$id' AND (created >= '$start') AND (created <= '$stop') AND type='$filter' ORDER BY created DESC");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Kitcheninventoryactivity($subscriber);
                $ret[$i]->Id = $row['kitcheninventoryactivityid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Initialstock = $row['initialstock'];
                $ret[$i]->Newstock = $row['newstock'];
                $ret[$i]->Difference = $row['difference'];
                $ret[$i]->Order = $row['order_reference'];
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Increment = Convert::ToBool($row['increment']);
                $ret[$i]->User = new User($subscriber);
                $ret[$i]->User->Initialize($row['user']);
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Item = $row['item'];
                $i++;
            }
            return $ret;
        }

        public static function TimelineReturns(Subscriber $subscriber, Timespan $span, $item)
        {
            $start = $span->Start;
            $stop = $span->Stop;

            $id = is_a($item, "Kitchenitem") ? $item->Id : $item;

            $filter = Inventoryactivity::Returned;

            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $res = $db->query("SELECT * FROM kitcheninventoryactivity WHERE item='$id' AND (created >= '$start') AND (created <= '$stop') AND type='$filter' ORDER BY created DESC");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Kitcheninventoryactivity($subscriber);
                $ret[$i]->Id = $row['kitcheninventoryactivityid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Initialstock = $row['initialstock'];
                $ret[$i]->Newstock = $row['newstock'];
                $ret[$i]->Difference = $row['difference'];
                $ret[$i]->Order = $row['order_reference'];
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Increment = Convert::ToBool($row['increment']);
                $ret[$i]->User = new User($subscriber);
                $ret[$i]->User->Initialize($row['user']);
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Item = $row['item'];
                $i++;
            }
            return $ret;
        }

        public static function Lastsale(Subscriber $subscriber, Kitchenitem $kitchenitem)
        {
            $ret = null;
            $type = Inventoryactivity::Sold;
            $db = $subscriber->GetDB();

            $id = is_a($kitchenitem, "Kitchenitem") ? $kitchenitem->Id : $kitchenitem;

            $res = $db->query("SELECT * FROM kitcheninventoryactivity WHERE type='$type' AND item='$id' ORDER BY created DESC LIMIT 1");
            if($res->num_rows > 0)
            {
                $row = $res->fetch_assoc();

                $ret = new Kitcheninventoryactivity($subscriber);
                $ret->Id = $row['kitcheninventoryactivityid'];
                $ret->Created = new WixDate($row['created']);
                $ret->Initialstock = $row['initialstock'];
                $ret->Newstock = $row['newstock'];
                $ret->Difference = $row['difference'];
                $ret->Order = $row['order_reference'];
                $ret->Type = $row['type'];
                $ret->Increment = Convert::ToBool($row['increment']);
                $ret->User = $row['user'];
                $ret->Note = $row['note'];
                $ret->Item = $row['item'];
            }
            return $ret;
        }
	}
