<?php

    $site = new Site($GLOBALS['subscriber']);

    $ret = new stdClass();
    $ret->status = "success";
    $ret->data = "
        <div class='w3-row'>
            <div class='w3-col l4 m4 s12 contact-us-data' style='display: none;'>
                <div class='l-pad-4 m-pad-2 s-pad-1'>
                    <div>
                        <img src='images/ticket_2.png' style='width: 60px;'/>
                        <h3 style=''>Raise a ticket</h3>
                        <p style='line-height: 170%;'>
                            A ticket is the most convenient way of getting help and it's really easy and convinient to use.
                        </p>
                        <br/>
                        <a href='#settings/ticket'>
                            <button class='ui blue sleak button'>raise a ticket</button>
                        </a>
                    </div>
                </div> 
            </div>
            <div class='w3-col l4 m4 s12 contact-us-data' style='display: none;'>
                <div class='l-pad-4 m-pad-2 s-pad-1'>
                    <div>
                        <img src='images/at.png' style='width: 60px;'/>
                        <h3 style=''>Send us a mail</h3>
                        <p style='line-height: 170%;'>
                            You can also send us a mail using any of these addresses
                            <br/>
                            <h6><i class='open envelope blue icon'></i> ".$site->Email1."</h6>
                            <h6><i class='open envelope blue icon'></i> ".$site->Email2."</h6>
                        </p>
                    </div>
                </div> 
            </div>
            <div class='w3-col l4 m4 s12 contact-us-data' style='display: none;'>
                <div class='l-pad-4 m-pad-2 s-pad-1'>
                    <div>
                        <img src='images/phone_call.png' style='width: 60px;'/>
                        <h3 style=''>Give us a call</h3>
                        <p style='line-height: 170%;'>
                            Or give us a call
                            <br/>
                            <h6><i class='phone blue icon'></i> ".$site->Phone1."</h6>
                            <h6><i class='phone blue icon'></i> ".$site->Phone2."</h6>
                        </p>
                    </div>
                </div>     
            </div>
        </div>";

    echo json_encode($ret);