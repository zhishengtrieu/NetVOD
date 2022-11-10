<?php
declare(strict_types=1);
namespace netvod\action;
class LogoutAction extends Action{
    public function execute(): string{
        session_destroy();
        return "Vous êtes déconnecté";
    }
}