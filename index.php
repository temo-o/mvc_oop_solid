<?php
    
    include 'config.php';
    
    // This will set the database, so we can use in other classes
    // When creating BaseModel, database.class.php's get_db method will be called and establish db connection
    $base_route = new Routes\BaseRoute(REQUEST_URI);
    
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        
        $controller_instance = $base_route->get_controller(); // Get controller object INSTANCE (not just name of the controller)
        #print_r($controller_instance->index_param);
        #$module_instance = new UserController();

        $view = new View\View($controller_instance);
        if(!(isset($_SESSION["user"]) && isset($_SESSION["user"]["user_id"]) && $_SESSION["user"]["user_id"]>0) || $base_route->module == "login"){
            if($base_route->module != "login"){
                $controller_instance->redirect();
            }
        }
        if($base_route->module == "image"){
            $text = "Image Text";
            if(!empty($_GET["text"])){
                $text = $_GET["text"];
            }
            $width = "200";
            if(!empty($_GET["width"])){
                $width = $_GET["width"];
            }
            $height = "200";
            if(!empty($_GET["height"])){
                $height = $_GET["height"];
            }
            $image_params = [
                "text"=>$text,
                "width"=>$width,
                "height"=>$height
            ];
            $controller_instance->generate_image_text($image_params);
        }
        else{
            $view->render();
        }

    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //print_r($_POST);
        // POST will be used for ajax requests only (I hope this is a good idea)
        $controller_instance = $base_route->post_controller($_POST);
    }

?>