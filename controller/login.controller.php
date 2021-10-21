<?php

    class LoginController extends BaseController{

        public $username;
        public $password;

        public function __construct(){
            #echo "Constructing HomeController";
        }

        public function get_view(){

            #View::render_default_layout("home");
            #require("view/login.view.php");

        }

        public function authenticate($params){
            $this->username = $params["username"];
            $this->password = $params["password"];
            #echo "INSIDE AUTHENTICATE";
            if($this->username == "admin@gmail.com" && $this->password == "12345"){
                $session_params = [
                    "user_id"=>5,
                    "username"=>$this->username,
                    "first_name"=>"John",
                    "last_name"=>"Doe"
                ];
                Session::set_user_session($session_params);
                $this->response = [
                    "success"=>true,
                    "msg"=>"Successfully authenticated"
                ];
            }
            else{
                $this->response = [
                    "success"=>false,
                    "msg"=>"Authentication failed"
                ];
            }

            $this->return_response();

        }

        public function logout(){
            
            Session::destroy_user_session();
            $this->response = [
                "success"=>true,
                "msg"=>"Successfully logged out"
            ];

            $this->return_response();
        }

    }

?>