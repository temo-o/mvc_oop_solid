<?php

    class ViewController extends BaseController{

        public function __construct(){
            #echo "Constructing HomeController";
        }

        public function get_view(){

            #View::render_default_layout("home");
            #require("view/login.view.php");

        }

        public function get_content($params){
            #print_r($params);
            
            $view_title = $params["view"];
            require("view/$view_title.view.php");
        }

    }

?>