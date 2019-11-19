<?php
class Core {
    private $basename = "";
    private $url = "";
    private $get_data = [];
    private $controller_name = "";
    private $method_name = "";
    private $controller_data = [];

    public function __construct(){
        $this->set_basename();
        $this->init_query();
        $router = new Router();
        $controller = $router->getController($this->url);
        if($controller['controller'] == ""){
            http_response_code(404);
            die("Error 404 - Page not found");
        }
        $controller_arr = explode("@", $controller['controller']);
        $this->controller_name = $controller_arr[0];
        $this->method_name = $controller_arr[1];
        $this->controller_data = $controller['data'];
        $this->load_controller();
    }

    public function set_basename(){
        if(dirname($_SERVER['SCRIPT_NAME']) != '/'){
            $this->basename = dirname(str_replace("/public","",$_SERVER['SCRIPT_NAME']));
        }
    }

    public function init_query(){
        $query = explode("?", str_replace($this->basename,"",$_SERVER['REQUEST_URI']));
        $query[0] = rtrim($query[0],'/');
        $query[0] = filter_var($query[0], FILTER_SANITIZE_URL);

        if($query[0] == ''){
            $query[0] = '/' ;
        }

        $get = [];
        if(isset($query[1])){
            foreach (explode("&",$query[1]) as $args){
                $args_pair = explode("=",$args);
                $get[$args_pair[0]] = $args_pair[1];
            }
        }
        $this->url = $query[0];
        $this->get_data = $get;

    }

    public function load_controller(){
        $data = $this->controller_data;
        global $get_data;
        $get_data = $this->get_data;

        $controller_path = APP_ROOT. '/controllers/' . $this->controller_name . '.php';

        if (file_exists($controller_path)) {
            require_once $controller_path;
            $controller = new $this->controller_name;
            $controller->call_by_method_name($this->method_name,$data);
        }else{
            http_response_code(404);
            die("Error 404 - {$this->controller_name} not found");
        }
    }
}
