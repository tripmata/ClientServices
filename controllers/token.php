<?php

    echo json_encode([
        "status"=>"success",
        "data"=>Random::GenerateId(32),
        "message"=>"Token generated"
    ]);
