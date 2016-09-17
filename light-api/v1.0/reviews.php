<?php
/**
 * Created by PhpStorm.
 * User: io05
 * Date: 13.09.2016
 * Time: 11:19
 */

include 'ConnectDataBase.php';

/**
 * Response for method GET has 2 fields in his body:
 * $product - is object with info about selected product
 * $review - is array of objects (list of reviews)
 * */
class Response_Get {
    public $product;
    public $review;
}

/**
 * Response for method POST has 2 fields in his body:
 * $success - result of adding review (true/false)
 * $message - additional message
 * */
class Response_Post {
    public $success;
    public $message;
}

/**
 * this API show information about selected product with reviews for method GET
 * and post into DataBase review about selected product for method POST
 *-----------------------
 * input GET:
 * {
 *  "product_id": "1"
 * }
 *
 * input POST:
 * {
 *  "rate": "4",
 *  "text": "some comment",
 *  "product_id": "2",
 *  "token": "6099a566a619528259db5aa8d7a5aa2d4122259a"
 * }
 *--------------------------
 * example of response GET:
 * {
 *  "product": {
 *      "id": "2",
 *      "image": "img\/main-item2.jpg",
 *      "title": "Dapibus Elit Amet Parturient Porta",
 *      "text": "Aenean lacinia bibendum nulla sed consectetur. Donec sed odio dui.",
 *      "avg_rate": "3.5"
 *  }
 *  "review":[
 *      {   "rate": "2",
 *          "text": "some comment",
 *          "date_add": "2016-09-15 11:32:18",
 *          "user": "user12"
 *      },
 *      {   "rate": "5",
 *          "text": "other text about product",
 *          "date_add": "2016-09-14 15:44:23",
 *          "user": "abcd"
 *      }
 *  ]
 * }
 *
 * example of response POST:
 * {
 *  "success": "true",
 *  "message": "comment was successfully added"
 * }
 * */
class Reviews extends ConnectDataBase{

    /**
     * get list of categories from DataBase and send it to user
     * */
    public function Run() {
        if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $this->postReview();
        } else {
            $this->getReview();
        }
    }

    /** find user in the DataBase
     * return: user_id / 0;
     * */
    protected function findUser($token) {
        $this->createConnection();

        $query_str = "
            SELECT * FROM LIGHT_USER
            WHERE LIGHT_USER.token = '$token';
               ";
        $res = $this->connection->query($query_str);

        $this->closeConnection();

        $user_id = $res->fetch_object()->id;
        if( $user_id ) {
            return $user_id;
        } else {
            return 0;
        }
    }

    /**
     * response result of post review to user
     * */
    protected function echoResponsePost($success, $message) {
        $result = new Response_Post();
        $result->success = $success;
        $result->message = $message;
        echo json_encode($result);
    }

    /**
     * post review about selected product into DataBase
     * */
    protected function postReview() {
        //because angularJS send parameters as 'Content-Type: application/json'
        $_POST = json_decode(file_get_contents('php://input'), true);

        /*initial values*/
        $product_id = intval($_POST['product_id']);
        if($product_id < 1) {
            $this->echoResponsePost(false, "Ошибка при поиске товара");
            die();
        }
        $rate = intval($_POST['rate']);
        if( ($rate < 1) || ($rate > 5) ) {
            $this->echoResponsePost(false, "Неправильная оценка");
            die();
        }
        $text = addslashes($_POST['text']);
        if( $text == "" ) {
            $this->echoResponsePost(false, "Вы не ввели комментарий!");
            die();
        }
        $user_id = $this->findUser( addslashes($_POST['token']) );
        if( $user_id < 1 ) {
            $this->echoResponsePost(false, "К сожалению система Вас не опознала(");
            die();
        }

        $this->createConnection();

        $query_str = "
            INSERT INTO LIGHT_REVIEW (rate, text, product_id, user_id)
            VALUES ($rate, '$text', $product_id, $user_id);
               ";
        $this->connection->query($query_str);

        $this->closeConnection();
        $this->echoResponsePost(true,"Комментарий успешно добавлен.");
    }

    /**
     * get info about product and list of reviews from DataBase and send it to user
     * */
    protected function getReview() {
        $product_id = intval($_GET['product_id']);
        if($product_id < 1) {
            echo "Неправильный ИД продукта";
            die();
        }

        $this->createConnection();

        $query_str = "
            SELECT
              LIGHT_PRODUCT.id,
              LIGHT_PRODUCT.title,
              LIGHT_PRODUCT.image,
              LIGHT_PRODUCT.text,
              AVG( LIGHT_REVIEW.rate ) AS avg_rate
            FROM
             LIGHT_PRODUCT
             LEFT JOIN LIGHT_REVIEW
             ON LIGHT_PRODUCT.id = LIGHT_REVIEW.product_id
            WHERE LIGHT_PRODUCT.id = $product_id
            GROUP BY
              LIGHT_PRODUCT.id,
              LIGHT_PRODUCT.title,
              LIGHT_PRODUCT.image,
              LIGHT_PRODUCT.text;
               ";
        $db_result = $this->connection->query($query_str);

        /*put info about product into response object*/
        $response = new Response_Get();
        $response->product = $db_result->fetch_object();

        $query_str = "
            SELECT
              LIGHT_REVIEW.rate,
              LIGHT_REVIEW.text,
              LIGHT_REVIEW.date_add,
              LIGHT_USER.login AS user
            FROM
             LIGHT_REVIEW
             INNER JOIN LIGHT_USER
             ON LIGHT_REVIEW.user_id = LIGHT_USER.id
            WHERE LIGHT_REVIEW.product_id = $product_id
            ORDER BY LIGHT_REVIEW.date_add DESC;
               ";
        $db_result = $this->connection->query($query_str);

        /*put array of reviews about product into response object*/
        if( $db_result->num_rows > 0 ) {
            for( $i = 0; $i < $db_result->num_rows; $i++ ) {
                $response->review[$i] = $db_result->fetch_object();
            }
        }

        $this->closeConnection();

        echo json_encode($response);
    }
}


/*-------------- RUN PROGRAM ----------*/
header('Access-Control-Allow-Origin: *');
$Program = new Reviews();
$Program->Run();