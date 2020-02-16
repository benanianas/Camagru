<?php
// i Create Urls & load contoller (URL FORMAT : /controller/method/params)

class Core {
    protected $controller = 'Pages';
    protected $method = 'index';
    protected $param = [];

    public function __construct ()
    {
        $url = $this->getUrl();

        //controller part

        if (file_exists("app/controllers/".ucwords($url[0]).".php"))
        {
            //search for the first $url value in app/controllers & if exits set it as a $controller
            $this->controller = ucwords($url[0]);
            unset($url[0]);
        }

        require_once 'app/controllers/'.$this->controller.'.php';
        $this->controller = new $this->controller;

        //method part

        if (isset($url[1]))
            if (method_exists($this->controller, $url[1]))
                $this->method = $url[1];
        unset($url[1]);

        //params part

        $this->param = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->param);

        // neeed to fix the error when calling any method other than index from pages class without a parametre
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
