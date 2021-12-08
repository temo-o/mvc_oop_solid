<?php

    namespace Routes;

    class BaseRoute{

        static $url;
        private const MODULE_INDEX = 1; // If root url is http://localhost/trips/ - index 1 will be "" (empty)
        public $module;
        private $module_instance;
        static $index_param = null;

        public $params;

        public function __construct($url){
            self::$url = $url;
        }

        static function get_module_from_url(){

            $url_exploded = explode("/",self::$url);
            $url_parsed = parse_url(self::$url);
            $url_path = $url_parsed["path"];

            $url_path = preg_replace("/[a-zA-Z0-9.]+.php(?!\\\)$/", "", $url_path);

            if(BASE_FOLDER !== "/"){
                $url_path = str_replace(BASE_FOLDER, "", $url_path);
            }
            $url_path_exploded = explode("/", $url_path);
            
            if($url_path_exploded[self::MODULE_INDEX] === "" || $url_path_exploded[self::MODULE_INDEX] === "/"){
                return "home";
            }
            if(isset($url_path_exploded[(self::MODULE_INDEX)+1])){
                self::$index_param = $url_path_exploded[(self::MODULE_INDEX)+1];
            }
            
            return $url_path_exploded[self::MODULE_INDEX];

        }

        public function get_controller(){
            
            $this->module = self::get_module_from_url(); // home
            $module_identifier = ucfirst($this->module);
            
            $controller_class_name = $module_identifier."Controller"; // Home
            #\BaseController::$index_param = self::$index_param;
            if(class_exists($controller_class_name)){
                $controller_instance = new $controller_class_name();
                $controller_instance->module_identifier = $module_identifier;
                return $controller_instance;
            }
            else{
                header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
                exit;
                $controller_instance = new \ErrorController();
                $controller_instance->module_identifier = $module_identifier;
                header('WWW-Authenticate: NTLM', false);
                return $controller_instance;
                $this->redirect("error/403.html");
                exit;
            }
            
        }

        public function post_controller($params = false){
            
            if(!empty($params["module"])){
                
                $this->module = $params["module"];
                $controller_class_name = ucfirst($this->module)."Controller";
                if(!empty($params["exec"])){
                    $this->module_instance = new $controller_class_name();
                    
                    $exec = $params["exec"];
                    return $this->module_instance->$exec($params);
                }

                return new $controller_class_name();
            }
        }

        public function get_asset_file_path($folder, $file_name){
            return BASE_FOLDER."/".$folder."/".$file_name;
        }

        public function get_url(){
            return self::$url;
        }

        public function redirect($page = "login"){
            header("Location: ".$page);
        }

    }

?>