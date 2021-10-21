<?php

    class View{

        public function render_default_layout($model){

            require("partials/head.php");
            require("partials/header.php");
            require("partials/left_sidebar.php");
            require("partials/content.php");
            #require("view/".$model.".view.php");
            require("partials/footer.php");

        }

        public function render_login_layout($model){

            require("partials/head.login.php");
            require("view/".$model.".view.php");
            require("partials/footer.login.php");

        }

    }

?>