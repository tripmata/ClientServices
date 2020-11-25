<?php

class Access
{
    public $ReadAccess = null;
    public $WriteAccess = null;

    function __construct($access=0)
    {
        $this->ReadAccess = $access === 1 || $access === 2 ? true : false;
        $this->WriteAccess = $access === 1 || $access === 3 ? true : false;
    }
	
	function toInt()
	{
		if($this->ReadAccess && $this->WriteAccess)
		{
			return 1;
		}
		else if($this->ReadAccess && !$this->WriteAccess)
		{
			return 2;
		}
		else if(!$this->ReadAccess && $this->WriteAccess)
		{
			return 3;
		}
		else
		{
			return 0;
		}
	}
}