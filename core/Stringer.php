<?php

    class Stringer
    {
        private $i = 0;
        public $Strings = Array();

        public static function AppendStringer($args,$newstring)
        {
            $ret = "";
            if($args == ""){$ret = $newstring;}
            else{$ret = $args."~".$newstring;}
            return $ret;
        }

        public function Add($args)
        {
            global $Strings;
            $i = count($this->Strings);
            $this->Strings[$i] = $args;
            $i++;
        }

        public function SetLenght($args)
        {
            global $Strings;
            $nl = Array($args);
            for($i = 0; $i < $nl; $i++)
            {
                if($i ==  count($this->Strings))
                {
                    break;
                }
                $nl[$i] = $this->Strings[$i];
            }

            $this->Strings = $nl;
        }


        public function MaxLenght($args)
        {
            global $Strings;

            $nl = Array();
            for($i = 0; $i < $args; $i++)
            {
                if($i == count($this->Strings)){break;}
                $nl[$i] = $this->Strings[$i];
            }
            $this->Strings = $nl;
        }

        public function Push($args)
        {
            global $Strings;
            $i = Array();
            $i[0] = $args;
            for($j = 0; $j < count($this->Strings); $j++)
            {
                $i[($j + 1)] = $this->Strings[$j];
            }
            $this->Strings = $i;
        }

        public function AddStringer($args)
        {
            global $Strings;
            //if(strlen($args) > 0)
            //{
            $r = explode("~",$args);
            $j = count($this->Strings);
            for($i = 0; $i < count($r); $i++)
            {
                $this->Strings[$j] = $r[$i];
                $j++;
            }
            //}
        }

        public function Lenght()
        {
            global $Strings;
            if($this->Strings[0] == null)
            {
                return 0;
            }
            else
            {
                return count($this->Strings);
            }
        }

        public function GetStringer()
        {
            global $Strings;
            $rg = "";
            for($i = 0; $i < count($this->Strings); $i++)
            {
                if($rg == ""){$rg = $this->Strings[$i];}
                else{$rg .= "~".$this->Strings[$i];}
            }
            return $rg;
        }

        public function Contains($args)
        {
            global $Strings;
            $ret = false;

            for($i = 0; $i < count($this->Strings); $i++)
            {
                if($args == $this->Strings[$i])
                {
                    $ret = true;
                    break;
                }
            }
            return $ret;
        }

        public function Remove($args)
        {
            global $Strings;

            $ar = Array();
            $count = 0;
            for($j = 0; $j < count($this->Strings); $j++)
            {
                if($this->Strings[$j] != $args)
                {
                    $ar[$count] = $this->Strings[$j];
                    $count++;
                }
            }
            $this->Strings = $ar;
        }

        public function GetArray()
        {
            global $Strings;
            return $this->Strings;
        }

        function SplitStringer($args)
        {
            $ret = explode("~",$args);
            return $ret;
        }
        function StringerLenght($args)
        {
            $ret = explode("~",$args);
            if($args == "")
            {
                return 0;
            }
            return count($ret);
        }
    }