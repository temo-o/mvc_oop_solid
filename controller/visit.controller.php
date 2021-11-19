<?php

    class VisitController extends BaseController implements Ivisit{

        protected $module_name;
        protected $params;

        public function __construct(){
            $this->model_instance = new Visit();
        }

        public function save_visit(str $module_name, array $params){

            $this->module_name = $this->module_name;
            $this->params = $this->params;

            $visit_class_name = $this->module_name."Visit";

            $module_instance = new $visit_class_name($this->params);

        }

    }


?>