<?php

	class Crud extends BaseModel{

		protected $module_name;

		public function __construct($crud_params){

			if(empty($crud_params["module_name"])) return false;
			if(empty($crud_params["table"])) return false;
			$this->module_name = $crud_params["module_name"];

			$this->_table = $crud_params["table"];
            parent::__construct($this->_table);
			return $this;

		}

		public function add_entry($params){

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

            if(!$res || !empty($res["failed"])){
                return [
                    "succcess"=>false,
                    "msg"=>"Error while {$msg_crud_creating} new user entry",
                    "res"=>$res
                ];
            }

            #$this->response = [
            return [
                "success"=>true,
                "msg"=>"User entry {$msg_crud_created}",
                "res"=>$res
            ];

		}

	}

?>