<?php

    class QuotationPixel
    {
        public $Supplier = "";
        public $Price = 0.0;

        public function BuildPixel(Subscriber $subscriber)
        {
            if(!is_a($this->Supplier, "Supplier"))
            {
                $sup = $this->Supplier;

                $this->Supplier = new Supplier($subscriber);
                $this->Supplier->Initialize($sup);
            }
        }
    }