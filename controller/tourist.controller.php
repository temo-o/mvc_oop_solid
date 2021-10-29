<?php

    class TouristController extends BaseController implements IBaseController{

        private $model_instance;

        public function __construct(){
            
            $this->model_instance = new Tourist();
        }

        public function add_tourist($params){
            
            $this->model_instance->add_tourist($params);
            $this->response = $this->model_instance->response;
            $this->return_response();

        }

        public function get_tourists(){
            
            $this->model_instance->get_tourists();
            $this->response = $this->model_instance->response;
            $this->return_response();

        }

    }

?>