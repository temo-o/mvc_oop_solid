<?php
    namespace View;
    
    class View {
        
        public \IBaseController $model_instance;

        public function __construct(\IBaseController $model_instance){
            $this->model_instance = $model_instance;
        }

        public function render(){

            $class_str = ("View\Render".$this->model_instance->layout."Layout");
            $class_implements_arr = class_implements($class_str);
            $class_implements = reset($class_implements_arr);

            try{
                if(class_exists($class_str) && $class_implements == "IView" ){
                    ("View\Render".$this->model_instance->layout."Layout")::render();
                }
                else{
                    
                    throw new \Exception("Layout $class_str not found ");
                }
            }
            catch(Exception $e){
                echo $e;
            }

            
        }

        /*public function render(){
            print_r($this->model_instance->layout);
            if(strtolower($this->model_instance->module_identifier) == "login"){
                RenderLoginLayout::render(); 
            }
            else{
                RenderDefaultLayout::render();
            }
        }*/

    }

    #class RenderDefaultLayout extends View {
    class RenderDefaultLayout implements \IView {

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

    class RenderFullWidthLayout implements \IView{
        
        public static function render(): void{
            
            require("partials/head.php");
            require("partials/header.php");
            #require("partials/left_sidebar.php");
            require("partials/content.php");
            require("partials/footer.php");
        }

    }

?>