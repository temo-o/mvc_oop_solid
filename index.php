<?php

#phpinfo();
    include 'config.php';
    
    // This will set the database, so we can use in other classes
    // When creating BaseModel, database.class.php's get_db method will be called and establish db connection
    $base_route = new Routes\BaseRoute(REQUEST_URI);
    
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        
        $module_instance = $base_route->get_controller(); // Get controller object INSTANCE (not just name of the controller)

        if(!(isset($_SESSION["user"]) && isset($_SESSION["user"]["user_id"]) && $_SESSION["user"]["user_id"]>0)){
            if($base_route->module != "login"){
                $module_instance->redirect();
            }
            else{
                
                View::render_login_layout($base_route->module);
            }
        }
        else{
            View::render_default_layout($base_route->module);
        }
       
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        #print_r($_POST);
        // POST will be used for ajax requests only (I hope this is a good idea)
        $module_instance = $base_route->post_controller($_POST);
    }


?>