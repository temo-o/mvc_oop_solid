<?php

    interface IDatabase{
        public static function get_db();
        public function close_connection();
    }

?>