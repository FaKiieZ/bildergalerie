<?php

class GalleryController
{
    public function index(){
        $view = new View('gallery');
        $view->title = 'Bilderdatenbank';
        $view->heading = 'Bilderdatenbank';
        $view->display();
    }
}