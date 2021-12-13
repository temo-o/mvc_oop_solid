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

        public function get_users_ssp(){

            $ssp_query  = 
            '
                SELECT
                u.id,
                u.email,
                u.role_id,
                u.first_name,
                u.last_name,
                u.status_flag,
                u.created,
                u.modified
                FROM users u
                ORDER BY 
                u.id DESC
            ';

            $columns = [
                "id",
                "email",
                "role_id",
                "first_name",
                "last_name",
                "status_flag",
                "created",
                "modified"
            ];

            $this->response = $this->get_ssp_result($ssp_query, $columns);

        }

        /*public function get_users_ssp(){

            $table = 
            '
                (
                    SELECT
                    u.id,
                    u.email,
                    u.role_id,
                    u.first_name,
                    u.last_name,
                    u.status_flag,
                    u.created,
                    u.modified
                    FROM users u
                    ORDER BY 
                    u.id DESC
                ) temp
            ';

            $primaryKey = 'id';
            
            $columns = array(
                array( 'db' => 'id', 'dt' => 'id', 'field' => 'id' ),
                array( 'db' => 'email', 'dt' => 'email', 'field' => 'email' ),
                array( 'db' => 'role_id', 'dt' => 'role_id', 'field' => 'role_id' ),
                array( 'db' => 'first_name', 'dt' => 'first_name', 'field' => 'first_name' ),
                array( 'db' => 'last_name', 'dt' => 'last_name', 'field' => 'last_name' ),
                array( 'db' => 'status_flag', 'dt' => 'status_flag', 'field' => 'status_flag' ),
                array( 'db' => 'created', 'dt' => 'created', 'field' => 'created' ),
                array( 'db' => 'modified', 'dt' => 'modified', 'field' => 'modified' )
            );

            $ssp_res = SSP::simple( $_POST, $this->dbs, $table, $primaryKey, $columns);
            $this->response = $ssp_res;

            #echo json_encode($ssp_res);
            #exit;
        }*/

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
            print_r($crud_params);
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