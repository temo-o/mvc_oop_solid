<?php

    class BaseController implements IBaseController{

        protected $response;
        public string $module_identifier;
        public string $layout = "Default";

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