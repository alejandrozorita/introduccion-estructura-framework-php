<?php

namespace App\Http;

/**
 * Class Request
 *
 * @package App\Http
 */
class Request
{
    protected $segmentos = [];
    protected $controller;
    protected $method;


    public function __construct()
    {
        $this->segmentos = explode('/', $_SERVER['REQUEST_URI']);

        $this->setController();
        $this->setMethod();
    }


    public function setController()
    {
        $this->controller = empty($this->segmentos[1])
          ? 'home'
          : $this->segmentos[1];
    }


    public function setMethod()
    {
        $this->method = empty($this->segmentos[2])
          ? 'index'
          : $this->segmentos[2];
    }


    /**
     * @return string
     */
    public function getController()
    {
        $controller = ucfirst($this->controller);

        return "App\Http\Controllers\\{$controller}Controller";
    }


    public function getMethod()
    {
        return $this->method;
    }


    public function send()
    {
        $controller = $this->getController();
        $method = $this->getMethod();

        $response = call_user_func([
          new $controller(),
          $method
        ]);

        try {
            if ($response instanceof Response) {
                $response->send();
            } else {
                throw new \Exception("Error processind Request", 1);
            }
        } catch (\Exception $e) {
            echo "Detail {$e->getMessage()}";
        }
    }

}