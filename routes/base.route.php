<?php

    namespace Routes;

    class BaseRoute{

        static string $url;
        private const MODULE_INDEX = 1; // If root url is http://localhost/trips/ - index 1 will be "" (empty)
        public string $module;
        private $module_instance;

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
            
            return $url_path_exploded[self::MODULE_INDEX];

        }

        public function get_controller(){
            $this->module = self::get_module_from_url();
            $controller_class_name = ucfirst($this->module)."Controller";
            return new $controller_class_name();
        }

        public function post_controller($params = false){
            if(!empty($params["module"])){
                $this->module = $params["module"];
                $controller_class_name = ucfirst($this->module)."Controller";

                if(!empty($params["exec"])){
                    $this->module_instance = new $controller_class_name();
                    $exec = $params["exec"];
                    #echo "exec: $exec";
                    return $this->module_instance->$exec($params);
                }

                return new $controller_class_name();
            }
        }

        public function get_url(){
            return self::$url;
        }

    }

?>