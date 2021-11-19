<?php

    class MenuController extends BaseController implements IBaseController{

        private $model_instance;

        public function __construct(){
            
            $this->model_instance = new Menu();
        }

        public function get_menu($params){
            
            $this->model_instance->get_menu($params);
            $this->response = $this->model_instance->response;
            $this->return_response();

        }

    }

?>