<?php
	/* Generated by Wixnit Class Builder 
	// Dec, 06/2019
	// Building class for Paygateway
	*/

	class Paygateway
	{
		public $Created = 0;
		public $Paypalid = "";
		public $Paypalusername = "";
		public $Paypalpassword = "";
		public $Interswitchmarchantid = "";
		public $Paystackprivate = "";
		public $Paystackpublic = "";

		public $Accountname = "";
		public $Bank = "";
		public $Accountnumber = "";

		private $subscriber = null;

		function __construct(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();

			$this->subscriber = $subscriber;

			$res = $db->query("SELECT * FROM paygateway");

			if($res->num_rows > 0)
			{
				$row = $res->fetch_assoc();
			
				$this->Created = new WixDate($row['created']);
				$this->Paypalid = $row['paypalid'];
				$this->Paypalusername = $row['paypalusername'];
				$this->Paypalpassword = $row['paypalpassword'];
				$this->Interswitchmarchantid = $row['interswitchmarchantid'];
				$this->Paystackprivate = $row['paystackprivate'];
				$this->Paystackpublic = $row['paystackpublic'];

				$this->Bank = $row['bank'];
				$this->Accountname = $row['accountname'];
				$this->Accountnumber = $row['accountnumber'];
			}
			else
			{
				$this->Save();
			}
		}

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$created = time();
			$paypalid = addslashes($this->Paypalid);
			$interswitchmarchantid = addslashes($this->Interswitchmarchantid);
			$paystackprivate = addslashes($this->Paystackprivate);
			$paystackpublic = addslashes($this->Paystackpublic);
			$paypalusername = addslashes($this->Paypalusername);
			$paypalpassword = addslashes($this->Paypalpassword);

			$bank = addslashes($this->Bank);
			$accountname = addslashes($this->Accountname);
			$accountnumber = addslashes($this->Accountnumber);

			if($res = $db->query("SELECT * FROM paygateway")->num_rows > 0)
			{
				$db->query("UPDATE paygateway SET paypalid='$paypalid',interswitchmarchantid='$interswitchmarchantid',paystackprivate='$paystackprivate',paystackpublic='$paystackpublic',paypalpassword='$paypalpassword',paypalusername='$paypalusername',bank='$bank',accountname='$accountname',accountnumber='$accountnumber'");
			}
			else
			{
				$db->query("INSERT INTO paygateway(created,paypalid,interswitchmarchantid,paystackprivate,paystackpublic,paypalpassword,paypalusername,bank,accounname,accountnumber) VALUES ('$created','$paypalid','$interswitchmarchantid','$paystackprivate','$paystackpublic','$paypalpassword','$paypalusername','$bank','$accountname','$accountnumber')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$db->query("DELETE FROM paygateway");
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT paygatewayid FROM paygateway ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Paygateway($row['paygatewayid']);
				$i++;
			}
			return $ret;
		}

		public static function confirmPaystackPayment(Subscriber $subscriber, $reference)
        {
            $gateway = new Paygateway($subscriber);

            $result = array();
            //The parameter after verify/ is the transaction reference to be verified
            $url = 'https://api.paystack.co/transaction/verify/'.$reference;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt(
                $ch, CURLOPT_HTTPHEADER, [
                    'Authorization: '.$gateway->Paystackprivate]
            );
            $request = curl_exec($ch);
            if(curl_error($ch))
            {
                curl_close($ch);
                return curl_error($ch);
            }
            curl_close($ch);

            if ($request)
            {
                $result = json_decode($request, true);
            }

            if (array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success'))
            {
                return true;
            }
            else
            {
                return null;
            }
        }
	}