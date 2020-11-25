<?php


    class Carsearch
    {
        public $City = "";
        public $Pickup = 0;
        public $Dropoff = 0;
        public $Minprice = 0;
        public $Maxprice = 0;

        public $Types = [];

        public $Partialpay = false;
        public $Cancellation = false;
        public $Cashonly = false;
        public $Damagedeposit = false;
        public $Policies = [];

        public $Facilities = [];


        public function Filter()
        {
            $vehicles = Vehicle::SearchActiveListing($this->City);

            $ret = new stdClass();
            $ret->recomended = [];
            $ret->general = [];
            $ret->deals = [];

            for($i = 0; $i < count($vehicles); $i++)
            {
                if((doubleval($vehicles[$i]->Price) > doubleval($this->Maxprice)) || (doubleval($vehicles[$i]->Price) < doubleval($this->Minprice)))
                {
                    $vehicles[$i]->Status = false;
                }

                if(count($this->Types))
                {
                    if(!in_array($vehicles[$i]->Type, $this->Types))
                    {
                        $vehicles[$i]->Status = false;
                    }
                }

                if(count($this->Facilities))
                {
                    for($k = 0; $k < count($this->Facilities); $k++)
                    {
                        if(!in_array($this->Facilities[$k], $properties[$i]->Facilities))
                        {
                            $properties[$i]->Status = false;
                        }
                    }
                }


                /*
                if(($this->Rate1) || ($this->Rate2) || ($this->Rate3) || ($this->Rate4) || ($this->Rate5))
                {
                    if((Convert::ToInt($vehicles[$i]->Rating) == 1) || (Convert::ToInt($vehicles[$i]->Rating) == 2))
                    {
                        if(!$this->Rate1){$vehicles[$i]->Status = false;}
                    }
                    if((Convert::ToInt($vehicles[$i]->Rating) == 3) || (Convert::ToInt($vehicles$i]->Rating) == 4))
                    {
                        if(!$this->Rate2){$vehicles[$i]->Status = false;}
                    }
                    if((Convert::ToInt($vehicles[$i]->Rating) == 5) || (Convert::ToInt($vehicles[$i]->Rating) == 6))
                    {
                        if(!$this->Rate3){$vehicles[$i]->Status = false;}
                    }
                    if((Convert::ToInt($vehicles[$i]->Rating) == 7) || (Convert::ToInt($vehicles[$i]->Rating) == 8))
                    {
                        if(!$this->Rate4){$vehicles[$i]->Status = false;}
                    }
                    if((Convert::ToInt($vehicles[$i]->Rating) == 9) || (Convert::ToInt($vehicles[$i]->Rating) == 10))
                    {
                        if(!$this->Rate5){$vehicles[$i]->Status = false;}
                    }
                }
                */

                if($vehicles[$i]->Status === true)
                {
                    //array_push($ret->recomended, $vehicles[$i]);
                    array_push($ret->general, $vehicles[$i]);
                    //array_push($ret->deals, $vehicles[$i]);
                }
            }
            return $ret;
        }
    }