<?php

    class Gender implements IBase
    {
        protected $Value = 0;

        function __construct($arg=0)
        {
            if(strtoupper($arg) === "MALE")
            {
                $this->Value = 1;
            }
            else if(strtoupper($arg) === "FEMALE")
            {
                $this->Value = 2;
            }
            else if(($arg === 1) || ($arg === 2))
            {
                $this->Value = $arg;
            }
            else if(($arg === "1") || ($arg === "2"))
            {
                $this->Value = $arg;
            }
            else
            {
                $this->Value = 0;
            }
        }

        public function ToBool()
        {
            // TODO: Implement ToBool() method.
            return $this->Value === 0 ? false : true;
        }

        public function ToInt()
        {
            // TODO: Implement ToInt() method.
            return $this->Value;
        }

        public function ToString()
        {
            // TODO: Implement ToString() method.
            switch ($this->Value)
            {
                case 1:
                    return "Male";
                    break;
                case 2:
                    return "Female";
                    break;
                default:
                    return "Unknown";
            }
        }
    }