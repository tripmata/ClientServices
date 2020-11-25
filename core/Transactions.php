<?php


    class Transactions
    {
        public $Paid = 0;
        public $Unpaid = 0;
        public $Total = 0;

        public static function Breakdown($trans)
        {
            $transaction = new Transactions();

            for($i = 0; $i < count($trans); $i++)
            {
                if($trans[$i]->Created->Month < date("m"))
                {
                    $transaction->Paid += $trans[$i]->Paid;
                    $transaction->Unpaid += ($trans[$i]->Amount - $trans[$i]->Paid);
                    $transaction->Total += $trans[$i]->Amount;
                }
            }
            return $transaction;
        }
    }