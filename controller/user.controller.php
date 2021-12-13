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

        public function get_users_ssp(){
            #print_r($_POST);
            $this->model_instance->get_users_ssp();
            $this->response = $this->model_instance->response;
            $this->return_response();

        }

        public function add_user($params){
            $params["module_name"] = "user";
            $params["table"] = "users";
            $crud_instance = new Crud($params);

            $this->response = $crud_instance->add_entry($params);
            $this->return_response();

            /*
            $this->model_instance->add_user($params);
            $this->response = $this->model_instance->response;
            $this->return_response();*/
        }

        public function get_user_details($params){

            $this->model_instance->get_user_details($params);
            $this->response = $this->model_instance->response;
            $this->return_response();
        }

    }

?>