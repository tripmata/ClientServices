<?php

    if(isset($_POST['token']))
    {
        if((isset($_SESSION[$_POST['token']])) || (Session::Get($_POST['token']) != null))
        {
            $id = isset($_SESSION[$_POST['token']]) ? $_SESSION[$_POST['token']] : Session::Get($_POST['token'])->User;

            $user = new Partner($id);

            if($user->Id != "")
            {
                echo json_encode([
                    "status"=>"success",
                    "data"=>$user,
                    "message"=>"user retrieved successfully"
                ]);
            }
            else
            {
                echo json_encode([
                    "status"=>"failed",
                    "data"=>"login",
                    "message"=>"Invalid user detected"
                ]);
            }
        }
        else
        {
            echo json_encode([
                "status"=>"failed",
                "data"=>null,
                "message"=>"Invalid token"
            ]);
        }
    }
    else
    {
        echo json_encode([
            "status"=>"failed",
            "data"=>null,
            "message"=>"Invalid request"
        ]);
    }