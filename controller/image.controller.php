<?php

    class ImageController extends BaseController{

        public function __construct(){
            #echo "Constructing HomeController";
            #Databasae::set_connection_type("MySQL", true);
            
        }

        public function generate_image_text($params):void{
            
            $text = $params["text"];
            $width = $params["width"]?$params["width"]:200;
            $height = $params["height"]?$params["height"]:200;
 
            header("Content-Type: image/png");
            $im = @imagecreate($width, $height) or die("Cannot Initialize new GD image stream");
            $background_color = imagecolorallocate($im, 255, 255, 255);
            $text_color = imagecolorallocate($im, 0, 0, 0);
            imagestring($im, 100, 50, ($height-130),  $text, $text_color);
            imagepng($im);
            imagedestroy($im);

        }

        public function get_view(){

            #View::render_default_layout("home");
            #require("view/login.view.php");

        }

    }

?>