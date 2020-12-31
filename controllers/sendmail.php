<?php

$ret = new stdClass();

if ($GLOBALS['user']->Id != "")
{
    if ($GLOBALS['user']->Role->Messaging->ReadAccess)
    {
        $entity = Entity::getUser($GLOBALS['subscriber'], $_REQUEST['user'], $_REQUEST['type']);

        $context = Context::Create($entity);

        if ($_REQUEST['mode'] == 'internal')
        {
            $db = DB::GetDB();
            $from = $_REQUEST['from'] . '@tripmata.com';
            $to = $_REQUEST['email'];
            $fromName = $_REQUEST['name'];
            $replyTo = $_REQUEST['replyto'];
            $subject = $_REQUEST['subject'];
            $attachment = $_REQUEST['attachment'];
            $message = addslashes($_POST['message']);
            $property = $_REQUEST['property'];
            $created = time();

            // save now
            $db->query("INSERT INTO internalMessages (`fromWho`,`toWho`,fromName,replyTo,`subject`,attachment,`message`,property,created) VALUES ('$from','$to','$fromName','$replyTo','$subject','$attachment','$message','$property','$created')");

            // send message to reciepent;
            $mail = new Mail($GLOBALS['subscriber']);
            $template = new Messagetemplate($GLOBALS['subscriber']);
            $template->Initialize('lty6nx63d4q8j699');
            $mail->Body = $template->Body;

            // add full name
            $mail->Body = str_replace('{contactperson}', ucwords($entity->Name . ' ' . $entity->Surname), $mail->Body);

            // replace from
            $mail->Body = str_replace('{from}', $_REQUEST['name'], $mail->Body);

            // continue
            $mail->From = $template->From;
            $mail->FromName = $template->Fromname;
            $mail->Subject = $template->Subject;
            $mail->ReplyTo = $template->Replyto;
            $mail->ReplyToName = $template->Fromname;
            $mail->isHTML = 'true';
            $mail->To = $entity->Email;
            $mail->ToName = ucwords($entity->Name . ' ' . $entity->Surname);

            // send mail
            Mail::send($GLOBALS['subscriber'], $mail);

            // all good
            $ret->data = true;
        }
        else
        {
            $mail = new Mail();
            $mail->From = $_REQUEST['from'] . '@tripmata.com';
            $mail->FromName = $_REQUEST['name'];
            $mail->To = is_object($entity) ? $entity->Email : $entity;
            $mail->ToName = is_object($entity) ? ($entity->Type != "supplier" ? ($entity->Name." ".$entity->Surname) :
                ($entity->Company == "" ? $entity->Contactperson : $entity->Company)) : $entity;
            $mail->Subject = $_REQUEST['subject'];
            $mail->ReplyTo = $_REQUEST['replyto'];
            $mail->ReplyToName = $_REQUEST['replytoname'];
            $mail->Attachments = $_REQUEST['attachment'];
            $mail->Body = Context::ProcessContent($context, $_REQUEST['message']);
            $mail->Altbody = strip_tags($mail->Body);
            $mail->isHTML = 'true';

            $ret->data = Mail::Send($GLOBALS['subscriber'], $mail);
        }
        
        $ret->status = "success";
        $ret->message = "Mail sent";
    }
    else
    {
        $ret->status = "access denied";
        $ret->message = "You do not have the required privilege to complete the operation";
    }
}
else
{
    $ret->status = "login";
    $ret->data = "login & try again";
}

echo json_encode($ret);