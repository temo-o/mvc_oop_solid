<?php

    class Session {

        public function set_user_session($session_params){
            $_SESSION["user"] = $session_params;
        }

        public function destroy_user_session(){
            $_SESSION = array();
        }

    }

?>