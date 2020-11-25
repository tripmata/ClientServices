<?php
	/* Generated by Wixnit Class Builder 
	// Sep, 01/2019
	// Building class for Faqcategory
	*/

	class Faqcategory
	{
		public $Id = "";
		public $Created = 0;
		public $Name = "";
		public $Sort = 0;
		public $Status = false;
		
		private $subscriber = null;

		function __construct(Subscriber $subscriber)
		{
			$this->subscriber = $subscriber;
		}
		
		public function Initialize($arg=null)
		{
			if($arg != null)
			{
				$db = $this->subscriber->GetDB();

				$res = $db->query("SELECT * FROM faqcategory WHERE faqcategoryid='$arg'");

				if($res->num_rows > 0)
				{
					$row = $res->fetch_assoc();
				
					$this->Id = $row['faqcategoryid'];
					$this->Created = new WixDate($row['created']);
					$this->Name = $row['name'];
					$this->Sort = $row['sort'];
					$this->Status = Convert::ToBool($row['status']);
				}
			}
		}

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$name = addslashes($this->Name);
			$sort = Convert::ToInt($this->Sort);
			$status = Convert::ToInt($this->Status);

			if($res = $db->query("SELECT faqcategoryid FROM faqcategory WHERE faqcategoryid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE faqcategory SET name='$name',sort='$sort',status='$status' WHERE faqcategoryid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT faqcategoryid FROM faqcategory WHERE faqcategoryid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO faqcategory(faqcategoryid,created,name,sort,status) VALUES ('$id','$created','$name','$sort','$status')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM faqcategory WHERE faqcategoryid='$id'");
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT faqcategoryid FROM faqcategory WHERE name LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Faqcategory($subscriber);
				$ret[$i]->Initialize($row['faqcategoryid']);
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='faqcategoryid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT faqcategoryid FROM faqcategory WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Faqcategory($subscriber);
                $ret[$i]->Initialize($row['faqcategoryid']);
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT faqcategoryid FROM faqcategory ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Faqcategory($subscriber);
				$ret[$i]->Initialize($row['faqcategoryid']);
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM faqcategory");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Faqcategory($subscriber);
				$ret[$i]->Id = $row['faqcategoryid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Name = $row['name'];
				$ret[$i]->Sort = $row['sort'];
				$ret[$i]->Status = Convert::ToBool($row['status']);
				$i++;
			}
			return $ret;
		}
	}