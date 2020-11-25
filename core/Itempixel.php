<?php


    class Itempixel
    {
        public $Item = "";
        public $Name = "";
        public $Quantity = 0;
        public $Price = 0;
        public $Type = "";
        public $Itemid = "";

        function __construct($arg=null)
        {
            if($arg != null)
            {
                if(is_object($arg))
                {
                    if(isset($arg->Name) || isset($arg->Item))
                    {
                        $this->Item = isset($arg->Item) ? $arg->Item : $arg->Name;
                        $this->Name = isset($arg->Item) ? $arg->Item : $arg->Name;
                    }
                    if(isset($arg->Quantity))
                    {
                        $this->Quantity = Convert::ToInt($arg->Quantity);
                    }
                    if(isset($arg->Price))
                    {
                        $this->Price = doubleval($arg->Price);
                    }
                    if(isset($arg->Type))
                    {
                        $this->Type = $arg->Type;
                    }
                    if(isset($arg->Itemid))
                    {
                        $this->Itemid = $arg->Itemid;
                    }
                }
            }
        }
    }