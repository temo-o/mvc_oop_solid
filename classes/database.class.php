<?php

    class Database{

        private static $db_host = 'localhost';
        private static $db_user = 'root';
        private static $db_password = '';
        private static $db_name = 'trips_01';

        public static $db = null;

        private function set_db(){
            if(static::$db == null){
                static::$db = mysqli_connect(self::$db_host, self::$db_user, self::$db_password, self::$db_name);
            }

            return static::$db;
        }

        public static function get_db(){
            if(static::$db == null){
                static::set_db();
            }
            
            return self::$db;
        }

        private function set_db_pdo(){
            if(static::$db == null){
                static::$db = new PDO('mysql:host='.self::$db_host.';dbname='.self::$db_name, self::$db_user, self::$db_password);
            }

            return static::$db;
        }

        

        public static function get_db_pdo(){
            if(static::$db == null){
                static::set_db_pdo();
            }
            
            return self::$db;
        }


    }

?>