<?php

	class Items
	{
		public static function Generatekey(Subscriber $subscriber)
		{
			$ret = Random::GenerateId(16);

			while((count(Roomorder::ByItemkey($subscriber, $ret)) > 0) ||
                  (count(Roomorder::ByItemkey($subscriber, $ret)) > 0) ||
                  (count(Roomorder::ByItemkey($subscriber, $ret)) > 0) ||
                  (count(Roomorder::ByItemkey($subscriber, $ret)) > 0) ||
                  (count(Roomorder::ByItemkey($subscriber, $ret)) > 0))
            {
                $ret = Random::GenerateId(16);
            }

            return $ret;
		}
		
		public static function Retrieve(Subscriber $subscriber, $itemkey)
		{
			$ret = array();

			//retrieve room order items
            $ret = array_merge($ret, Roomorder::ByItemkey($subscriber, $itemkey));

            //retrieving food order items
            $ret = array_merge($ret, Foodorder::ByItemkey($subscriber, $itemkey));

            //retrieveing drinks order items
            $ret = array_merge($ret, Drinkorder::ByItemkey($subscriber, $itemkey));

            //retrieving pastry order items
            $ret = array_merge($ret, Pastryorder::ByItemkey($subscriber, $itemkey));

            //retrieving laundry order items
            $ret = array_merge($ret, Laundryorder::ByItemkey($subscriber, $itemkey));

            //retrievng pool order items
            $ret = array_merge($ret, Poolorder::ByItemkey($subscriber, $itemkey));

            return $ret;
		}
	}