<?php

    class ErrorController extends BaseController implements IBaseController{

        private $model_instance;

        public function __construct(){
            $this->model_instance = new Error();
        }

    }

?>