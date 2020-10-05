<?php

namespace App\Http;

class Response
{
    protected $view;


    public function __construct($view)
    {
        $this->view = $view;
    }


    public function getView()
    {
        return $this->view;
    }


    public function send()
    {
        $content = file_get_contents(viewPath($this->getView()));

        require viewPath('layout');
    }

}