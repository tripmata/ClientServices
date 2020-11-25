<?php

$ret = new stdClass();


$roomorder = new Roomorder($GLOBALS['subscriber']);
$roomorder->Roomcategory = new Roomcategory($GLOBALS['subscriber']);
$roomorder->Roomcategory->Initialize($_REQUEST['room']);

$roomorder->Checkindate = new WixDate($_REQUEST['checkin']);
$roomorder->Checkoutdate = new WixDate($_REQUEST['checkout']);
$roomorder->Guestcount = Convert::ToInt($_REQUEST['guestcount']);

$d = $roomorder->Checkoutdate->getValue() - $roomorder->Checkindate->getValue();
$day = ($d / ((60 * 60) * 24));

$ret->data = new stdClass();
$ret->data->Room = $roomorder->Roomcategory->Id;
$ret->data->Checkin = $_REQUEST['checkin'];
$ret->data->Checkout = $_REQUEST['checkout'];
$ret->data->Guestcount = Convert::ToInt($_REQUEST['guestcount']);
$ret->data->Maxoccupancy = $roomorder->Roomcategory->Maxoccupancy;


if(Convert::ToInt($_REQUEST['guestcount']) > 0)
{
	if($roomorder->Checkindate->getValue() >= strtotime(date("m/d/Y")))
	{
		if($roomorder->Roomcategory->Id != "")
		{
			if(($roomorder->Roomcategory->Maxoccupancy > 0) &&
			(Convert::ToInt($_REQUEST['guestcount']) <= $roomorder->Roomcategory->Maxoccupancy))
			{
				if($day >= 1)
				{
					$cart = new Cart($GLOBALS['subscriber']);

					//check if a now order is in cart and remove all
					$list = $cart->GetOrderlist();
					$items = $list->Getitems();
					if((count($items) > 0) && (!$list->Hasroom()))
					{
						for($i = 0; $i < count($items); $i++)
						{
							$list->Removeitem($items[$i]);
						}
					}

					$cart->Addorder($roomorder);

					$ret = $cart->Generatereply();
					$ret->Content->Data->Cartcount = $cart->Contentcount();
					$ret->Content->Data->root = Router::ResolvePath('', $path);
					$ret->Content->Data->modules = new Modules($GLOBALS['subscriber']);
					$ret->status = "success";
				}
				else
				{
					//Invalid stay period
					$ret->status = "invalid stay period";
					$ret->message = "Invalid stay period";
				}
			}
			else
			{
				//Maximum occupancy exceeded
				$ret->status = "maximum occupancy exceeded";
				$ret->message = "Maximum occupancy exceeded";
			}
		}
		else
		{
			//Invalid room category
			$ret->status = "invalid room category";
			$ret->message = "Invalid room category";
		}
	}
	else
	{
		//The checkin time is set to before today
		$ret->status = "invalid checkin time";
		$ret->message = "Invalid check in time";
	}
}
else
{
	//invalid number of guests
	$ret->status = "invalid guest number";
	$ret->message = "Invalid guest number";
}

echo json_encode($ret);