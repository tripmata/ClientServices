<?php

    class DataPack
    {
        public $Status = "";
        public $Data = null;
        public $Perpage = 0;
        public $Page = 0;
        public $Total = 0;
        public $Currency = "$";

        public function AddData($data)
        {
            $this->Total = count($data);

            if($this->Page == 0)
            {
                $this->Page = 1;
            }

            if($this->Perpage == 0)
            {
                $this->Perpage = 25;
            }

            $start = (($this->Page - 1) * $this->Perpage);
            $stop = (($start + $this->Perpage) - 1);

            $x = 0;
            for($i = $start; $i < count($data); $i++)
            {
                $this->Data[$x] = $data[$i];
                if($i == $stop){break;}
                $x++;
            }
            $this->Status = "SUCCESS";
        }
    }