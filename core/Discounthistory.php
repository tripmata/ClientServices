<?php
	/* Generated by Wixnit Class Builder 
	// Feb, 25/2020
	// Building class for Discounthistory
	*/

	class Discounthistory
	{
		public $Id = "";
		public $Created = 0;
		public $Discount = "";
		public $Value = 0;
		public $Bypercentage = "";
		public $Amount = "";
		public $Onroom = 0;
		public $Onfood = 0;
		public $Onpastry = 0;
		public $Ondrinks = 0;
		public $Onlaundry = 0;
		public $Onpool = 0;
		public $Onservices = 0;
		public $Invoice = "";
		public $User = "";

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

                $res = $db->query("SELECT * FROM discounthistory WHERE discounthistoryid='$arg'");

                if($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['discounthistoryid'];
                    $this->Created = new WixDate($row['created']);
                    $this->Discount = new Discount($this->subscriber);
                    $this->Discount->Initialize($row['discount']);
                    $this->Value = $row['value'];
                    $this->Bypercentage = $row['bypercentage'];
                    $this->Amount = $row['amount'];
                    $this->Onroom = $row['onroom'];
                    $this->Onfood = $row['onfood'];
                    $this->Onpastry = $row['onpastry'];
                    $this->Ondrinks = $row['ondrinks'];
                    $this->Onlaundry = $row['onlaundry'];
                    $this->Onpool = $row['onpool'];
                    $this->Onservices = $row['onservices'];
                    $this->Invoice = new Invoice($this->subscriber);
                    $this->Invoice->Initialize($row['invoice']);
                    $this->User = new Entity($this->subscriber);
                    $this->User->Initialize($row['user']);
                }
            }
        }

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$discount = addslashes(is_a($this->Discount, "Discount") ? $this->Discount->Id : $this->Discount);
			$value = floatval($this->Value);
			$bypercentage = addslashes($this->Bypercentage);
			$amount = addslashes($this->Amount);
			$onroom = floatval($this->Onroom);
			$onfood = floatval($this->Onfood);
			$onpastry = floatval($this->Onpastry);
			$ondrinks = floatval($this->Ondrinks);
			$onlaundry = floatval($this->Onlaundry);
			$onpool = floatval($this->Onpool);
			$onservices = floatval($this->Onservices);
			$invoice = addslashes(is_a($this->Invoice, "Invoice") ? $this->Invoice->Id : $this->Invoice);
			$user = addslashes(is_a($this->User, "Entity") ? $this->User->Id : $this->User);

			if($res = $db->query("SELECT discounthistoryid FROM discounthistory WHERE discounthistoryid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE discounthistory SET discount='$discount',value='$value',bypercentage='$bypercentage',amount='$amount',onroom='$onroom',onfood='$onfood',onpastry='$onpastry',ondrinks='$ondrinks',onlaundry='$onlaundry',onpool='$onpool',onservices='$onservices',invoice='$invoice',user='$user' WHERE discounthistoryid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT discounthistoryid FROM discounthistory WHERE discounthistoryid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO discounthistory(discounthistoryid,created,discount,value,bypercentage,amount,onroom,onfood,onpastry,ondrinks,onlaundry,onpool,onservices,invoice,user) VALUES ('$id','$created','$discount','$value','$bypercentage','$amount','$onroom','$onfood','$onpastry','$ondrinks','$onlaundry','$onpool','$onservices','$invoice','$user')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM discounthistory WHERE discounthistoryid='$id'");

			//Deleting Associated Objects
			/*n			$this->Discount->Delete();

			$this->Invoice->Delete();

			$this->User->Delete();
			*/
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM discounthistory WHERE discount LIKE '%$term%' OR value LIKE '%$term%' OR bypercentage LIKE '%$term%' OR amount LIKE '%$term%' OR onroom LIKE '%$term%' OR onfood LIKE '%$term%' OR onpastry LIKE '%$term%' OR ondrinks LIKE '%$term%' OR onlaundry LIKE '%$term%' OR onpool LIKE '%$term%' OR onservices LIKE '%$term%' OR invoice LIKE '%$term%' OR user LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Discounthistory($subscriber);
                $ret[$i]->Id = $row['discounthistoryid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Discount = $row['discount'];
                $ret[$i]->Value = $row['value'];
                $ret[$i]->Bypercentage = $row['bypercentage'];
                $ret[$i]->Amount = $row['amount'];
                $ret[$i]->Onroom = $row['onroom'];
                $ret[$i]->Onfood = $row['onfood'];
                $ret[$i]->Onpastry = $row['onpastry'];
                $ret[$i]->Ondrinks = $row['ondrinks'];
                $ret[$i]->Onlaundry = $row['onlaundry'];
                $ret[$i]->Onpool = $row['onpool'];
                $ret[$i]->Onservices = $row['onservices'];
                $ret[$i]->Invoice = $row['invoice'];
                $ret[$i]->User = $row['user'];
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='discounthistoryid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM discounthistory WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Discounthistory($subscriber);
                $ret[$i]->Id = $row['discounthistoryid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Discount = $row['discount'];
                $ret[$i]->Value = $row['value'];
                $ret[$i]->Bypercentage = $row['bypercentage'];
                $ret[$i]->Amount = $row['amount'];
                $ret[$i]->Onroom = $row['onroom'];
                $ret[$i]->Onfood = $row['onfood'];
                $ret[$i]->Onpastry = $row['onpastry'];
                $ret[$i]->Ondrinks = $row['ondrinks'];
                $ret[$i]->Onlaundry = $row['onlaundry'];
                $ret[$i]->Onpool = $row['onpool'];
                $ret[$i]->Onservices = $row['onservices'];
                $ret[$i]->Invoice = $row['invoice'];
                $ret[$i]->User = $row['user'];
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM discounthistory ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Discounthistory($subscriber);
                $ret[$i]->Id = $row['discounthistoryid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Discount = $row['discount'];
                $ret[$i]->Value = $row['value'];
                $ret[$i]->Bypercentage = $row['bypercentage'];
                $ret[$i]->Amount = $row['amount'];
                $ret[$i]->Onroom = $row['onroom'];
                $ret[$i]->Onfood = $row['onfood'];
                $ret[$i]->Onpastry = $row['onpastry'];
                $ret[$i]->Ondrinks = $row['ondrinks'];
                $ret[$i]->Onlaundry = $row['onlaundry'];
                $ret[$i]->Onpool = $row['onpool'];
                $ret[$i]->Onservices = $row['onservices'];
                $ret[$i]->Invoice = $row['invoice'];
                $ret[$i]->User = $row['user'];
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM discounthistory");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Discounthistory($subscriber);
				$ret[$i]->Id = $row['discounthistoryid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Discount = $row['discount'];
				$ret[$i]->Value = $row['value'];
				$ret[$i]->Bypercentage = $row['bypercentage'];
				$ret[$i]->Amount = $row['amount'];
				$ret[$i]->Onroom = $row['onroom'];
				$ret[$i]->Onfood = $row['onfood'];
				$ret[$i]->Onpastry = $row['onpastry'];
				$ret[$i]->Ondrinks = $row['ondrinks'];
				$ret[$i]->Onlaundry = $row['onlaundry'];
				$ret[$i]->Onpool = $row['onpool'];
				$ret[$i]->Onservices = $row['onservices'];
				$ret[$i]->Invoice = $row['invoice'];
				$ret[$i]->User = $row['user'];
				$i++;
			}
			return $ret;
		}
	}