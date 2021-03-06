<?php
	/* Generated by Wixnit Class Builder 
	// Feb, 25/2020
	// Building class for Barorder
	*/

	class Barorder
	{
		public $Id = "";
		public $Created = 0;
		public $Customer = "";
		public $Drinkpixel = array();
		public $Total = 0;
		public $Taxes = 0;
		public $Discount = 0;
		public $Invoice = "";
		public $Room = "";
		public $Paid = false;
		public $Fullfilled = false;

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

                $res = $db->query("SELECT * FROM barorder WHERE barorderid='$arg'");

                if($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['barorderid'];
                    $this->Created = new WixDate($row['created']);
                    $this->Customer = new Customer($this->subscriber);
                    $this->Customer->Initialize($row['customer']);
                    $this->Drinkpixel = [];

                    $px =  json_decode($row['drinkpixel']);

                    for($i = 0; $i < count($px); $i++)
                    {
                        if($px != "")
                        {
                            $p = new Drinkpixel($this->subscriber, $px[$i]);
                            array_push($this->Drinkpixel, $p);
                        }
                    }

                    $this->Total = doubleval($row['total']);
                    $this->Taxes = doubleval($row['taxes']);
                    $this->Discount = doubleval($row['discount']);
                    //$this->Invoice = new Invoice($this->subscriber);
                    //$this->Invoice->Initialize($row['invoice']);
                    $this->Room = new Room($this->subscriber);
                    $this->Room->Initialize($row['room']);
                    $this->Paid = Convert::ToBool($row['paid']);
                    $this->Fullfilled = Convert::ToBool($row['fullfilled']);
                }
            }
        }

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$customer = addslashes(is_a($this->Customer, "Customer") ? $this->Customer->Id : $this->Customer);

			$total = addslashes($this->Total);
			$taxes = addslashes($this->Taxes);
			$discount = addslashes($this->Discount);
			$invoice = addslashes(is_a($this->Invoice, "Invoice") ? $this->Invoice->Id : $this->Invoice);
			$room = addslashes(is_a($this->Room, "Room") ? $this->Room->Id : $this->Room);
			$paid = Convert::ToInt($this->Paid);
			$fullfilled = Convert::ToInt($this->Fullfilled);

            $px = [];
            for($i = 0; $i < count($this->Drinkpixel); $i++)
            {
                array_push($px, is_a($this->Drinkpixel[$i], "Drinkpixel") ? $this->Drinkpixel[$i]->Pixelate() : $this->Drinkpixel[$i]);
            }
            $drinkpixel = json_encode($px);

			if($res = $db->query("SELECT barorderid FROM barorder WHERE barorderid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE barorder SET customer='$customer',drinkpixel='$drinkpixel',total='$total',taxes='$taxes',discount='$discount',invoice='$invoice',room='$room',paid='$paid',fullfilled='$fullfilled' WHERE barorderid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT barorderid FROM barorder WHERE barorderid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO barorder(barorderid,created,customer,drinkpixel,total,taxes,discount,invoice,room,paid,fullfilled) VALUES ('$id','$created','$customer','$drinkpixel','$total','$taxes','$discount','$invoice','$room','$paid','$fullfilled')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM barorder WHERE barorderid='$id'");

			//Deleting Associated Objects
			/*n			$this->Customer->Delete();

			$this->Drinkpixel->Delete();

			$this->Invoice->Delete();

			$this->Room->Delete();
			*/
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM barorder WHERE customer LIKE '%$term%' OR drinkpixel LIKE '%$term%' OR total LIKE '%$term%' OR taxes LIKE '%$term%' OR discount LIKE '%$term%' OR invoice LIKE '%$term%' OR room LIKE '%$term%' OR paid LIKE '%$term%' OR fullfilled LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Barorder($subscriber);
                $ret[$i]->Id = $row['barorderid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Customer = new Customer($subscriber);
                $ret[$i]->Customer->Initialize($row['customer']);
                $ret[$i]->Drinkpixel = json_decode($row['drinkpixel']);
                $ret[$i]->Total = $row['total'];
                $ret[$i]->Taxes = $row['taxes'];
                $ret[$i]->Discount = $row['discount'];
                //$ret[$i]->Invoice = new Invoice($subscriber);
                //$ret[$i]->Invoice->Initialize($row['invoice']);
                $ret[$i]->Room = Lodging::Rooms($subscriber, $ret[$i]->Customer);
                $ret[$i]->Paid = Convert::ToBool($row['paid']);
                $ret[$i]->Fullfilled = Convert::ToBool($row['fullfilled']);
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='barorderid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM barorder WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Barorder($subscriber);
                $ret[$i]->Id = $row['barorderid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Customer = new Customer($subscriber);
                $ret[$i]->Customer->Initialize($row['customer']);
                $ret[$i]->Drinkpixel = [];

                $px =  json_decode($row['drinkpixel']);

                for($j = 0; $j < count($px); $j++)
                {
                    if($px != "")
                    {
                        $p = new Drinkpixel($subscriber, $px[$j]);
                        array_push($ret[$i]->Drinkpixel, $p);
                    }
                }
                $ret[$i]->Total = $row['total'];
                $ret[$i]->Taxes = $row['taxes'];
                $ret[$i]->Discount = $row['discount'];
                //$ret[$i]->Invoice = new Invoice($subscriber);
                //$ret[$i]->Invoice->Initialize($row['invoice']);
                $ret[$i]->Room = Lodging::Rooms($subscriber, $ret[$i]->Customer);
                $ret[$i]->Paid = Convert::ToBool($row['paid']);
                $ret[$i]->Fullfilled = Convert::ToBool($row['fullfilled']);
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM barorder ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Barorder($subscriber);
                $ret[$i]->Id = $row['barorderid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Customer = new Customer($subscriber);
                $ret[$i]->Customer->Initialize($row['customer']);
                $ret[$i]->Drinkpixel = json_decode($row['drinkpixel']);
                $ret[$i]->Total = $row['total'];
                $ret[$i]->Taxes = $row['taxes'];
                $ret[$i]->Discount = $row['discount'];
                //$ret[$i]->Invoice = new Invoice($subscriber);
                //$ret[$i]->Invoice->Initialize($row['invoice']);
                $ret[$i]->Room = Lodging::Rooms($subscriber, $ret[$i]->Customer);
                $ret[$i]->Paid = Convert::ToBool($row['paid']);
                $ret[$i]->Fullfilled = Convert::ToBool($row['fullfilled']);
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM barorder");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Barorder($subscriber);
				$ret[$i]->Id = $row['barorderid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Customer = new Customer($subscriber);
				$ret[$i]->Customer->Initialize($row['customer']);
				$ret[$i]->Drinkpixel = json_decode($row['drinkpixel']);
				$ret[$i]->Total = $row['total'];
				$ret[$i]->Taxes = $row['taxes'];
				$ret[$i]->Discount = $row['discount'];
				//$ret[$i]->Invoice = new Invoice($subscriber);
				//$ret[$i]->Invoice->Initialize($row['invoice']);
				$ret[$i]->Room = Lodging::Rooms($subscriber, $ret[$i]->Customer);
				$ret[$i]->Paid = Convert::ToBool($row['paid']);
				$ret[$i]->Fullfilled = Convert::ToBool($row['fullfilled']);
				$i++;
			}
			return $ret;
		}
	}
