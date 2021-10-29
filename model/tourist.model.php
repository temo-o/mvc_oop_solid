<?php
    
    class Tourist extends BaseModel{

        public function __construct(){
            $this->_table = "tourists";
            parent::__construct($this->_table);
        }

        public function get_tourists(){
            $this->response = $this->_conn
                ->get_result_set();
            
        }

        public function add_tourist($params){

            if(!isset($params["crud"])){
                return[
                    "success"=>false,
                    "msg"=>"No CRUD params are set"
                ];
            }

            $crud_params = $params["crud"];

            $res = $this->_conn
                ->insert($crud_params);
            
            if(!$res){
                return [
                    "succcess"=>false,
                    "msg"=>"Error while creating new tourist entry",
                    "res"=>$res
                ];
            }

            $this->response = [
                "success"=>true,
                "msg"=>"Tourist entry created",
                "res"=>$res
            ];
            
        }

    }
        

?>