<?php

    class UserController extends BaseController implements IBaseController{

        private $model_instance;

        public function __construct(){
            
            $this->model_instance = new User();
        }

        public function get_users(){

            $this->model_instance->get_users();
            $this->response = $this->model_instance->response;
            $this->return_response();

        }

    }

?>