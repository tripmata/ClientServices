<?php
	/* Generated by Wixnit Class Builder 
	// Sep, 03/2019
	// Building class for Roomcategory
	*/

    class Roomcategory
	{
		public $Id = "";
		public $Created = 0;
		public $Name = "";
		public $Promotext = "";
		public $Status = false;
		public $Reservable = false;
		public $Showpromotion = false;
		public $Onsite = false;
		public $Sort = 0;
		public $Description = "";
		public $Price = 0;
		public $Baseprice = 0;
		public $Compareat = 0;
		public $Images = array();
		public $Features = array();
		public $Services = array();
		public $Baseoccupancy = 0;
		public $Maxoccupancy = 0;
		public $Extraguestprice = 0.0;

		public $Smokingpolicy = false;
		public $Childrenpolicy = true;

		public $Pets = false;
		
		public $Rooms = 0;
		public $Occupied = 0;

		public $Meta = "";

		private $subscriber = null;

		function __construct(Subscriber $subscriber)
		{
			$this->subscriber = $subscriber;
		}

		public  function Initialize($arg=null)
        {
            if($arg != null)
            {
                $db = $this->subscriber->GetDB();

                $res = $db->query("SELECT * FROM roomcategory WHERE roomcategoryid='$arg'");

                if($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['roomcategoryid'];
                    $this->Created = new WixDate($row['created']);
                    $this->Name = $row['name'];
                    $this->Promotext = $row['promotext'];
                    $this->Status = Convert::ToBool($row['status']);
                    $this->Reservable = Convert::ToBool($row['reservable']);
                    $this->Showpromotion = Convert::ToBool($row['showpromotion']);
                    $this->Onsite = Convert::ToBool($row['onsite']);
                    $this->Sort = $row['sort'];
                    $this->Description = $row['description'];
                    $this->Price = $row['price'];
                    $this->Baseprice = $row['price'];
                    $this->Compareat = $row['compareat'];
                    $this->Images = json_decode($row['images']);
                    $this->Features = json_decode($row['features']);
                    $this->Services = json_decode($row['services']);
                    $this->Baseoccupancy = Convert::ToInt($row['baseoccupancy']);
                    $this->Maxoccupancy = Convert::ToInt($row['maxoccupancy']);
                    $this->Extraguestprice = floatval($row['extrapersonprice']);
                    $this->Smokingpolicy = Convert::ToInt($row['smoking']);
                    $this->Childrenpolicy = Convert::ToInt($row['childrenpolicy']);
                    $this->Pets = Convert::ToBool($row['pets']);
                    $this->Meta = $row['meta'];

                    $rates = Roomrate::ByRoomtype($this->subscriber, $this->Id, false);
                    for($j = 0; $j < count($rates); $j++)
                    {
                        if(($rates[$j]->Startdate->getValue() <= time()) && (($rates[$j]->Stopdate->getValue() + ((60 * 60) * 24)) >= time()))
                        {
                            $this->Price = $rates[$j]->Rate;

                            if($this->Compareat > 0)
                            {
                                if($this->Compareat > $this->Price)
                                {
                                    $this->Compareat = 0;
                                }
                            }
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
			$name = addslashes($this->Name);
			$promotext = addslashes($this->Promotext);
			$status = Convert::ToInt($this->Status);
			$reservable = Convert::ToInt($this->Reservable);
			$showpromotion = Convert::ToInt($this->Showpromotion);
			$onsite = Convert::ToInt($this->Onsite);
			$sort = Convert::ToInt($this->Sort);
			$description = addslashes($this->Description);
			$price = floatval($this->Price);
			$compareat = floatval($this->Compareat);
			$images = addslashes(json_encode($this->Images));
			$features = addslashes(json_encode($this->Features));
			$services = addslashes(json_encode($this->Services));
			$baseoccupancy = Convert::ToInt($this->Baseoccupancy);
			$maxoccupancy = Convert::ToInt($this->Maxoccupancy);
			$extrapersonprice = floatval($this->Extraguestprice);
            $pets = Convert::ToInt($this->Pets);
            $propertyid = $_REQUEST['property'];

			$smoking = Convert::ToBool($this->Smokingpolicy) === false ? 0 : 1;
			$childrenpolicy = Convert::ToBool($this->Childrenpolicy) === false ? 0 : 1;

			$meta = Router::BuildMeta($this->Name);

			$meta = addslashes($meta);

			if($res = $db->query("SELECT roomcategoryid FROM roomcategory WHERE roomcategoryid='$id'")->num_rows > 0 && $id != '')
			{
				$db->query("UPDATE roomcategory SET name='$name',promotext='$promotext',status='$status',reservable='$reservable',showpromotion='$showpromotion',onsite='$onsite',sort='$sort',description='$description',price='$price',compareat='$compareat',images='$images',features='$features',services='$services',baseoccupancy='$baseoccupancy',maxoccupancy='$maxoccupancy',extrapersonprice='$extrapersonprice',smoking='$smoking',childrenpolicy='$childrenpolicy',pets='$pets',meta='$meta' WHERE roomcategoryid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT roomcategoryid FROM roomcategory WHERE roomcategoryid='$id'")->num_rows > 0)
				{
					goto redo;
				}
                $this->Id = $id;
                $db->query("INSERT INTO roomcategory (roomcategoryid,created,`name`,promotext,`status`,reservable,showpromotion,onsite,sort,`description`,price,compareat,images,features,services,baseoccupancy,maxoccupancy,extrapersonprice,childrenpolicy,smoking,pets,meta,propertyid) VALUES ('$id','$created','$name','$promotext',$status,$reservable,$showpromotion,$onsite,$sort,'$description',$price,$compareat,'$images','$features','$services',$baseoccupancy,$maxoccupancy,$extrapersonprice,$childrenpolicy,$smoking,$pets,'$meta','$propertyid')");
                
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM roomcategory WHERE roomcategoryid='$id'");
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
            $i = 0;
            $property = $_REQUEST['property'];

			$res = $db->query("SELECT * FROM roomcategory WHERE propertyid = '$property' AND name LIKE '%$term%' OR promotext LIKE '%$term%' OR status LIKE '%$term%' OR reservable LIKE '%$term%' OR showpromotion LIKE '%$term%' OR onsite LIKE '%$term%' OR sort LIKE '%$term%' OR description LIKE '%$term%' OR price LIKE '%$term%' OR compareat LIKE '%$term%' OR images LIKE '%$term%' OR features LIKE '%$term%' OR services LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Roomcategory($subscriber);
                $ret[$i]->Id = $row['roomcategoryid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Promotext = $row['promotext'];
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Reservable = Convert::ToBool($row['reservable']);
                $ret[$i]->Showpromotion = Convert::ToBool($row['showpromotion']);
                $ret[$i]->Onsite = Convert::ToBool($row['onsite']);
                $ret[$i]->Sort = $row['sort'];
                $ret[$i]->Description = $row['description'];
                $ret[$i]->Price = $row['price'];
                $ret[$i]->Baseprice = $row['price'];
                $ret[$i]->Compareat = $row['compareat'];
                $ret[$i]->Images = json_decode($row['images']);
                $ret[$i]->Features = json_decode($row['features']);
                $ret[$i]->Services = json_decode($row['services']);
                $ret[$i]->Baseoccupancy = Convert::ToInt($row['baseoccupancy']);
                $ret[$i]->Maxoccupancy = Convert::ToInt($row['maxoccupancy']);
                $ret[$i]->Extraguestprice = floatval($row['extrapersonprice']);
                $ret[$i]->Smokingpolicy = Convert::ToBool($row['smoking']);
                $ret[$i]->Childrenpolicy = Convert::ToBool($row['childrenpolicy']);
                $ret[$i]->Pets = Convert::ToBool($row['pets']);
                $ret[$i]->Meta = $row['meta'];

                $rates = Roomrate::ByRoomtype($subscriber, $ret[$i]->Id, false);
                for($j = 0; $j < count($rates); $j++)
                {
                    if(($rates[$j]->Startdate->getValue() <= time()) && (($rates[$j]->Stopdate->getValue() + ((60 * 60) * 24)) >= time()))
                    {
                        $ret[$i]->Price = $rates[$j]->Rate;

                        if($ret[$i]->Compareat > 0)
                        {
                            if($ret[$i]->Compareat > $ret[$i]->Price)
                            {
                                $ret[$i]->Compareat = 0;
                            }
                        }
                    }
                }

                $i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='roomcategoryid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
            $i = 0;
            $property = $_REQUEST['property'];

			$res = $db->query("SELECT * FROM roomcategory WHERE ".$field." ='$term' AND propertyid = '$property'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Roomcategory($subscriber);
                $ret[$i]->Id = $row['roomcategoryid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Promotext = $row['promotext'];
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Reservable = Convert::ToBool($row['reservable']);
                $ret[$i]->Showpromotion = Convert::ToBool($row['showpromotion']);
                $ret[$i]->Onsite = Convert::ToBool($row['onsite']);
                $ret[$i]->Sort = $row['sort'];
                $ret[$i]->Description = $row['description'];
                $ret[$i]->Price = $row['price'];
                $ret[$i]->Baseprice = $row['price'];
                $ret[$i]->Compareat = $row['compareat'];
                $ret[$i]->Images = json_decode($row['images']);
                $ret[$i]->Features = json_decode($row['features']);
                $ret[$i]->Services = json_decode($row['services']);
                $ret[$i]->Baseoccupancy = Convert::ToInt($row['baseoccupancy']);
                $ret[$i]->Maxoccupancy = Convert::ToInt($row['maxoccupancy']);
                $ret[$i]->Extraguestprice = floatval($row['extrapersonprice']);
                $ret[$i]->Smokingpolicy = Convert::ToBool($row['smoking']);
                $ret[$i]->Childrenpolicy = Convert::ToBool($row['childrenpolicy']);
                $ret[$i]->Pets = Convert::ToBool($row['pets']);
                $ret[$i]->Meta = $row['meta'];

                $rates = Roomrate::ByRoomtype($subscriber, $ret[$i]->Id, false);
                for($j = 0; $j < count($rates); $j++)
                {
                    if(($rates[$j]->Startdate->getValue() <= time()) && (($rates[$j]->Stopdate->getValue() + ((60 * 60) * 24)) >= time()))
                    {
                        $ret[$i]->Price = $rates[$j]->Rate;

                        if($ret[$i]->Compareat > 0)
                        {
                            if($ret[$i]->Compareat > $ret[$i]->Price)
                            {
                                $ret[$i]->Compareat = 0;
                            }
                        }
                    }
                }

                $i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
            $i = 0;
            $property = $_REQUEST['property'];

			$res = $db->query("SELECT * FROM roomcategory WHERE propertyid = '$property' ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Roomcategory($subscriber);
                $ret[$i]->Id = $row['roomcategoryid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Promotext = $row['promotext'];
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Reservable = Convert::ToBool($row['reservable']);
                $ret[$i]->Showpromotion = Convert::ToBool($row['showpromotion']);
                $ret[$i]->Onsite = Convert::ToBool($row['onsite']);
                $ret[$i]->Sort = $row['sort'];
                $ret[$i]->Description = $row['description'];
                $ret[$i]->Price = $row['price'];
                $ret[$i]->Baseprice = $row['price'];
                $ret[$i]->Compareat = $row['compareat'];
                $ret[$i]->Images = json_decode($row['images']);
                $ret[$i]->Features = json_decode($row['features']);
                $ret[$i]->Services = json_decode($row['services']);
                $ret[$i]->Baseoccupancy = Convert::ToInt($row['baseoccupancy']);
                $ret[$i]->Maxoccupancy = Convert::ToInt($row['maxoccupancy']);
                $ret[$i]->Extraguestprice = floatval($row['extrapersonprice']);
                $ret[$i]->Smokingpolicy = Convert::ToBool($row['smoking']);
                $ret[$i]->Childrenpolicy = Convert::ToBool($row['childrenpolicy']);
                $ret[$i]->Pets = Convert::ToBool($row['pets']);
                $ret[$i]->Meta = $row['meta'];

                $rates = Roomrate::ByRoomtype($subscriber, $ret[$i]->Id, false);
                for($j = 0; $j < count($rates); $j++)
                {
                    if(($rates[$j]->Startdate->getValue() <= time()) && (($rates[$j]->Stopdate->getValue() + ((60 * 60) * 24)) >= time()))
                    {
                        $ret[$i]->Price = $rates[$j]->Rate;

                        if($ret[$i]->Compareat > 0)
                        {
                            if($ret[$i]->Compareat > $ret[$i]->Price)
                            {
                                $ret[$i]->Compareat = 0;
                            }
                        }
                    }
                }

                $i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber, $property)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM roomcategory WHERE propertyid = '$property'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Roomcategory($subscriber);
				$ret[$i]->Id = $row['roomcategoryid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Name = $row['name'];
				$ret[$i]->Promotext = $row['promotext'];
				$ret[$i]->Status = Convert::ToBool($row['status']);
				$ret[$i]->Reservable = Convert::ToBool($row['reservable']);
				$ret[$i]->Showpromotion = Convert::ToBool($row['showpromotion']);
				$ret[$i]->Onsite = Convert::ToBool($row['onsite']);
				$ret[$i]->Sort = $row['sort'];
				$ret[$i]->Description = $row['description'];
				$ret[$i]->Price = $row['price'];
				$ret[$i]->Baseprice = $row['price'];
				$ret[$i]->Compareat = $row['compareat'];
				$ret[$i]->Images = json_decode($row['images']);
				$ret[$i]->Features = json_decode($row['features']);
				$ret[$i]->Services = json_decode($row['services']);
                $ret[$i]->Baseoccupancy = Convert::ToInt($row['baseoccupancy']);
                $ret[$i]->Maxoccupancy = Convert::ToInt($row['maxoccupancy']);
                $ret[$i]->Extraguestprice = floatval($row['extrapersonprice']);
                $ret[$i]->Smokingpolicy = Convert::ToBool($row['smoking']);
                $ret[$i]->Childrenpolicy = Convert::ToBool($row['childrenpolicy']);
                $ret[$i]->Pets = Convert::ToBool($row['pets']);
                $ret[$i]->Meta = $row['meta'];
                $ret[$i]->Rooms = Room::RoomCountByCategory($subscriber, $row['roomcategoryid'], $row['propertyid']);

                $rates = Roomrate::ByRoomtype($subscriber, $ret[$i]->Id, false);
                for($j = 0; $j < count($rates); $j++)
                {
                    if(($rates[$j]->Startdate->getValue() <= time()) && (($rates[$j]->Stopdate->getValue() + ((60 * 60) * 24)) >= time()))
                    {
                        $ret[$i]->Price = $rates[$j]->Rate;

                        if($ret[$i]->Compareat > 0)
                        {
                            if($ret[$i]->Compareat > $ret[$i]->Price)
                            {
                                $ret[$i]->Compareat = 0;
                            }
                        }
                    }
                }

				$i++;
			}
			return $ret;
		}

        public static function ByMeta(Subscriber $subscriber, $meta)
        {
            $db = $subscriber->GetDB();
            $ret = null;
            $property = $_REQUEST['property'];

            $res = $db->query("SELECT * FROM roomcategory WHERE meta='$meta' AND propertyid = '$property'");
            if($res->num_rows > 0)
            {
                $row = $res->fetch_assoc();

                $ret = new Roomcategory($subscriber);
                $ret->Id = $row['roomcategoryid'];
                $ret->Created = new WixDate($row['created']);
                $ret->Name = $row['name'];
                $ret->Promotext = $row['promotext'];
                $ret->Status = Convert::ToBool($row['status']);
                $ret->Reservable = Convert::ToBool($row['reservable']);
                $ret->Showpromotion = Convert::ToBool($row['showpromotion']);
                $ret->Onsite = Convert::ToBool($row['onsite']);
                $ret->Sort = $row['sort'];
                $ret->Description = $row['description'];
                $ret->Price = $row['price'];
                $ret->Baseprice = $row['price'];
                $ret->Compareat = $row['compareat'];
                $ret->Images = json_decode($row['images']);
                $ret->Features = json_decode($row['features']);
                $ret->Services = json_decode($row['services']);
                $ret->Baseoccupancy = Convert::ToInt($row['baseoccupancy']);
                $ret->Maxoccupancy = Convert::ToInt($row['maxoccupancy']);
                $ret->Extraguestprice = floatval($row['extrapersonprice']);
                $ret->Smokingpolicy = Convert::ToBool($row['smoking']);
                $ret->Childrenpolicy = Convert::ToBool($row['childrenpolicy']);
                $ret->Pets = Convert::ToBool($row['pets']);
                $ret->Meta = $row['meta'];

                $rates = Roomrate::ByRoomtype($subscriber, $ret->Id, false);
                for($j = 0; $j < count($rates); $j++)
                {
                    if(($rates[$j]->Startdate->getValue() <= time()) && (($rates[$j]->Stopdate->getValue() + ((60 * 60) * 24)) >= time()))
                    {
                        $ret->Price = $rates[$j]->Rate;

                        if($ret->Compareat > 0)
                        {
                            if($ret->Compareat > $ret->Price)
                            {
                                $ret->Compareat = 0;
                            }
                        }
                    }
                }
            }
            return $ret;
        }
	}
