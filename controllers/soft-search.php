<?php

    $ret = new stdClass();
    $ret->results = [];

    if($_REQUEST['q'] != "")
    {
        $data = Property::SearchActiveListing($_REQUEST['q']);

        for($i = 0; $i < count($data); $i++)
        {
            $d = new stdClass();

            if(stripos($data[$i]->Cityname, $_REQUEST['q']) !== false)
            {
                $d->title = $data[$i]->Cityname;
                $d->description = $data[$i]->Statename;
            }
            else if(stripos($data[$i]->Statename, $_REQUEST['q']) !== false)
            {
                $d->title =  $data[$i]->Statename;
            }
            else if(stripos($data[$i]->Address, $_REQUEST['q']) !== false)
            {
                $d->title =  $data[$i]->Address;
                $d->description =  $data[$i]->Cityname." ".$data[$i]->Statename;
                array_push($ret->results, $d);

                $d = new stdClass();
                $d->title = $data[$i]->Name;
                $d->description =  $data[$i]->Cityname." ".$data[$i]->Statename;
                $d->image =  "files/".$data[$i]->Banner;
                $d->value = $data[$i]->Name;
                $d->url = "p/".$data[$i]->Meta."?check-in=".date("m/d/Y")."&check-out=".date("m/d/Y", (time() + ((60 * 60) * 24)));
            }
            else if(stripos($data[$i]->Name, $_REQUEST['q']) !== false)
            {
                $d->title = $data[$i]->Name;
                $d->description =  $data[$i]->Cityname." ".$data[$i]->Statename;
                $d->image =  "files/".$data[$i]->Banner;
                $d->url = "p/".$data[$i]->Meta."?check-in=".date("m/d/Y")."&check-out=".date("m/d/Y", (time() + ((60 * 60) * 24)));
            }
            else
            {
                $d->title = $data[$i]->Name;
                $d->description =  $data[$i]->Cityname." ".$data[$i]->Statename;
                $d->image =  "files/".$data[$i]->Banner;
                $d->url = "p/".$data[$i]->Meta."?check-in=".date("m/d/Y")."&check-out=".date("m/d/Y", (time() + ((60 * 60) * 24)));
            }
            array_push($ret->results, $d);
        }
    }
    echo json_encode($ret);