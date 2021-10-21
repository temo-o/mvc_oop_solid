<?php

    class Authorize extends BaseModel{

        private $username;
        private $password;

        public function login($username, $password){
            $this->username = $username;
            $this->password = $password;

            echo "{$this->username} - {$this->password}";
        }

    }


?>