<?php
    
    class User extends BaseModel{

        public function __construct(){
            $this->_table = "users";
            parent::__construct($this->_table);
        }

        public function get_users(){
            $this->response = $this->_conn
                ->get_result_set();
        }

        public function get_user_details($params){

            $identifier_value = $params["email"]?$params["email"]:$params["id"];
            
            $this->response = $this->_conn
                ->where_raw("id = '$identifier_value' OR email = '$identifier_value'")
                ->get_one_result();
            
            return $this->response;

        }

    }
        

?>