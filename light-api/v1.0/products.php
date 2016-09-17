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
 * $product - is array of objects (list of selected products)
 * */
class Response {
    public $product;
}

/**
 * this API show list of searched products
 * input:
 * {
 *  "category": "all",
 *  "search": "ASUS"
 * }
 *
 * example of response:
 * {
 *  "product":[
 *      {   "id": "2",
 *          "img": "img\/main-item2.jpg",
 *          "title": "Dapibus Elit Amet Parturient Porta",
 *          "text": "Aenean lacinia bibendum nulla sed consectetur. Donec sed odio dui.",
 *          "avg_rate": "5"
 *      },
 *      {   "id": "6",
 *          "img": "img\/main-item1.jpg",
 *          "title": "Dapibus Elit Amet Parturient Porta",
 *          "text": "Aenean lacinia bibendum nulla sed consectetur. Donec sed odio dui.",
 *          "avg_rate": "3.5"
 *      }
 *  ]
 * }
 * */
class Products extends ConnectDataBase{

    /**
     * get list of products with average rates and send it to user
     * */
    public function Run() {
        $category = addslashes($_GET['category']);
        $search = addslashes($_GET['search']);

        if( ($category == "") || ($category == "all") ) {
            $where = " WHERE (true) ";
        } else {
            $where = " WHERE (LIGHT_CATEGORY.name = '$category') ";
        }
        if( $search != "" ) {
            $where .= " AND (LIGHT_PRODUCT.title Like '%$search%') ";
        }

        $this->createConnection();

        /*оставил сравнение по имени категории просто для красивого SQL с
        вложенными Join`ами (сравнение по id категории ускорит выборку).*/
        $query_str = "
            SELECT
              LIGHT_PRODUCT.id,
              LIGHT_PRODUCT.title,
              LIGHT_PRODUCT.image,
              LIGHT_PRODUCT.text,
              AVG( LIGHT_REVIEW.rate ) AS avg_rate
            FROM
             (
               LIGHT_PRODUCT
               INNER JOIN LIGHT_CATEGORY
               ON LIGHT_PRODUCT.category_id = LIGHT_CATEGORY.id
             )
             LEFT JOIN LIGHT_REVIEW
             ON LIGHT_PRODUCT.id = LIGHT_REVIEW.product_id
            $where
            GROUP BY
              LIGHT_PRODUCT.id,
              LIGHT_PRODUCT.title,
              LIGHT_PRODUCT.image,
              LIGHT_PRODUCT.text;
               ";
        $db_result = $this->connection->query($query_str);

        $this->closeConnection();

        $response = new Response();
        if( $db_result->num_rows > 0 ) {
            for( $i = 0; $i < $db_result->num_rows; $i++ ) {
                $response->product[$i] = $db_result->fetch_object();
            }
        }
        echo json_encode($response);
    }
}


/*-------------- RUN PROGRAM ----------*/
header('Access-Control-Allow-Origin: *');
$Program = new Products();
$Program->Run();