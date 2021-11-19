<?php
    
    class Menu extends BaseModel{

        public function __construct(){
            $this->_table = "menu";
            parent::__construct($this->_table);
        }

        public function get_menu(){
            $this->response = $this->_conn
                ->get_result_set();
            
        }

    }
        

?>