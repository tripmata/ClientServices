<?php

    class Theme
    {
        public $Name = "";
        public $Cover = "";
        public $Version = "";
        public $BuildNumber = "";
        public $BuildDate = "";
        public $Developer = "";
        public $Designer = "";
        public $User = "";

        public $All = "";

        function __construct($arg)
        {
            $filePath = "manifest/".strtolower($arg).".xml";

            if(file_exists($filePath))
            {
                $xml = simplexml_load_file($filePath);

                $data = json_decode(json_encode($xml));

                if(isset($data->name))
                {
                    $this->Name = $data->name;
                }
                if(isset($data->cover))
                {
                    $this->Cover = $data->cover;
                }
                if(isset($data->version))
                {
                    $this->Version = $data->version;
                }
                if(isset($data->build))
                {
                    $this->BuildNumber = $data->build;
                }
                if(isset($data->developer))
                {
                    $this->Developer = $data->developer;
                }
                if(isset($data->designer))
                {
                    $this->Designer = $data->designer;
                }
                if(isset($data->user))
                {
                    $this->User = $data->user;
                }


                $this->All = json_decode(json_encode($xml));
            }
        }


        public static function All()
        {
          $filePath = "manifest/index.xml";

          $ret = array();

          $xml = new stdClass();

          if(file_exists($filePath))
          {
            $xml = simplexml_load_file($filePath);

            for($i = 0; $i < count($xml->theme); $i++)
            {
              $ret[$i] = new Theme(strtolower($xml->theme[$i]->path));
            }
          }
          return $ret;
        }

        public static function Current(Subscriber $subscriber)
        {
          return new Theme(strtolower($subscriber->ClientTheme));
        }
    }
