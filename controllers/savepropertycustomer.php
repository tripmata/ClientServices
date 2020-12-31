<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
	if ($GLOBALS['user']->Role->Customers->WriteAccess)
	{
		$subscriber = new Subscriber();
		$customerId = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;


		if ($customerId !== null)
		{
			// validate id
			$db = DB::GetDB();
			
			// can save
			$canSave = false;
			
			// manage response
			$ret->status = 'error';
			$ret->message = 'Invalid account ID';

			// get customer
			$customer = $db->query("SELECT * FROM customer WHERE customerid = '$customerId'");

			// check record
			if ($customer->num_rows > 0)
			{
				// fetch record
				$record = $customer->fetch_assoc();

				// are we good ?
				if ($record['password'] != '')
				{
					$ret->message = 'You cannot update customer profile';
				}
				else
				{
					$canSave = true;
				}
			}

			// can we save?
			if ($canSave) :

				// Save information
				$customer = new CustomerByProperty($subscriber);
				$customer->Initialize($customerId);
				$customer->Name = ucwords(strtolower($_REQUEST['name']));
				$customer->Surname = ucwords(strtolower($_REQUEST['surname']));
				$customer->Phone = $_REQUEST['phone'];
				$customer->Email = strtolower(trim($_REQUEST['email']));
				$customer->Country = $_REQUEST['country'];
				$customer->State = $_REQUEST['state'];
				$customer->City = $_REQUEST['city'];
				$customer->Address = $_REQUEST['address'];
				$customer->DOB = $_REQUEST['dob'];
				$customer->Sex = $_REQUEST['sex'];
				$customer->Status = true;
				$customer->ProfilePic = !empty($_REQUEST['profilePic']) ? $_REQUEST['profilePic'] : $customer->ProfilePic;

				$customer->Save();
				
				$ret->status = "success";
				$ret->message = "Customer updated successfully";

			endif;
		}
		else
		{
			if ((!Customer::EmailExist($_REQUEST['email'], $subscriber)))
			{
				if ((!Customer::PhoneExist($_REQUEST['phone'], $subscriber)))
				{
					$customer = new CustomerByProperty($subscriber);
					$customer->Name = ucwords(strtolower($_REQUEST['name']));
					$customer->Surname = ucwords(strtolower($_REQUEST['surname']));
					$customer->Phone = $_REQUEST['phone'];
					$customer->Email = strtolower(trim($_REQUEST['email']));
					$customer->Country = $_REQUEST['country'];
					$customer->State = $_REQUEST['state'];
					$customer->City = $_REQUEST['city'];
					$customer->Address = $_REQUEST['address'];
					$customer->DOB = $_REQUEST['dob'];
					$customer->Sex = $_REQUEST['sex'];
					$customer->Status = false;

					$customer->Save();
					
					$ret->status = "success";
					$ret->message = "Customer saved successfully";
				}
				else
				{
					$ret->status = "error";
					$ret->message = "Phone number exist already";
				}
			}
			else
			{
				$ret->status = "error";
				$ret->message = "Email exists already";
			}
		}
	}
	else
	{
		$ret->status = "error";
		$ret->message = "You do not have the required privilage to complete the operation";
	}
}
else
{
	$ret->status = "error";
	$ret->message = "Please login and try again";
}

echo json_encode($ret);