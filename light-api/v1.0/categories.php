<?php
/**
 * Created by PhpStorm.
 * User: io05
 * Date: 13.09.2016
 * Time: 11:19
 */

include 'ConnectDataBase.php';

/**
 * Response has 1 field in his body:
 * $category - is array of objects (list of categories)
 * */
class Response {
    public $category;
}

/**
 * this API show list of categories
 * input: none
 *
 * example of response:
 * {
 *  "category":[
 *      {   "id": "2",
 *          "name": "ноутбуки"
 *      },
 *      {   "id": "3",
 *          "name": "фотоаппараты"
 *      }
 *  ]
 * }
 * */
class Categories extends ConnectDataBase{

    /**
     * get list of categories from DataBase and send it to user
     * */
    public function Run() {
        $this->createConnection();

        $query_str = "
            SELECT *
            FROM LIGHT_CATEGORY;
               ";
        $db_result = $this->connection->query($query_str);

        $this->closeConnection();

        $response = new Response();
        if( $db_result->num_rows > 0 ) {
            for( $i = 0; $i < $db_result->num_rows; $i++ ) {
                $response->category[$i] = $db_result->fetch_object();
            }
        }
        echo json_encode($response);
    }
}


/*-------------- RUN PROGRAM ----------*/
header('Access-Control-Allow-Origin: *');
$Program = new Categories();
$Program->Run();