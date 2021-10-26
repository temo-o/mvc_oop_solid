<?php
    
    class User extends BaseModel{

        public function __construct(){
            $this->_table = "users";
            parent::__construct($this->_table);
        }

        public function get_users(){
            #echo "A";
            $this->response = $this->_conn
                ->get_result_set();
            
        }

    }
        

?>