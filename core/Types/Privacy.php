<?php

    class Privacy implements IBase
    {
        protected $Value = 0;

        function __construct($arg)
        {
            $this->Value = Convert::ToPrivacy($arg);
        }

        public function ToBool()
        {
            // TODO: Implement ToBool() method.
            if($this->Value == 1)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function ToInt()
        {
            // TODO: Implement ToInt() method.
            return $this->Value;
        }

        public function ToString()
        {
            // TODO: Implement ToString() method.
            return Convert::ToPrivacyText($this->Value);
        }

        public function ToPrivacyText()
        {
            return Convert::ToPrivacyText($this->Value);
        }

        public function ToPrivacyShort()
        {
            return Convert::ToPrivacyShort($this->Value);
        }
    }