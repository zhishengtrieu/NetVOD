<?php

namespace netvod\action;

use netvod\auth\Auth;

class ActiveCompte extends Action
{

    public function execute(): string
    {
        $get=$_GET['email'];
        $env=$_GET['passwd'];
        if (Auth::authenticate($get,$env)){
            if (isset($_COOKIE['token'])) {
                if ($_GET['id'] === null) {
                    echo ' gg';

            }
        }
        }
        return "lol";
    }
}


