<?php
    
    class Roles extends BaseModel{

        public function __construct(){
            $this->_table = "roles";

            parent::__construct($this->_table);
        }

        public function get_roles(){
            #echo "A";
            $this->response = $this->_conn
                ->get_result_set();
            
        }

    }
        

?>