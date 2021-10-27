<?php
    namespace View;
    
    abstract class View {
        
        public IBaseController $model_instance;

        public function __construct(IBaseController $model_instance){
            $this->model_instance = $model_instance;
        }

        public static abstract function render(): void;

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

    class RenderDefaultLayout extends View {

        public static function render():void{
            $cur_dir = dirname(__FILE__);
            $cur_dir = str_replace("view","", $cur_dir);
           
            require("partials/head.php");
            require("partials/header.php");
            require("partials/left_sidebar.php");
            require("partials/content.php");
            #require("view/".$model.".view.php");
            require("partials/footer.php");
        }

    }

    class RenderLoginLayout implements \IView{

        public static function render(): void{
            require("partials/head.login.php");
            #require("view/".$model.".view.php");
            require("view/login.view.php");
            require("partials/footer.login.php");
        }

    }

?>