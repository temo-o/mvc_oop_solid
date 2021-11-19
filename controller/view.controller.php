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
            
            $user_session = Session::get_user_session();
            
            if(empty($user_session["role_id"])){
                
                return false;
            }

            if($user_session["role_id"] == 1){
                $params["view"] = "staff/".$params["view"];
                (new get_content_staff)->get_content($params);
            }

            if($user_session["role_id"] == 2){
                $params["view"] = "tourist/".$params["view"];
                (new get_content_tourist)->get_content($params);
            }

            #$view_title = $params["view"];
            #require("view/$view_title.view.php");
        }

    }

    class get_content_staff extends ViewController{

        public function get_content($params){
            #echo "Here";
            $view_title = $params["view"];
            require("view/$view_title.view.php");
        }

    }

    class get_content_tourist extends ViewController{

        public function get_content($params){
            $view_title = $params["view"];
            require("view/$view_title.view.php");
        }

    }

?>