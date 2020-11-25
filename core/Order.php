<?php

	class Order
	{
		public $Type = "null";
		public $Itemkey = "";
		public $Amount = 0.0;


		protected $subscriber = null;

		public function CalcTaxes()
        {
            $ret = 0;

            if($this->Type === "room_order")
            {
                $set = new Pastrysettings($this->subscriber);
                $ret = Roomorder::CalculateTaxes($this, $set->Compundtax);
                return $ret;
            }
            if($this->Type === "food_order")
            {
                $set = new Kitchensettings($this->subscriber);
                $ret = Foodorder::CalculateTaxes($this, $set->Compundtax);
                return $ret;
            }
            if($this->Type === "drink_order")
            {
                $set = new Barsettings($this->subscriber);
                $ret = Drinkorder::CalculateTaxes($this, $set->Compundtax);
                return $ret;
            }
            if($this->Type === "pastry_order")
            {
                $set = new Pastrysettings($this->subscriber);
                $ret = Pastryorder::CalculateTaxes($this, $set->Compundtax);
                return $ret;
            }

            if($this->Type === "laundry_order")
            {
                $set = new Laundrysettings($this->subscriber);
                $ret = Laundryorder::CalculateTaxes($this, $set->Compundtax);
                return $ret;
            }

            if($this->Type === "pool_order")
            {
                $set = new Poolsettings($this->subscriber);
                $ret = Poolorder::CalculateTaxes($this, $set->Compundtax);
                return $ret;
            }
            if($this->Type === "services_order")
            {
                //$set = new Kitchensettings($this->subscriber);
                //                $ret = Foodorder::CalculateTaxes($this, $set->Compundtax);
                //                return $ret;
            }
            return $ret;
        }


        public function Total()
        {
            $ret = 0;

            if($this->Type === "room_order")
            {
                $ret = Roomorder::Calc($this);
            }
            if($this->Type === "food_order")
            {
                $ret = Foodorder::Calc($this);
            }
            if($this->Type === "drink_order")
            {
                $ret = Drinkorder::Calc($this);
            }
            if($this->Type === "pastry_order")
            {
                $ret = Pastryorder::Calc($this);
            }

            if($this->Type === "laundry_order")
            {
                $ret = Laundryorder::Calc($this);
            }

            if($this->Type === "pool_order")
            {
                $ret = Poolorder::Calc($this);
            }
            if($this->Type === "services_order")
            {
                //$ret = Servicesorder::Calc($this);
            }
            return $ret;
        }
	}