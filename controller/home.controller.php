<?php

    class HomeController extends BaseController{

        public function __construct(){
            echo "Constructing HomeController";
            Databasae::set_connection_type("MySQL", true);
            
        }

        public function get_view(){

            #View::render_default_layout("home");
            #require("view/login.view.php");

        }

    }

?>