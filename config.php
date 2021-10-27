<?php

    session_start();

    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);
    
    define("BASE_URL", __dir__);
    define("REQUEST_URI", $_SERVER["REQUEST_URI"]);
    define("BASE_FOLDER", "/trips_04/mvc_oop_solid");

    require_once("base_config.php");
    
    setcookie("BASE_FOLDER", BASE_FOLDER, time() + (86400 * 30), "/"); // 86400 = 1 day

    // Autoload classes. All classes should be named like *.class.php "|| *.model.php || *.controller.php || *.route.php
    // Function will autoload classes so there is no need to include individual files
    function autoload($class){
        #echo "$class <br /";
        if(preg_match("/[.a-zA-Z_-]/", $class)){
           
            $class = strtolower($class);
            #echo "Class: $class <br />";
            if($class == "basemodel"){
                include BASE_URL."/model/base.model.php";
                return;
            }

            if($class == "basecontroller"){
                include BASE_URL."/interfaces/controller.interface.php";
                include BASE_URL."/controller/base.controller.php";
                return;
            }

            if($class == "routes\baseroute"){
                include_once BASE_URL."/controller/view.controller.php";
                include BASE_URL."/routes/base.route.php";
                return;
            }

            if($class == "view"){
                include BASE_URL."/interfaces/view.interface.php";
                include BASE_URL."/view/view.class.php";
                include_once BASE_URL."/controller/view.controller.php";
                return;
            }

            if(strpos($class, "view") > -1){
                include_once BASE_URL."/interfaces/view.interface.php";
                include_once BASE_URL."/view/view.class.php";
                return;
            }
            #echo "class: $class <br />";
            if(file_exists(BASE_URL."/classes/".$class.".class.php")){
                include_once BASE_URL."/classes/".$class.".class.php";
            }
            if(file_exists(BASE_URL."/model/".$class.".model.php")){
                include_once BASE_URL."/model/".$class.".model.php";
            }
            if(file_exists(BASE_URL."/controller/".$class.".controller.php")){
                include_once BASE_URL."/controller/".$class.".controller.php";
            }
            if(strpos($class, "controller") > -1){
                // If i.e. class is called "HomeController", above if statement won't catch it 
                //so we extract name before "Controller" and apply similar (kinda) logic that above if statement has
                $class_root = substr($class, 0,strpos($class, "controller"));
                if(file_exists(BASE_URL."/controller/".$class_root.".controller.php")){
                    include BASE_URL."/controller/".$class_root.".controller.php";
                }
                
            }
        }
    }

    spl_autoload_register('autoload');
    
?>