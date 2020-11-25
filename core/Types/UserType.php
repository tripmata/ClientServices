<?php

    class UserType implements IBase
    {
        protected $Value = 0;

        /**
         * UserType constructor.
         * @param null $arg
         */
        function __construct($arg=null)
        {
            if($arg == null)
            {
                $this->Value = 0;
            }
            else
            {
                if(strtoupper($arg) === "STUDENT")
                {
                    $this->Value = 1;
                }
                else if(strtoupper($arg) === "ASPIRANT")
                {
                    $this->Value = 2;
                }
                else if(strtoupper($arg) === "NEUTRAL")
                {

                }
                else if(($arg === 1) || ($arg === 2) || ($arg === 3))
                {
                    $this->Value = $arg;
                }
                else if(($arg === "1") || ($arg === "2") || ($arg === "3"))
                {
                    $this->Value = Convert::ToInt($arg);
                }
                else
                {
                    $this->Value = 0;
                }
            }
        }

        public function ToString()
        {
            // TODO: Implement ToString() method.

            if($this->Value === 1)
            {
                return "Student";
            }
            else if($this->Value === 2)
            {
                return "Aspirant";
            }
            else if($this->Value === 3)
            {
                return "Neutral";
            }
            else
            {
                return "None";
            }
        }

        public function ToInt()
        {
            // TODO: Implement ToInt() method.
            return $this->Value;
        }

        public function ToBool()
        {
            // TODO: Implement ToBool() method.
            return $this->Value === 0 ? false : true;
        }
    }