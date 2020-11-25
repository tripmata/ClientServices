<?php


    class Drinkpixel
    {
        public $Drink = null;
        public $Quantity = 0;
        public $Price = 0;
        public $Tax = 0;

        function __construct(Subscriber $subscriber=null, $arg=null)
        {
            if(($arg != null) && ($subscriber != null))
            {
                $this->Drink = new Drink($subscriber);

                if(is_object($arg))
                {
                    if(isset($arg->Drink))
                    {
                        $this->Drink->Initialize($arg->Drink);
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
            $std->Drink = is_a($this->Drink, "Drink") ? $this->Drink->Id : $this->Drink;
            $std->Quantity = Convert::ToInt($this->Quantity);
            $std->Price = doubleval($this->Price);
            $std->Tax = doubleval($this->Tax);
            return $std;
        }
    }