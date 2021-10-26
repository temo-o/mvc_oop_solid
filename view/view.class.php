<?php

    class View{
        
        public IBaseController $model_instance;

        public function __construct(IBaseController $model_instance){
            $this->model_instance = $model_instance;
        }

        public function render(): void{

            if($this->model_instance->module_identifier == "Login"){
                
            }
        }

        /*public static function render_default_layout($model){

            require("partials/head.php");
            require("partials/header.php");
            require("partials/left_sidebar.php");
            require("partials/content.php");
            #require("view/".$model.".view.php");
            require("partials/footer.php");

        }

        public static function render_login_layout($model){

            require("partials/head.login.php");
            require("view/".$model.".view.php");
            require("partials/footer.login.php");

        }*/

    }

    class RenderDefaultLayout implements IView{

        public function __construct(){

        }

        public static function render(){
            require("partials/head.php");
            require("partials/header.php");
            require("partials/left_sidebar.php");
            require("partials/content.php");
            #require("view/".$model.".view.php");
            require("partials/footer.php");
        }

    }

    class RenderLoginLayout implements IView{

        public function __construct(){

        }

        public static function render(){
            require("partials/head.login.php");
            require("view/".$model.".view.php");
            require("partials/footer.login.php");
        }

    }

?>