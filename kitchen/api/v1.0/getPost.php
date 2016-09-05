<?php
/**
 * Created by PhpStorm.
 * User: io05
 * Date: 15.08.2016
 * Time: 13:01
 */
include 'ConnectDataBase.php';

/**
 * Response has 3 field in his body:
 * $category - is array of objects (list of categories in database)
 * $num_posts - is integer
 * $post - is array of objects (list of selected posts)
 * */
class Response {
    public $selectedPost;
    public $categories;
    public $popularPosts;
}

/**
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
class APIgetPost extends ConnectDataBase {
    private $postId;

    public function __construct() {
        $this->postId = intval($_GET['id']);
        /*if( $this->postId == 0 ) {
            $this->postId = 1;
        }*/
    }

    public function echoResponse() {
        $this->createConnection();
        $result = new Response();
        $result->selectedPost = $this->getPost();
        $result->categories = $this->getCategories();
        $result->popularPosts = $this->getPopularPosts();
        $this->closeConnection();
        echo json_encode($result);
    }

    /**
     * getPost return selected post with related comments
     * return - stdClass Object
     * */
    private function getPost() {
        $query_str = "
            SELECT Kitchen_Post.id,
              Kitchen_Post.img,
              Kitchen_Post.header,
              Kitchen_Post.content,
              Kitchen_Post.post_content,
              Kitchen_Post.create_date,
              Kitchen_Post.likes,
              Kitchen_Category.name AS category
            FROM
                Kitchen_Post
                INNER JOIN
                Kitchen_Category
                ON Kitchen_Post.category_id = Kitchen_Category.id
            WHERE Kitchen_Post.id = $this->postId;
               ";

        $db_query = $this->connection->query($query_str);
        $post = $db_query->fetch_object();
        if( !$post ) {
            return Null;
        } else {
            $query_str = "
            SELECT Kitchen_Comment.content,
              Kitchen_Comment.name,
              Kitchen_Comment.email
            FROM Kitchen_Comment
            WHERE Kitchen_Comment.post_id = $this->postId;
               ";

            $db_query = $this->connection->query($query_str);
            $post->comments = Array();
            if( $db_query->num_rows > 0 ) {
                for($i = 0, $len = $db_query->num_rows-1; $i <= $len; $i++) {
                    $post->comments[$i] = $db_query->fetch_object();
                }
            }
            return $post;
        }
    }

    /**
     * getCategories return categories and each has count of posts
     * return - array(stdClass Object)
     * */
    private function getCategories() {
        $query_str = "
            SELECT Kitchen_Category.name,
              COUNT(Kitchen_Post.id) AS num_posts
            FROM Kitchen_Category
              LEFT JOIN Kitchen_Post
              ON Kitchen_Category.id = Kitchen_Post.category_id
            GROUP BY Kitchen_Category.name;
               ";

        $db_query = $this->connection->query($query_str);
        $res = Array();
        if( $db_query->num_rows > 1 ) {
            $db_query->fetch_object();//drop category 'All'
            for($i = 0, $len = $db_query->num_rows-2; $i <= $len; $i++) {
                $res[$i] = $db_query->fetch_object();
            }
        }
        return $res;
    }

    /**
     * getPopularPosts return 3 posts which have max of 'likes'
     * return - array(stdClass Object)
     * */
    private function getPopularPosts() {
        $query_str = "
            SELECT Kitchen_Post.id,
              Kitchen_Post.img,
              Kitchen_Post.header,
              Kitchen_Post.create_date
            FROM Kitchen_Post
            ORDER BY Kitchen_Post.likes DESC
            LIMIT 3;
               ";

        $db_query = $this->connection->query($query_str);
        $res = Array();
        if( $db_query->num_rows > 0 ) {
            for($i = 0, $len = $db_query->num_rows-1; $i <= $len; $i++) {
                $res[$i] = $db_query->fetch_object();
            }
        }
        return $res;
    }
}





$Program = new APIgetPost();
$Program->echoResponse();