<?php

class LogoutController
{
    public function index(){
        session_start();
        session_destroy();
        header("Location: " . $GLOBALS['appurl'] . "/login");
        die();
    }
}