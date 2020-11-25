<?php


    class Foodpixel
    {
        public $Food = null;
        public $Quantity = 0;
        public $Price = 0;
        public $Tax = 0;

        function __construct(Subscriber $subscriber=null, $arg=null)
        {
            if(($arg != null) && ($subscriber != null))
            {
                $this->Food = new Food($subscriber);

                if(is_object($arg))
                {
                    if(isset($arg->Food))
                    {
                        $this->Food->Initialize($arg->Food);
                    }
                    if(isset($arg->Quantity))
                    {
                        $this->Quantity = Convert::ToInt($arg->Quantity);
                    }
                    if(isset($arg->Price))
                    {
                        $this->Price = doubleval($arg->Price);
                    }
                    if(isset($arg->Tax))
                    {
                        $this->Tax = doubleval($arg->Tax);
                    }
                }
            }
        }

        public function Pixelate()
        {
            $std = new stdClass();
            $std->Food = is_a($this->Food, "Food") ? $this->Food->Id : $this->Food;
            $std->Quantity = Convert::ToInt($this->Quantity);
            $std->Price = doubleval($this->Price);
            $std->Tax = doubleval($this->Tax);
            return $std;
        }
    }