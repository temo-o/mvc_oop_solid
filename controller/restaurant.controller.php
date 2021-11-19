<?php

    class RestaurantController extends BaseController implements IBaseController{

        private $model_instance;

        public function __construct(){
            $this->model_instance = new Restaurant();
            #$this->model_instance = new Restaurant(["index_param"=>parent::$index_param]);
            #$this->model_instance->index_param = $this->index_param;
        }

        public function add_restaurant($params){

            $this->model_instance->add_restaurant($params);
            $this->response = $this->model_instance->response;
            $this->return_response();

        }

        public function get_restaurant(){

            $this->model_instance->get_restaurant();
            $this->response = $this->model_instance->response;
            $this->return_response();

        }

        public function get_restaurant_details($params){
            
            $user_session = Session::get_user_session();
            #print_r($user_session);
            $visit_params  = [
                "crud"=>[
                    "restaurant_id"=>$params["id"],
                    "tourist_id"=>$user_session["user_id"]
            
                ]
            ];

            #$visit_instance = new Visit("restaurant_visits");
            #$visit_instance->save_visit($visit_params);

            #$visit_instance->save_visit_simulate($visit_params, 50000);

            $this->model_instance->get_restaurant_details($params);
            $this->response = $this->model_instance->response;
            $this->return_response();

        }

    }

?>