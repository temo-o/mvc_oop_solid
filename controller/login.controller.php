<?php

    class LoginController extends BaseController{

        public $username;
        public $password;

        public function __construct(){
            $this->logout();
            $this->layout = "Login";
        }

        public function authenticate_staff($params){
            $this->username = $params["username"];
            $this->password = $params["password"];
            
            $user_module = new User();
            $user_info = $user_module->get_user_details(["email"=>$this->username]);

            if(!isset($user_info["password"])){
                $this->response = [
                    "success"=>false,
                    "msg"=>"Authentication failed"
                ];

                return $this->return_response();
            }

            if($user_info["password"] != $this->password){
                $this->response = [
                    "success"=>false,
                    "msg"=>"Authentication failed"
                ];

                return $this->return_response();
            }

            $session_params = [
                "user_id"=>$user_info["id"],
                "username"=>$this->username,
                "first_name"=>"John",
                "last_name"=>"Doe",
                "role_id"=> $user_info["role_id"]
            ];
            Session::set_user_session($session_params);
            $this->response = [
                "success"=>true,
                "msg"=>"Successfully authenticated"
            ];

            return $this->return_response();

        }

        public function authenticate_tourist($params){
            $this->username = $params["username"];
            $this->password = $params["password"];
            
            $tourist_module = new Tourist();
            $tourist_info = $tourist_module->get_tourist_details(["email"=>$this->username]);

            if(!isset($tourist_info["password"])){
                $this->response = [
                    "success"=>false,
                    "msg"=>"Authentication failed"
                ];

                return $this->return_response();
            }

            if($tourist_info["password"] != $this->password){
                $this->response = [
                    "success"=>false,
                    "msg"=>"Authentication failed"
                ];

                return $this->return_response();
            }

            $session_params = [
                "user_id"=>$tourist_info["id"],
                "username"=>$this->username,
                "first_name"=>"John",
                "last_name"=>"Doe",
                "role_id"=> $tourist_info["role_id"]
            ];
            Session::set_user_session($session_params);
            $this->response = [
                "success"=>true,
                "msg"=>"Successfully authenticated"
            ];

            return $this->return_response();

        }

        public function logout(){
            
            Session::destroy_user_session();
            $this->response = [
                "success"=>true,
                "msg"=>"Successfully logged out"
            ];

            #$this->return_response();
        }

    }

?>