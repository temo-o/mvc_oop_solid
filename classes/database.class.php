<?php

    class Database{

        private static $db_host = 'localhost';
        private static $db_user = 'root';
        private static $db_password = '';
        private static $db_name = 'trips_01';

        public static $db = null;

        public static $connection_types = ["MySQL"=>false, "PDO"=>false];

        public static $connections = null;

        public static function set_connection_type(string $connection_type, bool $connection_value){
            self::$connections = new ArrayObject();

            try{
                if(class_exists($connection_type."Connection") && $connection_type."Connection" instanceof IDatabase ){
                    self::$connections[$connection_type] = ($connection_type."Connection")::get_db();
                    return self::$connections[$connection_type];
                }
                else{
                    $connection_types_str = implode(",",( array_keys( self::$connection_types ) ) );
                    throw new Exception("Connection type must be any of those types: ".$connection_types_str.";" );
                    return false;
                }
            }
            catch(Exception $e){
                echo $e;
            }
        }

        /*private static function set_db(){
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

        private static function set_db_pdo(){
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
        }*/

    }

    class MySQLConnection implements IDatabase{

        private static $db_host = 'localhost';
        private static $db_user = 'root';
        private static $db_password = '';
        private static $db_name = 'trips_01';

        public static $db = null;

        private static function set_db(){
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

        public function close_connection(){
            static::$db->close();
        }

    }

    class PDOConnection implements IDatabase{

        private static $db_host = 'localhost';
        private static $db_user = 'root';
        private static $db_password = '';
        private static $db_name = 'trips_01';

        public static $db = null;

        private static function set_db(){
            if(static::$db == null){
                static::$db = new PDO('mysql:host='.self::$db_host.';dbname='.self::$db_name, self::$db_user, self::$db_password);
            }

            return static::$db;
        }

        public static function get_db(){
            if(static::$db == null){
                static::set_db();
            }
            
            return self::$db;
        }

        public function close_connection(){
            static::$db = null;
        }

    }

?>