<?php
	/* Generated by Wixnit Class Builder 
	// Apr, 06/2020
	// Building class for Vehicle
	*/

	class Vehicle
	{
		public $Id = "";
		public $Created = 0;
		public $Image1 = "";
		public $Image2 = "";
		public $Image3 = "";
		public $Image4 = "";
		public $Type = "";
		public $Model = "";
		public $Color = "";
		public $Seats = 0;
		public $Description = "";
		public $Ac = false;
		public $Automatic = false;
		public $Tv = false;
		public $Fridge = false;
		public $Seatwarmer = false;
		public $Cupholder = false;
		public $Status = false;
		public $Driver = "";
		public $HasDriver = false;
		public $Price = 0;
		public $Extramilage = 0;
		public $Milagecap = 0;
		public $Owner = "";
		public $Features = [];
		public $Brand = "";
		public $Meta = "";

		public $Pickuplocation = "";
		public $Dropofflocation = "";

		public $Approved = false;

		public $City = "";
		public $State = "";

		public $Cityname = "";
		public $Statename = "";
		public $Address = "";
		public $Views = 0;
		public $Rating = 0;

		public $Cancellation = false;
		public $Offlinepay = false;

		function __construct($arg=null)
		{
			if($arg != null)
			{
				$db = DB::GetDB();

				$res = $db->query("SELECT * FROM vehicle WHERE vehicleid='$arg'");

				if($res->num_rows > 0)
				{
					$row = $res->fetch_assoc();
				
					$this->Id = $row['vehicleid'];
					$this->Created = new WixDate($row['created']);
					$this->Image1 = $row['image1'];
					$this->Image2 = $row['image2'];
					$this->Image3 = $row['image3'];
					$this->Image4 = $row['image4'];
					$this->Type = $row['type'];
					$this->Model = $row['model'];
					$this->Color = $row['color'];
					$this->Seats = $row['seats'];
					$this->Description = $row['description'];
					$this->Ac = Convert::ToBool($row['ac']);
					$this->Automatic = Convert::ToBool($row['automatic']);
					$this->Tv = Convert::ToBool($row['tv']);
					$this->Fridge = Convert::ToBool($row['fridge']);
					$this->Seatwarmer = Convert::ToBool($row['seatwarmer']);
					$this->Cupholder = Convert::ToBool($row['cupholder']);
					$this->Status = Convert::ToBool($row['status']);
					$this->Driver = new Driver($row['driver']);
					$this->HasDriver = Convert::ToBool($row['hasdriver']);
					$this->Price = $row['price'];
					$this->Extramilage = $row['extramilage'];
					$this->Milagecap = $row['milagecap'];
					$this->Owner = new Partner($row['owner']);
					$this->Features = json_decode($row['features']);
					$this->Brand = $row['brand'];

					$this->State = $row['state'];
					$this->City = $row['city'];

					$this->Cityname = $row['cityname'];
					$this->Statename = $row['statename'];
					$this->Address = $row['address'];
					$this->Rating = Convert::ToInt($row['rating']);
					$this->Views = Convert::ToInt($row['views']);

					$this->Approved = Convert::ToBool($row['approved']);

					$this->Meta = $row['meta'];
					$this->Cancellation = Convert::ToBool($row['cancellation']);
					$this->Offlinepay = Convert::ToBool($row['offlinepay']);
				}
			}
		}

		public function Save()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$created = time();
			$image1 = addslashes($this->Image1);
			$image2 = addslashes($this->Image2);
			$image3 = addslashes($this->Image3);
			$image4 = addslashes($this->Image4);
			$type = addslashes($this->Type);
			$model = addslashes($this->Model);
			$color = addslashes($this->Color);
			$seats = Convert::ToInt($this->Seats);
			$description = addslashes($this->Description);
			$ac = Convert::ToInt($this->Ac);
			$automatic = Convert::ToInt($this->Automatic);
			$tv = Convert::ToInt($this->Tv);
			$fridge = Convert::ToInt($this->Fridge);
			$seatwarmer = Convert::ToInt($this->Seatwarmer);
			$cupholder = Convert::ToInt($this->Cupholder);
			$status = Convert::ToInt($this->Status);
			$driver = addslashes(is_a($this->Driver, "Driver") ? $this->Driver->Id : $this->Driver);
			$price = floatval($this->Price);
			$extramilage = floatval($this->Extramilage);
			$milagecap = Convert::ToInt($this->Milagecap);
			$owner = addslashes(is_a($this->Owner, "Customer") ? $this->Owner->Id : $this->Owner);

			$state = is_a($this->State, "State") ? $this->State->Id : $this->State;
			$city = is_a($this->City, "City") ? $this->City->Id : $this->City;

			$cityname = $this->Cityname;
			$statename = $this->Statename;

			$views = Convert::ToInt($this->Views);

			$address = addslashes($this->Address);
			$rating = Convert::ToInt($this->Rating);
			$approved = Convert::ToInt($this->Approved);
			$brand = $this->Brand;

			$hasdriver = Convert::ToInt($this->HasDriver);

			$f = [];
			if(is_array($this->Features))
            {
                for($i = 0; $i < count($this->Features); $i++)
                {
                    if($this->Features[$i] != "")
                    {
                        array_push($f, $this->Features[$i]);
                    }
                }
            }
			$features = json_encode($f);

			$cancellation = Convert::ToInt($this->Cancellation);
			$offlinepay = Convert::ToInt($this->Offlinepay);

			$meta = addslashes($this->Meta);
			
			if($meta == "")
            {
                $meta = addslashes($this->Color."-".$this->Model."-".$this->Type."-for-rent-".$this->Cityname."-".$this->Statename."-".Random::GenerateId(10));
            }

			if($res = $db->query("SELECT vehicleid FROM vehicle WHERE vehicleid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE vehicle SET image1='$image1',image2='$image2',image3='$image3',image4='$image4',`type`='$type',model='$model',color='$color',seats=$seats,`description`='$description',ac='$ac',`automatic`=$automatic,tv=$tv,fridge=$fridge,seatwarmer=$seatwarmer,cupholder=$cupholder,`status`=$status,driver='$driver',price=$price,extramilage=$extramilage,milagecap=$milagecap,`owner`='$owner',city='$city',`state`='$state',features='$features',approved=$approved,brand='$brand',statename='$statename',cityname='$cityname',`address`='$address',rating=$rating,views=$views,cancellation=$cancellation,offlinepay=$offlinepay,meta='$meta',hasdriver=$hasdriver WHERE vehicleid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT vehicleid FROM vehicle WHERE vehicleid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO vehicle(vehicleid,created,image1,image2,image3,image4,`type`,model,color,seats,`description`,ac,`automatic`,tv,fridge,seatwarmer,cupholder,`status`,driver,price,extramilage,milagecap,`owner`,city,`state`,features,approved,brand,cityname,statename,`address`,rating,views,cancellation,offlinepay,meta,hasdriver) VALUES ('$id','$created','$image1','$image2','$image3','$image4','$type','$model','$color',$seats,'$description',$ac,$automatic,$tv,$fridge,$seatwarmer,$cupholder,$status,'$driver',$price,$extramilage,$milagecap,'$owner','$city','$state','$features',$approved,'$brand','$cityname','$statename','$address',$rating,$views,$cancellation,$offlinepay,'$meta',$hasdriver)");
			}
		}

		public function Delete()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM vehicle WHERE vehicleid='$id'");

			//Deleting Associated Objects
			/*n			$this->Driver->Delete();

			$this->Owner->Delete();
			*/
		}

		public static function Search($term='')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT vehicleid FROM vehicle WHERE image1 LIKE '%$term%' OR image2 LIKE '%$term%' OR image3 LIKE '%$term%' OR image4 LIKE '%$term%' OR type LIKE '%$term%' OR model LIKE '%$term%' OR color LIKE '%$term%' OR seats LIKE '%$term%' OR description LIKE '%$term%' OR ac LIKE '%$term%' OR automatic LIKE '%$term%' OR tv LIKE '%$term%' OR fridge LIKE '%$term%' OR seatwarmer LIKE '%$term%' OR cupholder LIKE '%$term%' OR status LIKE '%$term%' OR driver LIKE '%$term%' OR price LIKE '%$term%' OR extramilage LIKE '%$term%' OR milagecap LIKE '%$term%' OR owner LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Vehicle($row['vehicleid']);
				$i++;
			}
			return $ret;
		}

		public static function Filter($term='', $field='vehicleid')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT vehicleid FROM vehicle WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Vehicle($row['vehicleid']);
				$i++;
			}
			return $ret;
		}

		public static function Order($field='id', $order='DESC')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT vehicleid FROM vehicle ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Vehicle($row['vehicleid']);
				$i++;
			}
			return $ret;
		}

		public static function All()
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM vehicle");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Vehicle();
				$ret[$i]->Id = $row['vehicleid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Image1 = $row['image1'];
				$ret[$i]->Image2 = $row['image2'];
				$ret[$i]->Image3 = $row['image3'];
				$ret[$i]->Image4 = $row['image4'];
				$ret[$i]->Type = $row['type'];
				$ret[$i]->Model = $row['model'];
				$ret[$i]->Color = $row['color'];
				$ret[$i]->Seats = $row['seats'];
				$ret[$i]->Description = $row['description'];
				$ret[$i]->Ac = Convert::ToBool($row['ac']);
				$ret[$i]->Automatic = Convert::ToBool($row['automatic']);
				$ret[$i]->Tv = Convert::ToBool($row['tv']);
				$ret[$i]->Fridge = Convert::ToBool($row['fridge']);
				$ret[$i]->Seatwarmer = Convert::ToBool($row['seatwarmer']);
				$ret[$i]->Cupholder = Convert::ToBool($row['cupholder']);
				$ret[$i]->Status = Convert::ToBool($row['status']);
				$ret[$i]->Driver = new Driver($row['driver']);
				$ret[$i]->Price = $row['price'];
				$ret[$i]->Extramilage = $row['extramilage'];
				$ret[$i]->Milagecap = $row['milagecap'];
				$ret[$i]->Owner = new Partner($row['owner']);
				$ret[$i]->State = $row['state'];
				$ret[$i]->City = $row['city'];
				$ret[$i]->Busy = Convert::ToBool($row['busy']);
				$ret[$i]->Features = json_decode($row['features']);
				$ret[$i]->Approved = Convert::ToBool($row['approved']);
				$ret[$i]->Brand = $row['brand'];
				$ret[$i]->Cancellation = Convert::ToBool($row['cancellation']);
				$ret[$i]->Offlinepay = Convert::ToBool($row['offlinepay']);
				$ret[$i]->Meta = $row['meta'];
				$ret[$i]->HasDriver = Convert::ToBool($row['hasdriver']);
				$i++;
			}
			return $ret;
		}

		public static function ByCustomer(Customer $customer)
        {
            $db = DB::GetDB();
            $ret = array();
            $i = 0;

            $id = is_a($customer, "Customer") ? $customer->Id : $customer;

            $res = $db->query("SELECT * FROM vehicle WHERE owner='$id' ORDER BY id DESC");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Vehicle();
                $ret[$i]->Id = $row['vehicleid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Image1 = $row['image1'];
                $ret[$i]->Image2 = $row['image2'];
                $ret[$i]->Image3 = $row['image3'];
                $ret[$i]->Image4 = $row['image4'];
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Model = $row['model'];
                $ret[$i]->Color = $row['color'];
                $ret[$i]->Seats = $row['seats'];
                $ret[$i]->Description = $row['description'];
                $ret[$i]->Ac = Convert::ToBool($row['ac']);
                $ret[$i]->Automatic = Convert::ToBool($row['automatic']);
                $ret[$i]->Tv = Convert::ToBool($row['tv']);
                $ret[$i]->Fridge = Convert::ToBool($row['fridge']);
                $ret[$i]->Seatwarmer = Convert::ToBool($row['seatwarmer']);
                $ret[$i]->Cupholder = Convert::ToBool($row['cupholder']);
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Driver = new Driver($row['driver']);
                $ret[$i]->Price = $row['price'];
                $ret[$i]->Extramilage = $row['extramilage'];
                $ret[$i]->Milagecap = $row['milagecap'];
                $ret[$i]->Owner = new Partner($row['owner']);
                $ret[$i]->State = $row['state'];
                $ret[$i]->City = $row['city'];
                $ret[$i]->Busy = Convert::ToBool($row['busy']);
                $ret[$i]->Features = json_decode($row['features']);
                $ret[$i]->Approved = Convert::ToBool($row['approved']);
                $ret[$i]->Brand = $row['brand'];

                $ret[$i]->Cityname = $row['cityname'];
                $ret[$i]->Statename = $row['statename'];
                $ret[$i]->Address = $row['address'];
                $ret[$i]->Rating = Convert::ToInt($row['rating']);
                $ret[$i]->Views = Convert::ToInt($row['views']);

                $ret[$i]->Cancellation = Convert::ToBool($row['cancellation']);
                $ret[$i]->Offlinepay = Convert::ToBool($row['offlinepay']);
                $ret[$i]->Meta = $row['meta'];
                $ret[$i]->HasDriver = Convert::ToBool($row['hasdriver']);
                $i++;
            }
            return $ret;
		}
		
		public static function SearchActiveListing($term='')
        {
            $db = DB::GetDB();
            $ret = array();
            $i = 0;

			$res = $db->query("SELECT * FROM vehicle WHERE (approved=1) AND (status=1) AND (type LIKE '%$term%' OR model LIKE '%$term%' OR color LIKE '%$term%' OR seats LIKE '%$term%' OR description LIKE '%$term%' OR city LIKE '%$term%' OR state LIKE '%$term%')");
			while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Vehicle();
                $ret[$i]->Id = $row['vehicleid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Image1 = $row['image1'];
                $ret[$i]->Image2 = $row['image2'];
                $ret[$i]->Image3 = $row['image3'];
				$ret[$i]->Image4 = $row['image4'];
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Model = $row['model'];
                $ret[$i]->Color = ucwords(strtolower($row['color']));
                $ret[$i]->Seats = $row['seats'];
                $ret[$i]->Description = $row['description'];
                $ret[$i]->Ac = Convert::ToBool($row['ac']);
                $ret[$i]->Automatic = Convert::ToBool($row['automatic']);
                $ret[$i]->Tv = Convert::ToBool($row['tv']);
                $ret[$i]->Fridge = Convert::ToBool($row['fridge']);
                $ret[$i]->Seatwarmer = Convert::ToBool($row['seatwarmer']);
                $ret[$i]->Cupholder = Convert::ToBool($row['cupholder']);
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Driver = new Driver($row['driver']);

                $ret[$i]->Price = $row['price'];
                $ret[$i]->Extramilage = $row['extramilage'];
                $ret[$i]->Milagecap = $row['milagecap'];
                $ret[$i]->Owner = new Partner($row['owner']);
                $ret[$i]->State = $row['state'];
                $ret[$i]->City = $row['city'];
                $ret[$i]->Busy = Convert::ToBool($row['busy']);
                $ret[$i]->Features = json_decode($row['features']);
                $ret[$i]->Approved = Convert::ToBool($row['approved']);
                $ret[$i]->Brand = $row['brand'];

                $ret[$i]->Cityname = $row['cityname'];
                $ret[$i]->Statename = $row['statename'];
                $ret[$i]->Address = $row['address'];
                $ret[$i]->Rating = Convert::ToInt($row['rating']);
                $ret[$i]->Views = Convert::ToInt($row['views']);

                $ret[$i]->Cancellation = Convert::ToBool($row['cancellation']);
                $ret[$i]->Offlinepay = Convert::ToBool($row['offlinepay']);
                $ret[$i]->Meta = $row['meta'];
                $ret[$i]->HasDriver = Convert::ToBool($row['hasdriver']);
                $i++;
            }
            return $ret;
		}

		public static function ByMeta($meta)
        {
            $db = DB::GetDB();
            $ret = array();

            $res = $db->query("SELECT * FROM vehicle WHERE meta='$meta'");
            if($res->num_rows > 0)
            {
                $row = $res->fetch_assoc();

                $ret = new Vehicle();
                $ret->Id = $row['vehicleid'];
                $ret->Created = new WixDate($row['created']);
                $ret->Image1 = $row['image1'];
                $ret->Image2 = $row['image2'];
                $ret->Image3 = $row['image3'];
                $ret->Image4 = $row['image4'];
                $ret->Type = $row['type'];
                $ret->Model = $row['model'];
                $ret->Color = ucwords(strtolower($row['color']));
                $ret->Seats = $row['seats'];
                $ret->Description = $row['description'];
                $ret->Ac = Convert::ToBool($row['ac']);
                $ret->Automatic = Convert::ToBool($row['automatic']);
                $ret->Tv = Convert::ToBool($row['tv']);
                $ret->Fridge = Convert::ToBool($row['fridge']);
                $ret->Seatwarmer = Convert::ToBool($row['seatwarmer']);
                $ret->Cupholder = Convert::ToBool($row['cupholder']);
                $ret->Status = Convert::ToBool($row['status']);
                $ret->Driver = new Driver($row['driver']);
                $ret->Price = $row['price'];
                $ret->Extramilage = $row['extramilage'];
                $ret->Milagecap = $row['milagecap'];
                $ret->Owner = new Customer($GLOBALS['subscriber']);
                $ret->Owner->Initialize($row['owner']);
                $ret->State = $row['state'];
                $ret->City = $row['city'];
                $ret->Busy = Convert::ToBool($row['busy']);
                $ret->Features = json_decode($row['features']);
                $ret->Approved = Convert::ToBool($row['approved']);
                $ret->Brand = $row['brand'];

                $ret->Cityname = $row['cityname'];
                $ret->Statename = $row['statename'];
                $ret->Address = $row['address'];
                $ret->Rating = Convert::ToInt($row['rating']);
                $ret->Views = Convert::ToInt($row['views']);

                $ret->Cancellation = Convert::ToBool($row['cancellation']);
                $ret->Offlinepay = Convert::ToBool($row['offlinepay']);
                $ret->Meta = $row['meta'];
                $ret->HasDriver = Convert::ToBool($row['hasdriver']);
            }
            return $ret;
        }
	}