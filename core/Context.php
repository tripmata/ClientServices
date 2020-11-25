<?php


    class Context
    {
        protected $user = null;
        protected $event = null;
        protected $item = null;

        public static function Create($user, $event=null, $item=null)
        {
            // TODO: Properly design context creation

            $c = new Context();
            $c->user = $user;
            $c->event = $event;
            $c->item = $item;
            return $c;
        }

        public static function ProcessContent(Context $context, $content)
        {
            $ret = preg_replace("{name}", isset($context->user->Name) ? $context->user->Name : "", $content);
            $ret = preg_replace("{surname}", isset($context->user->Surname) ? $context->user->Name : "", $ret);

            // TODO: Complete building context processing

            return $ret;
        }
    }