<?php


    class Inventoryactivity
    {
        const Usage = "usage";
        const Damage = "damage";
        const Surplus = "surplus";
        const Returned = "return";
        const Opening = "opening";
        const Restocking = "restocking";
        const Sold = "sold";

        public static function BuildStatistics($list)
        {
            $ret = new stdClass();
            $ret->Usage = 0;
            $ret->UsageEvents = 0;
            $ret->Surplus = 0;
            $ret->SurplusEvents = 0;
            $ret->Return = 0;
            $ret->ReturnEvents = 0;
            $ret->Restocking = 0;
            $ret->RestockingEvents = 0;
            $ret->Sale = 0;
            $ret->SaleEvents = 0;
            $ret->Damage = 0;
            $ret->DamageEvents = 0;

            for($i = 0; $i < count($list); $i++)
            {
                if($list[$i]->Type == "usage")
                {
                    $ret->UsageEvents ++;
                    $ret->Usage += $list[$i]->Difference;
                }
                if($list[$i]->Type == "damage")
                {
                    $ret->DamageEvents ++;
                    $ret->Damage += $list[$i]->Difference;
                }
                if($list[$i]->Type == "surplus")
                {
                    $ret->SurplusEvents ++;
                    $ret->Surplus += $list[$i]->Difference;
                }
                if($list[$i]->Type == "return")
                {
                    $ret->ReturnEvents ++;
                    $ret->Return += $list[$i]->Difference;
                }
                if($list[$i]->Type == "restocking")
                {
                    $ret->RestockingEvents ++;
                    $ret->Restocking += $list[$i]->Difference;
                }
                if($list[$i]->Type == "sold")
                {
                    $ret->SaleEvents ++;
                    $ret->Sale += $list[$i]->Difference;
                }
            }
            return $ret;
        }
    }