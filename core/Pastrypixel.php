<?php


    class Pastrypixel
    {
        public $Pastry = null;
        public $Quantity = 0;
        public $Price = 0;
        public $Tax = 0;

        function __construct(Subscriber $subscriber=null, $arg=null)
        {
            if(($arg != null) && ($subscriber != null))
            {
                $this->Pastry = new Pastry($subscriber);

                if(is_object($arg))
                {
                    if(isset($arg->Pastry))
                    {
                        $this->Pastry->Initialize($arg->Pastry);
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
            $std->Pastry = is_a($this->Pastry, "Pastry") ? $this->Pastry->Id : $this->Pastry;
            $std->Quantity = Convert::ToInt($this->Quantity);
            $std->Price = doubleval($this->Price);
            $std->Tax = doubleval($this->Tax);
            return $std;
        }
    }