<?php
    
    class Restaurant extends BaseModel{

        public function __construct($params = []){
            $this->_table = "restaurants";
            parent::__construct($this->_table);
            /*foreach($params as $key => $param){
                $this->$key = $param;
            }*/
            
            /*if(!empty($this->index_param)){
                $this->get_restaurant_details(["id"=>$this->index_param]);
            }*/
        }

        public function get_restaurant(){


            #$query = "SELECT * FROM restaurants; SELECT * FROM restaurant_visits;";

            /*$query = "
            
                DROP TEMPORARY TABLE IF EXISTS restaurant_visits_temp;
                CREATE TEMPORARY TABLE restaurant_visits_temp
                AS
                (
                    SELECT 
                    rv.restaurant_id,
                    COUNT(rv.id) AS visit_cnt
                    FROM restaurant_visits rv
                    GROUP BY rv.restaurant_id
                );
                
                SELECT
                *
                FROM restaurants r
                JOIN restaurant_visits_temp rvt
                ON r.id = rvt.restaurant_id;

            ";*/
            
            $restaurants = $this->mysqli_call($this->mysqli_conn, "create_restaurant_visits_memory");

            foreach($restaurants as &$restaurant){
                $restaurant["visit_cnt"] = number_format($restaurant["visit_cnt"]);
            }

           #$query = "CALL create_restaurant_visits_memory();";
            
            /*$res = $this->mysqli_conn->query($query);
            
            while($row = $res->fetch_assoc){
                echo "Here";
            }

            var_dump($res);*/

            #$restaurants = [];
            /* execute multi query */
            /*$this->mysqli_conn->multi_query($query);
            do {
                
                if ($result = $this->mysqli_conn->store_result()) {
                    while ($row = $result->fetch_assoc()) {
                        $row["visit_cnt"] = number_format($row["visit_cnt"]);
                        $restaurants[] = $row;
                    }
                }
                
            } while ($this->mysqli_conn->next_result());*/

            $response = [
                "success"=>true,
                "result"=>$restaurants
            ];

            $this->response = $response;

            /*$get_restaurants_query = 
            "

                DROP TEMPORARY TABLE IF EXISTS restaurant_visits_temp;
                CREATE TEMPORARY TABLE restaurant_visits_temp
                AS
                (
                SELECT 
                rv.restaurant_id,
                COUNT(rv.id) AS visit_cnt
                FROM restaurant_visits rv
                GROUP BY rv.restaurant_id);
                
                
                #SELECT * FROM restaurant_visits_temp
                
                SELECT
                *
                FROM restaurants r
                JOIN restaurant_visits_temp rvt
                ON r.id = rvt.restaurant_id;
            
            ";
            
            #$get_restaurants_result = $this->mysqli_conn->multi_query($get_restaurants_query);
            $this->mysqli_conn->multi_query($get_restaurants_query);
            
            $get_restaurants_result = $this->mysqli_conn->store_result();

            #print_r($get_restaurants_result);

            $restaurants = [];


            while($row = $get_restaurants_result->fetch_row()){
                $restaurants[] = $row;
            }

            /*$get_restaurant_visits_count_query = 
            "
                SELECT 
                rv.restaurant_id,
                COUNT(rv.id) AS visit_cnt
                FROM restaurant_visits rv
                GROUP BY rv.restaurant_id
            ";*/
            
            /*$get_restaurant_visits_count_result = $this->mysqli_conn->query($get_restaurant_visits_count_query);

            $restaurant_visits = [];


            while($row = mysqli_fetch_assoc($get_restaurant_visits_count_result)){
                $restaurant_visits[$row["restaurant_id"]] = $row["visit_cnt"];
            }

            #print_r($restaurant_visits);

            $restaurants = $this->_conn
                ->select("id")
                ->select("title")
                ->select("restaurant_type_id")
                ->select("bid")
                ->select("status_flag")
                ->select("add_date")
                #->select_expr("(select count(rv.id) FROM restaurant_visits rv where rv.restaurant_id = restaurants.id)", "visit_cnt")
                ->get_result_set();
                
            foreach($restaurants["result"] as &$restaurant){
                $restaurant["visit_cnt"] = $restaurant_visits[$restaurant["id"]];
            }*/

            #$this->response = $restaurants;

            #print_r($restaurants);
            
        }

        public function get_restaurant_details($params){
            if(!isset($params["id"])){
                return 0;
            }
            $this->response = $this->_conn
                ->where("id", $params["id"])
                ->get_one_result();
            
        }

        public function add_restaurant($params){

            if(!isset($params["crud"])){
                return[
                    "success"=>false,
                    "msg"=>"No CRUD params are set"
                ];
            }

            $crud_params = $params["crud"];

            $crud_params["bid"] = (rand (0.01*10, 10.9*10) / 10);
            $crud_params["restaurant_type_id"] = (rand (1, 10));

            $res = $this->_conn
                ->insert($crud_params);
            
            if(!$res){
                return [
                    "succcess"=>false,
                    "msg"=>"Error while creating new restaurant entry",
                    "res"=>$res
                ];
            }

            $this->response = [
                "success"=>true,
                "msg"=>"Restaurant entry created",
                "res"=>$res
            ];
            
        }

    }
        

?>