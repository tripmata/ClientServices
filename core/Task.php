<?php


    class Task
    {
        Protected $Cycles = 0;
        protected $Cycled = 0;

        protected $Id = "";
        protected $Taskid = "";

        function __construct(Subscriber $subscriber, $taskid=null)
        {

        }

        public function IncrementCycle($byAmount = 1)
        {

        }

        protected function Inittask($taskid)
        {

        }

        protected function Completed()
        {

        }

        protected function Unque()
        {

        }

        public function GetCycle()
        {

        }

        protected function Run()
        {

        }

        protected function Que()
        {

        }

        protected function LogCycle($cycles)
        {
            $this->Cycles = $cycles;
        }

        public function GetId()
        {
            return $this->Id;
        }

    }