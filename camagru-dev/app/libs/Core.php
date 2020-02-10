<?php
// i Create Urls & load contoller (URL FORMAT : /controller/method/params)

class Core {
    protected $controller = 'Pages';
    protected $method = 'index';
    protected $param = [];

    public function __construct ()
    {
        print_r($this->getUrl());
    }
    public function getUrl()
    {
        if(isset($_GET['url']))
        {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }

}