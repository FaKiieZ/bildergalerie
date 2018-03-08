<?php


class LogoutController
{
    // Bei einem Klick auf Logout, wird die Session beendet und man gelangt zur Login-Seite.
    public function index()
    {
        session_start();
        session_destroy();
        header("Location: /login");
        die();
        
    }
}
