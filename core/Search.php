<?php


    class Search
    {
        public $City = "";
        public $Checkin = 0;
        public $Checkout = 0;
        public $Minprice = 0;
        public $Maxprice = 0;

        public $Types = [];

        public $Partialpay = false;
        public $Cancellation = false;
        public $Earlycheckout = false;
        public $Cashonly = false;
        public $Damagedeposit = false;
        public $Policies = [];

        public $Facilities = [];

        public $Star_1 = false;
        public $Star_2 = false;
        public $Star_3 = false;
        public $Star_4 = false;
        public $Star_5 = false;

        public $Rate1 = false;
        public $Rate2 = false;
        public $Rate3 = false;
        public $Rate4 = false;
        public $Rate5 = false;


        public function Filter()
        {
            $properties = Property::SearchActiveListing($this->City);

            $ret = new stdClass();
            $ret->recomended = [];
            $ret->general = [];
            $ret->deals = [];

            for($i = 0; $i < count($properties); $i++)
            {
                $rooms = $properties[$i]->GetRoomCategories();

                if(count($rooms) > 0)
                {
                    $properties[$i]->Price = $rooms[0]->Price;
                }

                if((doubleval($properties[$i]->Price) > doubleval($this->Maxprice)) || (doubleval($properties[$i]->Price) < doubleval($this->Minprice)))
                {
                    $properties[$i]->Status = false;
                }

                if(count($this->Types))
                {
                    if(!in_array($properties[$i]->Type, $this->Types))
                    {
                        $properties[$i]->Status = false;
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

                if(($this->Star_1) || ($this->Star_2) || ($this->Star_3) || ($this->Star_4) || ($this->Star_5))
                {
                    if(Convert::ToInt($properties[$i]->Star) == 1)
                    {
                        if(!$this->Star_1){$properties[$i]->Status = false;}
                    }
                    if(Convert::ToInt($properties[$i]->Star) == 2)
                    {
                        if(!$this->Star_2){$properties[$i]->Status = false;}
                    }
                    if(Convert::ToInt($properties[$i]->Star) == 3)
                    {
                        if(!$this->Star_3){$properties[$i]->Status = false;}
                    }
                    if(Convert::ToInt($properties[$i]->Star) == 4)
                    {
                        if(!$this->Star_4){$properties[$i]->Status = false;}
                    }
                    if(Convert::ToInt($properties[$i]->Star) == 5)
                    {
                        if(!$this->Star_5){$properties[$i]->Status = false;}
                    }
                }

                if(($this->Rate1) || ($this->Rate2) || ($this->Rate3) || ($this->Rate4) || ($this->Rate5))
                {
                    if((Convert::ToInt($properties[$i]->Rating) == 1) || (Convert::ToInt($properties[$i]->Rating) == 2))
                    {
                        if(!$this->Rate1){$properties[$i]->Status = false;}
                    }
                    if((Convert::ToInt($properties[$i]->Rating) == 3) || (Convert::ToInt($properties[$i]->Rating) == 4))
                    {
                        if(!$this->Rate2){$properties[$i]->Status = false;}
                    }
                    if((Convert::ToInt($properties[$i]->Rating) == 5) || (Convert::ToInt($properties[$i]->Rating) == 6))
                    {
                        if(!$this->Rate3){$properties[$i]->Status = false;}
                    }
                    if((Convert::ToInt($properties[$i]->Rating) == 7) || (Convert::ToInt($properties[$i]->Rating) == 8))
                    {
                        if(!$this->Rate4){$properties[$i]->Status = false;}
                    }
                    if((Convert::ToInt($properties[$i]->Rating) == 9) || (Convert::ToInt($properties[$i]->Rating) == 10))
                    {
                        if(!$this->Rate5){$properties[$i]->Status = false;}
                    }
                }

                if($properties[$i]->Status === true)
                {
                    array_push($ret->recomended, $properties[$i]);
                    array_push($ret->general, $properties[$i]);
                    //array_push($ret->deals, $properties[$i]);
                }
            }
            return $ret;
        }
    }