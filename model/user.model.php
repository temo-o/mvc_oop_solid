<?php
    
    class User extends BaseModel{

        public function __construct(){
            $this->_table = "users";
            parent::__construct($this->_table);
        }

        public function get_users(){
            $this->response = $this->_conn
                ->order_by("id", "desc")
                ->get_result_set();
        }

        public function get_user_details($params){
            if(!empty($params["email"])) $identifier_value = $params["email"];
            if(!empty($params["id"])) $identifier_value = $params["id"];
            
            $this->response = $this->_conn
                ->where_raw("id = '$identifier_value' OR email = '$identifier_value'")
                ->get_one_result();
            
            return $this->response;

        }

        public function add_user($params){

            if(!isset($params["crud_fields"])){
                return[
                    "success"=>false,
                    "msg"=>"No CRUD params are set"
                ];
            }

            $crud_params = $params["crud_fields"];
            $msg_crud_creating = "creating";
            $msg_crud_created = "created";
            if(!empty($crud_params["id"])){
                $res = $this->_conn
                    ->update($crud_params, ["id"=>$crud_params["id"]]);

                $msg_crud_creating = "updating";
            }
            else{
                $res = $this->_conn
                    ->insert($crud_params);
            }
            
            if(!$res){
                return [
                    "succcess"=>false,
                    "msg"=>"Error while {$msg_crud_creating} new user entry",
                    "res"=>$res
                ];
            }

            $this->response = [
                "success"=>true,
                "msg"=>"User entry {$msg_crud_created}",
                "res"=>$res
            ];
            
        }

    }
        

?>