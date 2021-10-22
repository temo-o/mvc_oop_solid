<?php

    class RolesController extends BaseController{

        private $model_instance;

        public function __construct(){

            $this->model_instance = new Roles();

        }

        public function get_roles(){

            $this->model_instance->get_roles();
            $this->response = $this->model_instance->response;
            $this->return_response();

        }

    }

?>