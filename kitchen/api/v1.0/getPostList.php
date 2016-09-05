<?php
/**
 * Created by PhpStorm.
 * User: io05
 * Date: 15.08.2016
 * Time: 13:01
 */
include 'ConnectDataBase.php';

/*
 * Response has 3 field in his body:
 * $category - is array of objects (list of categories in database)
 * $num_posts - is integer
 * $post - is array of objects (list of selected posts)
 * */
class Response {
    public $category;
    public $num_posts;
    public $post;
}

/*
 * this API response list of posts with selected params.
 * example of response:
 * {
 *  "category":[
 *      {"id":"1","name":"All"},
 *      {"id":"2","name":"Photography"},
 *      {"id":"3","name":"Food"},
 *      {"id":"4","name":"Wine"},
 *      {"id":"5","name":"Salads"}
 *  ],
 *  "num_posts":"2",
 *  "post":[
 *      {   "id":"2",
 *          "img":"img\/main-item2.jpg",
 *          "header":"Dapibus Elit Amet Parturient Porta",
 *          "content":"Aenean lacinia bibendum nulla sed consectetur. Donec sed odio dui.",
 *          "create_date":"2016-08-15 13:28:29",
 *          "likes":"14",
 *          "category":"Food",
 *          "comments":"1"
 *      },
 *      {   "id":"6",
 *          "img":"img\/main-item1.jpg",
 *          "header":"Dapibus Elit Amet Parturient Porta",
 *          "content":"Aenean lacinia bibendum nulla sed consectetur. Donec sed odio dui.",
 *          "create_date":"2016-08-15 13:35:52",
 *          "likes":"14",
 *          "category":"Food",
 *          "comments":"0"
 *      }
 *  ]
 * }
 * */
class APIgetPostList extends ConnectDataBase {
    private $category;
    private $page;

    public function __construct() {
        $this->category = addslashes($_GET['category']);
        if( $this->category == "" ) {
            $this->category = "All";
        }
        $this->page = intval($_GET['page']);
        if( $this->page == 0 ) {
            $this->page = 1;
        }
    }

    public function echoResponse() {
        $this->createConnection();
        $result = new Response();
        $result->category = $this->getCategory();
        $result->num_posts = $this->getNumPages();
        $result->post = $this->getPostList();
        $this->closeConnection();
        echo json_encode($result);
    }

    /*
     * getCategory return list of categories
     * return - array(stdClass Object);
     * */
    private function getCategory() {
        $query_str = "
            SELECT * FROM Kitchen_Category;
        ";

        $db_query = $this->connection->query($query_str);
        $result = Array();
        if((!$db_query) || ($db_query->num_rows < 1))
            return $result;
        else {
            for($i = 0, $len = $db_query->num_rows-1; $i <= $len; $i++) {
                $result[$i] = $db_query->fetch_object();
            }
            return $result;
        }
    }

    /*
     * getNumPages return number of selected posts
     * return - integer
     * */
    private function getNumPages() {
        if($this->category != "All") {
            $where = " WHERE Kitchen_Category.name = '" . $this->category . "' ";
        } else {
            $where = " ";
        }

        $query_str = "
            SELECT Count(Kitchen_Post.id) AS NumPosts
            FROM Kitchen_Post INNER JOIN Kitchen_Category ON Kitchen_Post.category_id = Kitchen_Category.id
            $where;
        ";

        $db_query = $this->connection->query($query_str);
        if((!$db_query) || ($db_query->num_rows < 1))
            return Null;
        else {
            $tmp = $db_query->fetch_assoc();
            return $tmp['NumPosts'];
        }
    }

    /*
     * getPostList return list of selected posts
     * return - array(stdClass Object)
     * */
    private function getPostList() {
        if($this->category != "All") {
            $where = " WHERE Kitchen_Category.name = '" . $this->category . "' ";
        } else {
            $where = " ";
        }
        $offset = ($this->page-1)*4;

        $query_str = "
            SELECT Kitchen_Post.id,
              Kitchen_Post.img,
              Kitchen_Post.header,
              Kitchen_Post.content,
              Kitchen_Post.create_date,
              Kitchen_Post.likes,
              Kitchen_Category.name AS category,
              COUNT( Kitchen_Comment.id ) AS comments
            FROM (
                Kitchen_Post
                INNER JOIN Kitchen_Category ON Kitchen_Post.category_id = Kitchen_Category.id
              )
              LEFT JOIN Kitchen_Comment ON Kitchen_Comment.post_id = Kitchen_Post.id
            $where
            GROUP BY id, img, header, content, create_date, likes, category
            LIMIT $offset, 4;
               ";

        $db_query = $this->connection->query($query_str);
        $result = Array();
        if((!$db_query) || ($db_query->num_rows < 1))
            return $result;
        else {
            for($i = 0, $len = $db_query->num_rows-1; $i <= $len; $i++) {
                $result[$i] = $db_query->fetch_object();
            }
            return $result;
        }
    }
}


/*странно что из-за include не видит объявления класса если код вначале*/
$Program = new APIgetPostList();
$Program->echoResponse();