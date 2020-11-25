<?php
	/* Generated by Wixnit Class Builder 
	// Mar, 11/2020
	// Building class for Purchaseorderitem
	*/

	class Purchaseorderitem
	{
		public $Id = "";
		public $Created = 0;
		public $Item = "";
		public $Quantity = 0;
		public $Supplied = 0;
		public $Rate = 0;
		public $Po = "";

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

				$res = $db->query("SELECT * FROM purchaseorderitem WHERE purchaseorderitemid='$arg'");

				if($res->num_rows > 0)
				{
					$row = $res->fetch_assoc();
				
					$this->Id = $row['purchaseorderitemid'];
					$this->Created = new WixDate($row['created']);
					$this->Item = $row['item'];
					$this->Quantity = Convert::ToInt($row['quantity']);
					$this->Supplied = Convert::ToInt($row['supplied']);
					$this->Rate = doubleval($row['rate']);
					$this->Po = $row['po'];
				}
			}
		}

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$item = addslashes(is_string($this->Item) ? $this->Item : $this->Item->Id);
			$quantity = Convert::ToInt($this->Quantity);
			$supplied = Convert::ToInt($this->Supplied);
			$rate = floatval($this->Rate);
			$po = addslashes($this->Po);

			if($res = $db->query("SELECT purchaseorderitemid FROM purchaseorderitem WHERE purchaseorderitemid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE purchaseorderitem SET item='$item',quantity='$quantity',supplied='$supplied',rate='$rate',po='$po' WHERE purchaseorderitemid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT purchaseorderitemid FROM purchaseorderitem WHERE purchaseorderitemid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO purchaseorderitem(purchaseorderitemid,created,item,quantity,supplied,rate,po) VALUES ('$id','$created','$item','$quantity','$supplied','$rate','$po')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM purchaseorderitem WHERE purchaseorderitemid='$id'");
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT purchaseorderitemid FROM purchaseorderitem WHERE item LIKE '%$term%' OR quantity LIKE '%$term%' OR supplied LIKE '%$term%' OR rate LIKE '%$term%' OR po LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Purchaseorderitem($subscriber);
                $ret[$i]->Id = $row['purchaseorderitemid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Item = $row['item'];
                $ret[$i]->Quantity = Convert::ToInt($row['quantity']);
                $ret[$i]->Supplied = Convert::ToInt($row['supplied']);
                $ret[$i]->Rate = doubleval($row['rate']);
                $ret[$i]->Po = $row['po'];
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='purchaseorderitemid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT purchaseorderitemid FROM purchaseorderitem WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Purchaseorderitem($subscriber);
                $ret[$i]->Id = $row['purchaseorderitemid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Item = $row['item'];
                $ret[$i]->Quantity = Convert::ToInt($row['quantity']);
                $ret[$i]->Supplied = Convert::ToInt($row['supplied']);
                $ret[$i]->Rate = doubleval($row['rate']);
                $ret[$i]->Po = $row['po'];
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT purchaseorderitemid FROM purchaseorderitem ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Purchaseorderitem($subscriber);
                $ret[$i]->Id = $row['purchaseorderitemid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Item = $row['item'];
                $ret[$i]->Quantity = Convert::ToInt($row['quantity']);
                $ret[$i]->Supplied = Convert::ToInt($row['supplied']);
                $ret[$i]->Rate = doubleval($row['rate']);
                $ret[$i]->Po = $row['po'];
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM purchaseorderitem");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Purchaseorderitem($subscriber);
				$ret[$i]->Id = $row['purchaseorderitemid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Item = $row['item'];
				$ret[$i]->Quantity = Convert::ToInt($row['quantity']);
				$ret[$i]->Supplied = Convert::ToInt($row['supplied']);
				$ret[$i]->Rate = doubleval($row['rate']);
				$ret[$i]->Po = $row['po'];
				$i++;
			}
			return $ret;
		}
	}