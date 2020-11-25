<?php


    class Mail
    {
        public $Body,
            $Subject,
            $From,
            $To,
            $isHTML,
            $FromName,
            $ToName,
            $ReplyTo,
            $CC,
            $BCC,
            $AltBody,
            $ReplyToName,
            $Attachments = array();

        public function AddAttachment($file)
        {
            array_push($file);
        }

        public static function Send(Subscriber $subscriber, Mail $email)
        {
            $request = new Request($subscriber->Domain."/mail");
            $request->AddParameter("userkey", $subscriber->Key);
            $request->AddParameter("intent", "send-mail");

            $request->AddParameter("from", $email->From);
            $request->AddParameter("to", $email->To);
            $request->AddParameter("subject", $email->Subject);
            $request->AddParameter("body", $email->Body);
            $request->AddParameter("altbody", $email->AltBody);
            $request->AddParameter("fromname", $email->FromName);
            $request->AddParameter("toname", $email->ToName);
            $request->AddParameter("replytoname", $email->ReplyToName);
            $request->AddParameter("replyto", $email->ReplyTo);
            $request->AddParameter("ishtml", $email->isHTML);
            $request->AddParameter("attachment", $email->Attachments);

            try {
                $response = $request->Execute();

                if ($response->GetFormat() == "JSON") {
                    try {
                        if ($response->Content->status == "success") {
                            return true;
                        } else {
                            return false;
                        }
                    } catch (Exception $e) {
                        return false;
                    }
                } else {
                    return false;
                }
            }
            catch (Exception $e)
            {
                return false;
            }
        }

        public static function ConfirmIntegrity(Subscriber $subscriber)
        {
            $request = new Request($subscriber->Domain."/mail");
            $request->AddParameter("userkey", $subscriber->Key);
            $request->AddParameter("intent", "check");

            $response = $request->Execute();

            if($response->GetFormat() == "JSON")
            {
                try{
                    if($response->Content->status == "available")
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
                catch (Exception $e)
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
    }