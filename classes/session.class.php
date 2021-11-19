<?php

    class Session {

        public static function set_user_session($session_params){
            $_SESSION["user"] = $session_params;
        }

        public static function get_user_session(){
            return $_SESSION["user"];
        }

        public static function destroy_user_session(){
            $_SESSION = array();
        }

    }

?>