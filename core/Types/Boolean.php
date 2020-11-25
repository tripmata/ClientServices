<?php

    class Boolean implements IBase
    {
        protected $Value = false;

        function __construct($arg)
        {
            $this->Value = is_a($arg, "Boolean") ? $arg->ToBool() : Convert::ToBool($arg);
        }

        public function ToString()
        {
            // TODO: Implement ToString() method.
            if($this->Value === true)
            {
                return "true";
            }
            else
            {
                return "false";
            }
        }

        public function ToInt()
        {
            // TODO: Implement ToInt() method.
            if($this->Value === true)
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }

        public function ToBool()
        {
            // TODO: Implement ToBool() method.
            if($this->Value === true)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function ToChecked()
        {
            if($this->Value === true)
            {
                return "checked";
            }
            else
            {
                return "unchecked";
            }
        }

        /**
         * @return bool
         */
        public function isValue()
        {
            return $this->Value;
        }
    }