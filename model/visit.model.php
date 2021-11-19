<?php
    
    class Visit extends BaseModel{

        public function __construct(string $table){
            $this->_table = $table;
            parent::__construct($this->_table);

        }

        public function get_visits(){
            $this->response = $this->_conn
                ->get_result_set();
            
        }

        public function get_visit_details($params){
            if(!isset($params["id"])){
                return 0;
            }
            $this->response = $this->_conn
                ->where("id", $params["id"])
                ->get_one_result();
            
        }

        public function save_visit($params){
            
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
                    "msg"=>"Error while creating new visit entry",
                    "res"=>$res
                ];
            }

            $this->response = [
                "success"=>true,
                "msg"=>"Visit entry created",
                "res"=>$res
            ];
            
        }

        public function save_visit_simulate($params, $simulate_cnt = 200000){
            
            for($i = 0; $i<$simulate_cnt; $i++){
                
                $params = [
                    "crud"=>[
                        "restaurant_id"=> (rand (1, 10)),
                        "tourist_id"=> (rand (1, 100))
                    ]
                ];
    
                $crud_params = $params["crud"];
                $this->_conn->initConn();
                $res = $this->_conn
                    ->insert($crud_params);

            }
            
            if(!$res){
                return [
                    "succcess"=>false,
                    "msg"=>"Error while creating new visit entry",
                    "res"=>$res
                ];
            }

            $this->response = [
                "success"=>true,
                "msg"=>"Visit entry created",
                "res"=>$res
            ];
            
        }

    }
        

?>