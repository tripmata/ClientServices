<?php
	/* Generated by Wixnit Class Builder 
	// Mar, 11/2020
	// Building class for Lodginghistory
	*/

	class Lodginghistory
	{
		public $Id = "";
		public $Created = 0;
		public $Guest = "";
		public $Subguest = array();
		public $Rooms = array();
		public $Checkin = 0;
		public $Checkout = 0;
		public $Days = 0;
		public $Adults = 0;
		public $Children = 0;
		public $Pet = false;
		public $Paid = false;
		public $Total = 0;
		public $Taxes = 0;
		public $Discount = 0;
		public $Paidamount = 0;
		public $Roomcategory = array();
		public $User = "";
		public $Checkouts = array();

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

				$res = $db->query("SELECT * FROM lodginghistory WHERE lodginghistoryid='$arg'");

				if($res->num_rows > 0)
				{
					$row = $res->fetch_assoc();
				
					$this->Id = $row['lodginghistoryid'];
					$this->Created = new WixDate($row['created']);
					$this->Guest = new CustomerByProperty($this->subscriber);
					$this->Guest->Initialize($row['guest']);
					$this->Subguest = [];

					$guest = json_decode($row['subguest']);
					for($i = 0; $i < count($guest); $i++)
                    {
                        if($guest[$i] != "")
                        {
                            $g = new Subguest($this->subscriber);
                            $g->Initialize($guest[$i]);

                            array_push($this->Subguest, $g);
                        }
                    }



					$this->Rooms = [];

                    $room = json_decode($row['rooms']);
                    for($i = 0; $i < count($room); $i++)
                    {
                        if($room[$i] != "")
                        {
                            $r = new Lodgingitem($this->subscriber);
                            $r->Initialize($room[$i]);

                            array_push($this->Rooms, $r);
                        }
                    }


					$this->Checkin = new WixDate($row['checkin']);
					$this->Checkout = new WixDate($row['checkout']);
					$this->Days = Convert::ToInt($row['days']);
					$this->Adults = Convert::ToInt($row['adults']);
					$this->Children = Convert::ToInt($row['children']);
					$this->Pet = Convert::ToBool($row['pet']);
					$this->Paid = Convert::ToBool($row['paid']);
					$this->Total = doubleval($row['total']);
					$this->Taxes = doubleval($row['taxes']);
					$this->Discount = doubleval($row['discount']);
					$this->Paidamount = doubleval($row['paidamount']);

					$this->Roomcategory = [];
                    $rcat = json_decode($row['roomcategory']);
                    for($i = 0; $i < count($rcat); $i++)
                    {
                        if($rcat[$i] != "")
                        {
                            $r = new Roomcategory($this->subscriber);
                            $r->Initialize($rcat[$i]);

                            array_push($this->Roomcategory, $r);
                        }
                    }


					$this->User = new User($this->subscriber);
					$this->User->Initialize($row['user']);

					$this->Checkouts = [];
                    $dates = json_decode($row['checkouts']);
                    for($i = 0; $i < count($dates); $i++)
                    {
                        if($dates[$i] != "")
                        {
                            array_push($this->Checkouts, new WixDate($dates[$i]));
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
			$guest = addslashes(is_a($this->Guest, "Guest") ? $this->Guest->Id : $this->Guest);
			$subguest = "[]";
			$rooms = "[]";
			$checkin = Convert::ToInt($this->Checkin);
			$checkout = Convert::ToInt($this->Checkout);
			$days = Convert::ToInt($this->Days);
			$adults = Convert::ToInt($this->Adults);
			$children = Convert::ToInt($this->Children);
			$pet = Convert::ToInt($this->Pet);
			$paid = Convert::ToInt($this->Paid);
			$total = floatval($this->Total);
			$taxes = floatval($this->Taxes);
			$discount = floatval($this->Discount);
			$paidamount = floatval($this->Paidamount);
			$roomcategory = addslashes(json_encode(is_a($this->Roomcategory, "Roomcategory") ? $this->Roomcategory->GetArray() : $this->Roomcategory));
			$user = addslashes(is_a($this->User, "User") ? $this->User->Id : $this->User);
			$checkouts = "[]";

			$ck = [];
			for($i = 0; $i < count($this->Checkouts); $i++)
            {
                array_push($ck, Convert::ToInt($this->Checkouts));
            }
			$checkouts = json_encode($ck);


            $sg = [];
            for($i = 0; $i < count($this->Subguest); $i++)
            {
                array_push($sg, is_a($this->Subguest[$i], "Subguest") ? $this->Subguest[$i]->Id : $this->Subguest[$i]);
            }
            $subguest = json_encode($sg);


            $rms = [];
            for($i = 0; $i < count($this->Rooms); $i++)
            {
                array_push($rms, is_a($this->Rooms[$i], "Lodgingitem") ? $this->Rooms[$i]->Id : $this->Rooms[$i]);
            }
            $rooms = json_encode($rms);


			if($res = $db->query("SELECT lodginghistoryid FROM lodginghistory WHERE lodginghistoryid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE lodginghistory SET guest='$guest',subguest='$subguest',rooms='$rooms',checkin='$checkin',checkout='$checkout',days='$days',adults='$adults',children='$children',pet='$pet',paid='$paid',total='$total',taxes='$taxes',discount='$discount',paidamount='$paidamount',roomcategory='$roomcategory',user='$user',checkouts='$checkouts' WHERE lodginghistoryid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT lodginghistoryid FROM lodginghistory WHERE lodginghistoryid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO lodginghistory(lodginghistoryid,created,guest,subguest,rooms,checkin,checkout,days,adults,children,pet,paid,total,taxes,discount,paidamount,roomcategory,user,checkouts) VALUES ('$id','$created','$guest','$subguest','$rooms','$checkin','$checkout','$days','$adults','$children','$pet','$paid','$total','$taxes','$discount','$paidamount','$roomcategory','$user','$checkouts')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM lodginghistory WHERE lodginghistoryid='$id'");

			//Deleting Associated Objects
			/*n			$this->Guest->Delete();

			$this->Subguest->Delete();

			$this->Rooms->Delete();

			$this->Roomcategory->Delete();

			$this->User->Delete();
			*/
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM lodginghistory WHERE guest LIKE '%$term%' OR subguest LIKE '%$term%' OR rooms LIKE '%$term%' OR checkin LIKE '%$term%' OR checkout LIKE '%$term%' OR days LIKE '%$term%' OR adults LIKE '%$term%' OR children LIKE '%$term%' OR pet LIKE '%$term%' OR paid LIKE '%$term%' OR total LIKE '%$term%' OR taxes LIKE '%$term%' OR discount LIKE '%$term%' OR paidamount LIKE '%$term%' OR roomcategory LIKE '%$term%' OR user LIKE '%$term%' OR checkouts LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Lodginghistory($subscriber);
                $ret[$i]->Id = $row['lodginghistoryid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Guest = $row['guest'];
                $ret[$i]->Subguest = json_decode($row['subguest']);
                $ret[$i]->Rooms = json_decode($row['rooms']);
                $ret[$i]->Checkin = new WixDate($row['checkin']);
                $ret[$i]->Checkout = new WixDate($row['checkout']);
                $ret[$i]->Days = Convert::ToInt($row['days']);
                $ret[$i]->Adults = Convert::ToInt($row['adults']);
                $ret[$i]->Children = Convert::ToInt($row['children']);
                $ret[$i]->Pet = Convert::ToBool($row['pet']);
                $ret[$i]->Paid = Convert::ToBool($row['paid']);
                $ret[$i]->Total = doubleval($row['total']);
                $ret[$i]->Taxes = doubleval($row['taxes']);
                $ret[$i]->Discount = doubleval($row['discount']);
                $ret[$i]->Paidamount = doubleval($row['paidamount']);
                $ret[$i]->Roomcategory = json_decode($row['roomcategory']);
                $ret[$i]->User = $row['user'];
                $ret[$i]->Checkouts = json_decode($row['checkouts']);
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='lodginghistoryid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM lodginghistory WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Lodginghistory($subscriber);
                $ret[$i]->Id = $row['lodginghistoryid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Guest = $row['guest'];
                $ret[$i]->Subguest = json_decode($row['subguest']);
                $ret[$i]->Rooms = json_decode($row['rooms']);
                $ret[$i]->Checkin = new WixDate($row['checkin']);
                $ret[$i]->Checkout = new WixDate($row['checkout']);
                $ret[$i]->Days = Convert::ToInt($row['days']);
                $ret[$i]->Adults = Convert::ToInt($row['adults']);
                $ret[$i]->Children = Convert::ToInt($row['children']);
                $ret[$i]->Pet = Convert::ToBool($row['pet']);
                $ret[$i]->Paid = Convert::ToBool($row['paid']);
                $ret[$i]->Total = doubleval($row['total']);
                $ret[$i]->Taxes = doubleval($row['taxes']);
                $ret[$i]->Discount = doubleval($row['discount']);
                $ret[$i]->Paidamount = doubleval($row['paidamount']);
                $ret[$i]->Roomcategory = json_decode($row['roomcategory']);
                $ret[$i]->User = $row['user'];
                $ret[$i]->Checkouts = json_decode($row['checkouts']);
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM lodginghistory ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Lodginghistory($subscriber);
                $ret[$i]->Id = $row['lodginghistoryid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Guest = $row['guest'];
                $ret[$i]->Subguest = json_decode($row['subguest']);
                $ret[$i]->Rooms = json_decode($row['rooms']);
                $ret[$i]->Checkin = new WixDate($row['checkin']);
                $ret[$i]->Checkout = new WixDate($row['checkout']);
                $ret[$i]->Days = Convert::ToInt($row['days']);
                $ret[$i]->Adults = Convert::ToInt($row['adults']);
                $ret[$i]->Children = Convert::ToInt($row['children']);
                $ret[$i]->Pet = Convert::ToBool($row['pet']);
                $ret[$i]->Paid = Convert::ToBool($row['paid']);
                $ret[$i]->Total = doubleval($row['total']);
                $ret[$i]->Taxes = doubleval($row['taxes']);
                $ret[$i]->Discount = doubleval($row['discount']);
                $ret[$i]->Paidamount = doubleval($row['paidamount']);
                $ret[$i]->Roomcategory = json_decode($row['roomcategory']);
                $ret[$i]->User = $row['user'];
                $ret[$i]->Checkouts = json_decode($row['checkouts']);
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM lodginghistory");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Lodginghistory($subscriber);
				$ret[$i]->Id = $row['lodginghistoryid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Guest = $row['guest'];
				$ret[$i]->Subguest = json_decode($row['subguest']);
				$ret[$i]->Rooms = json_decode($row['rooms']);
				$ret[$i]->Checkin = new WixDate($row['checkin']);
				$ret[$i]->Checkout = new WixDate($row['checkout']);
				$ret[$i]->Days = Convert::ToInt($row['days']);
				$ret[$i]->Adults = Convert::ToInt($row['adults']);
				$ret[$i]->Children = Convert::ToInt($row['children']);
				$ret[$i]->Pet = Convert::ToBool($row['pet']);
				$ret[$i]->Paid = Convert::ToBool($row['paid']);
				$ret[$i]->Total = doubleval($row['total']);
				$ret[$i]->Taxes = doubleval($row['taxes']);
				$ret[$i]->Discount = doubleval($row['discount']);
				$ret[$i]->Paidamount = doubleval($row['paidamount']);
				$ret[$i]->Roomcategory = json_decode($row['roomcategory']);
				$ret[$i]->User = $row['user'];
				$ret[$i]->Checkouts = json_decode($row['checkouts']);
				$i++;
			}
			return $ret;
		}


		//Hand crafted
        public static function LodgeCount(Subscriber $subscriber, Customer $customer)
        {
            return 0;
        }

        public static function GetGuest(Subscriber $subscriber, Customer $customer)
        {
            return new Guest($subscriber);
        }

        public static function isLodged(Subscriber $subscriber, Customer $customer)
        {
            if($customer->Id != "")
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public static function Rooms(Subscriber $subscriber, Customer $customer)
        {
            if($customer->Id != "")
            {
                $rooms = [];
                $rooms[0] = new Room($subscriber);
                $rooms[0]->Number = "101";
                return $rooms;
            }
            else
            {
                return null;
            }
        }

        public function Lodgeddays()
        {

        }

        public function LodgedByPercentage()
        {

        }
	}
