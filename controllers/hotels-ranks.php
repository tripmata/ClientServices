<?php

    $db = DB::GetDB();

    $limit = 3;

    $ret = [];

    $res = $db->query("SELECT * from reservation ORDER BY created DESC LIMIT 100");

    $hotels = [];

    while(($row = $res->fetch_assoc()) != null)
    {
        if(isset($hotels[$row['property']]))
        {
            $hotels[$row['property']] ++;
        }
        else
        {
            $hotels[$row['property']] = 1;
        }
    }
    asort($hotels);
    $keys = array_keys($hotels);

    for($i = 0; $i < count($keys); $i++)
    {
        $p = new Property($keys[$i]);
        $p->CalcPrice();

        array_push($ret, $p);
        if(count($ret) >= $limit)
        {
            break;
        }
    }


    if(count($ret) < $limit)
    {
        $ht = Property::order('Vies','DESC');

        for($i = 0; $i < count($ht); $i++)
        {
            $found = false;

            for($j = 0; $j < count($ret); $j++)
            {
                if($ret[$j]->Id == $ht[$i]->Id)
                {
                    $found = true;
                    break;
                }
            }

            if($found === false)
            {
                $ht[$i]->CalcPrice();
                array_push($ret, $ht[$i]);
            }
            
            if(count($ret) >= $limit)
            {
                break;
            }
        }
    }

    echo json_encode($ret);