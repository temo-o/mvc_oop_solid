<?php

    class BaseController{

        protected $response;

        public function __construct(){
            echo "<br /> Constructing Base Controller <br />";
        }

        public function redirect($page = "login"){
            header("Location: ".$page);
        }

        public function return_response(){
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($this->response);
        }

    }

?>