<?php
	/* Generated by Wixnit Class Builder 
	// Feb, 29/2020
	// Building class for Bakerytransaction
	*/

	class Bakerytransaction
	{
		public $Id = "";
		public $Created = 0;
		public $Sale = "";
		public $Type = "";
		public $Amount = 0;
		public $User = "";
		public $Text = "";
		public $Method = "";

		public $Paytime = 0;

		private  $subscriber = null;

		function __construct(Subscriber $subscriber)
        {
            $this->subscriber = $subscriber;
        }

        public function Initialize($arg=null)
		{
			if($arg != null)
			{
				$db = $this->subscriber->GetDB();

				$res = $db->query("SELECT * FROM bakerytransaction WHERE bakerytransactionid='$arg'");

				if($res->num_rows > 0)
				{
					$row = $res->fetch_assoc();
				
					$this->Id = $row['bakerytransactionid'];
					$this->Created = new WixDate($row['created']);
					$this->Sale = $row['sale'];
					$this->Type = $row['type'];
					$this->Amount = doubleval($row['amount']);
					$this->User = new User($this->subscriber);
					$this->User->Initialize($row['user']);
					$this->Text = $row['text'];
					$this->Method = $row['method'];
					$this->Paytime = new WixDate($row['paytime']);
				}
			}
		}

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$sale = addslashes(is_a($this->Sale, "Bakerysale") ? $this->Sale->Id : $this->Sale);
			$type = addslashes($this->Type);
			$amount = floatval($this->Amount);
			$user = addslashes(is_a($this->User, "User") ? $this->User->Id : $this->User);
			$text = addslashes($this->Text);
			$method = addslashes($this->Method);
			$paytime = Convert::ToInt($this->Paytime);

			if($res = $db->query("SELECT bakerytransactionid FROM bakerytransaction WHERE bakerytransactionid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE bakerytransaction SET sale='$sale',type='$type',amount='$amount',user='$user',text='$text',method='$method',paytime='$paytime' WHERE bakerytransactionid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT bakerytransactionid FROM bakerytransaction WHERE bakerytransactionid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO bakerytransaction(bakerytransactionid,created,sale,type,amount,user,text,method,paytime) VALUES ('$id','$created','$sale','$type','$amount','$user','$text','$method','$paytime')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM bakerytransaction WHERE bakerytransactionid='$id'");

			//Deleting Associated Objects
			/*n			$this->Sale->Delete();

			$this->User->Delete();
			*/
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM bakerytransaction WHERE sale LIKE '%$term%' OR type LIKE '%$term%' OR amount LIKE '%$term%' OR user LIKE '%$term%' OR text LIKE '%$term%' OR method LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Bakerytransaction($subscriber);
                $ret[$i]->Id = $row['bakerytransactionid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Sale = $row['sale'];
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Amount = doubleval($row['amount']);
                $ret[$i]->User = $row['user'];
                $ret[$i]->Text = $row['text'];
                $ret[$i]->Method = $row['method'];
                $ret[$i]->Paytime = new WixDate($row['paytime']);
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='bakerytransactionid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM bakerytransaction WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Bakerytransaction($subscriber);
                $ret[$i]->Id = $row['bakerytransactionid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Sale = $row['sale'];
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Amount = doubleval($row['amount']);
                $ret[$i]->User = $row['user'];
                $ret[$i]->Text = $row['text'];
                $ret[$i]->Method = $row['method'];
                $ret[$i]->Paytime = new WixDate($row['paytime']);
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM bakerytransaction ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Bakerytransaction($subscriber);
                $ret[$i]->Id = $row['bakerytransactionid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Sale = $row['sale'];
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Amount = doubleval($row['amount']);
                $ret[$i]->User = $row['user'];
                $ret[$i]->Text = $row['text'];
                $ret[$i]->Method = $row['method'];
                $ret[$i]->Paytime = new WixDate($row['paytime']);
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM bakerytransaction");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Bakerytransaction($subscriber);
				$ret[$i]->Id = $row['bakerytransactionid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Sale = $row['sale'];
				$ret[$i]->Type = $row['type'];
				$ret[$i]->Amount = doubleval($row['amount']);
				$ret[$i]->User = $row['user'];
				$ret[$i]->Text = $row['text'];
				$ret[$i]->Method = $row['method'];
				$ret[$i]->Paytime = new WixDate($row['paytime']);
				$i++;
			}
			return $ret;
		}
	}
