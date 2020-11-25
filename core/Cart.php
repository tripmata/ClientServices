<?php

	class Cart
	{
		private $Cartid = "";
		private $subscriber = null;
		private $list = null;
		private $itemkey = "";
		
		function __construct(Subscriber $subscriber)
		{
		    $this->subscriber = $subscriber;
		    $this->list = new Orderlist($subscriber);
		}

		public function Initialize()
        {
            if(isset($_REQUEST['cart_session_id']))
            {
                $this->list->Initialize($_REQUEST['cart_session_id']);
            }
            else
            {
                $this->list->Initialize();
            }
            $this->list->Save();
            $this->itemkey = $this->list->Id;
        }

		public function Addorder($order)
        {
            $this->Initialize();
            $this->list->Additem($order);
        }


        public function removeItem($item)
        {
            $this->Initialize();
            $this->list->Removeitem($item);
        }

        public function Contentcount()
        {
            if(isset($_REQUEST['cart_session_id']))
            {
                $this->Initialize();
                return count($this->list->Getitems());
            }
            else
            {
                return 0;
            }
        }

        public function Content()
        {
            if(isset($_REQUEST['cart_session_id']))
            {
                $this->Initialize();
                return $this->list->Getitems();
            }
            else
            {
                return array();
            }
        }

        public function Generatereply()
        {
            $ret = new stdClass();

            $pack = new stdClass();
            $pack->Status = "success";
            $pack->Data = new stdClass();
            $pack->Data->setMethod = "session";
            $pack->Data->setName = "cart_session_id";
            $pack->Data->setValue = $this->itemkey;
            $pack->Data->Status = "success";

            $ret->Type = "set";
            $ret->Content = $pack;

            return $ret;
        }

        public function GetOrderlist()
        {
            if(isset($_REQUEST['cart_session_id']))
            {
                $this->Initialize();
                return $this->list;
            }
            else
            {
                return $this->list;
            }
        }
	}