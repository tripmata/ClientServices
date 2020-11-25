<?php
	/* Generated by Wixnit Class Builder 
	// Jan, 10/2020
	// Building class for Messagetemplate
	*/

	class Messagetemplate
	{
		public $Id = "";
		public $Created = 0;
		public $From = "";
		public $Fromname = "";
		public $Replyto = "";
		public $Attachment = "";
		public $Subject = "";
		public $Body = "";
		public $Status = false;
		public $Type = "email";
		public $Title = "";

		public $Issystem = false;

		public $Events = array();
		public $Schedule = array();

		private $subscriber = "";

		function __construct(Subscriber $subscriber)
		{
			$this->subscriber = $subscriber;
		}

		public function Initialize($arg=null)
        {
            if($arg != null)
            {
                $db = $this->subscriber->GetDB();

                $res = $db->query("SELECT * FROM messagetemplate WHERE messagetemplateid='$arg'");

                if($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['messagetemplateid'];
                    $this->Created = new WixDate($row['created']);
                    $this->From = $row['fromaddress'];
                    $this->Fromname = $row['fromname'];
                    $this->Replyto = $row['replyto'];
                    $this->Attachment = $row['attachment'];
                    $this->Subject = $row['subject'];
                    $this->Body = $row['body'];
                    $this->Status = Convert::ToBool($row['status']);
                    $this->Type = $row['type'];
                    $this->Title = $row['title'];
                    $this->Issystem = Convert::ToBool($row['issystem']);
                }
            }
        }

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$from = addslashes($this->From);
			$fromname = addslashes($this->Fromname);
			$replyto = addslashes($this->Replyto);
			$attachment = addslashes($this->Attachment);
			$subject = addslashes($this->Subject);
			$body = addslashes($this->Body);
			$status = Convert::ToInt($this->Status);
			$type = addslashes($this->Type);
			$title = addslashes($this->Title);
			$issystem = Convert::ToInt($this->Issystem);

			if($res = $db->query("SELECT messagetemplateid FROM messagetemplate WHERE messagetemplateid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE messagetemplate SET fromaddress='$from',fromname='$fromname',replyto='$replyto',attachment='$attachment',subject='$subject',body='$body',status='$status',type='$type',title='$title',issystem='$issystem' WHERE messagetemplateid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT messagetemplateid FROM messagetemplate WHERE messagetemplateid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO messagetemplate(messagetemplateid,created,fromaddress,fromname,replyto,attachment,subject,body,status,type,title,issystem) VALUES ('$id','$created','$from','$fromname','$replyto','$attachment','$subject','$body','$status','$type','$title','$issystem')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM messagetemplate WHERE messagetemplateid='$id'");
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM messagetemplate WHERE issystem=0 AND (fromaddress LIKE '%$term%' OR fromname LIKE '%$term%' OR replyto LIKE '%$term%' OR subject LIKE '%$term%' OR body LIKE '%$term%' OR type LIKE '%$term%' OR title LIKE '%$term%') ORDER BY id DESC");
			while(($row = $res->fetch_assoc()) != null)
			{
			    $ret[$i] = new Messagetemplate($subscriber);
                $ret[$i]->Id = $row['messagetemplateid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->From = $row['fromaddress'];
                $ret[$i]->Fromname = $row['fromname'];
                $ret[$i]->Replyto = $row['replyto'];
                $ret[$i]->Attachment = $row['attachment'];
                $ret[$i]->Subject = $row['subject'];
                $ret[$i]->Body = $row['body'];
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Title = $row['title'];
                $ret[$i]->Issystem = Convert::ToBool($row['issystem']);
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='messagetemplateid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM messagetemplate WHERE issystem=0 AND ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Messagetemplate($subscriber);
                $ret[$i]->Id = $row['messagetemplateid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->From = $row['fromaddress'];
                $ret[$i]->Fromname = $row['fromname'];
                $ret[$i]->Replyto = $row['replyto'];
                $ret[$i]->Attachment = $row['attachment'];
                $ret[$i]->Subject = $row['subject'];
                $ret[$i]->Body = $row['body'];
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Title = $row['title'];
                $ret[$i]->Issystem = Convert::ToBool($row['issystem']);
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM messagetemplate WHERE issystem=0 ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Messagetemplate($subscriber);
                $ret[$i]->Id = $row['messagetemplateid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->From = $row['fromaddress'];
                $ret[$i]->Fromname = $row['fromname'];
                $ret[$i]->Replyto = $row['replyto'];
                $ret[$i]->Attachment = $row['attachment'];
                $ret[$i]->Subject = $row['subject'];
                $ret[$i]->Body = $row['body'];
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Title = $row['title'];
                $ret[$i]->Issystem = Convert::ToBool($row['issystem']);
				$i++;
			}
			return $ret;
		}


        public static function All(Subscriber $subscriber)
        {
            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $res = $db->query("SELECT * FROM messagetemplate WHERE issystem=0");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Messagetemplate($subscriber);
                $ret[$i]->Id = $row['messagetemplateid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->From = $row['fromaddress'];
                $ret[$i]->Fromname = $row['fromname'];
                $ret[$i]->Replyto = $row['replyto'];
                $ret[$i]->Attachment = $row['attachment'];
                $ret[$i]->Subject = $row['subject'];
                $ret[$i]->Body = $row['body'];
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Title = $row['title'];
                $ret[$i]->Issystem = Convert::ToBool($row['issystem']);
                $i++;
            }
            return $ret;
        }

		public static function GroupInitialize(Subscriber $subscriber, $array=null, $orderBy='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$query = "";

			if(is_array($array) === true)
			{
				if(count($array) == 0)
				{
					return $ret;
				}
				else
				{
					for($i = 0; $i < count($array); $i++)
					{
						if($query == "")
						{
							$query = " WHERE Messagetemplateid='".$array[$i]."'";
						}
						else
						{
							$query .= " OR Messagetemplateid ='".$array[$i]."'";
						}
					}
				}
			}
			$i = 0;
			$res = $db->query("SELECT * FROM messagetemplate".$query." ORDER BY ".$orderBy." ".$order);
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Messagetemplate($subscriber);
				$ret[$i]->Id = $row['messagetemplateid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->From = $row['fromaddress'];
				$ret[$i]->Fromname = $row['fromname'];
				$ret[$i]->Replyto = $row['replyto'];
				$ret[$i]->Attachment = $row['attachment'];
				$ret[$i]->Subject = $row['subject'];
				$ret[$i]->Body = $row['body'];
				$ret[$i]->Status = Convert::ToBool($row['status']);
				$ret[$i]->Type = $row['type'];
				$ret[$i]->Title = $row['title'];
                $ret[$i]->Issystem = Convert::ToBool($row['issystem']);
				$i++;
			}
			return $ret;
		}


        public static function Emailcount(Subscriber $subscriber)
        {
            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $res = $db->query("SELECT * FROM messagetemplate WHERE issystem=0 AND type='email'");
            $db->close();
            return $res->num_rows;
        }

        public static function SMScount(Subscriber $subscriber)
        {
            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $res = $db->query("SELECT * FROM messagetemplate WHERE issystem=0 AND type='sms'");
            $db->close();
            return $res->num_rows;
        }


        public static function Email(Subscriber $subscriber)
        {
            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $res = $db->query("SELECT * FROM messagetemplate WHERE issystem=0 AND type='email'");

            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Messagetemplate($subscriber);
                $ret[$i]->Id = $row['messagetemplateid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->From = $row['fromaddress'];
                $ret[$i]->Fromname = $row['fromname'];
                $ret[$i]->Replyto = $row['replyto'];
                $ret[$i]->Attachment = $row['attachment'];
                $ret[$i]->Subject = $row['subject'];
                $ret[$i]->Body = $row['body'];
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Title = $row['title'];
                $ret[$i]->Issystem = Convert::ToBool($row['issystem']);
                $i++;
            }
            return $ret;
        }

        public static function SMS(Subscriber $subscriber)
        {
            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $res = $db->query("SELECT * FROM messagetemplate WHERE issystem=0 AND type='sms'");

            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Messagetemplate($subscriber);
                $ret[$i]->Id = $row['messagetemplateid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->From = $row['fromaddress'];
                $ret[$i]->Fromname = $row['fromname'];
                $ret[$i]->Replyto = $row['replyto'];
                $ret[$i]->Attachment = $row['attachment'];
                $ret[$i]->Subject = $row['subject'];
                $ret[$i]->Body = $row['body'];
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Title = $row['title'];
                $ret[$i]->Issystem = Convert::ToBool($row['issystem']);
                $i++;
            }
            return $ret;
        }


        public function InitEvents()
        {

        }

        public function InitSchedules()
        {

        }
	}