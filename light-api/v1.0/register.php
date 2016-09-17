<?php
/**
 * Created by PhpStorm.
 * User: io05
 * Date: 13.09.2016
 * Time: 11:19
 */

include 'ConnectDataBase.php';

/**
 * Response has 2 field in his body:
 * $success - is 'true' when user was registered
 * $token - access token for identify user in future
 * */
class Response {
    public $success;
    public $token;
}

/**
 * this API register user in the system and response about success or failure
 * input:
 * {
 *  "username": "user",
 *  "password": "123"
 * }
 *
 * example of response:
 * {
 *  "success": true,
 *  "token": "6099a566a619528259db5aa8d7a5aa2d4122259a"
 * }
 * */
class Register extends ConnectDataBase{

    /*main function for start api*/
    public function Run() {
        //because angularJS send parameters as 'Content-Type: application/json'
        $_POST = json_decode(file_get_contents('php://input'), true);

        $username = addslashes($_POST['username']);
        if( $username == "" ) {
            $this->echoResponse(false, 'Вы не ввели имя пользователя!');
            die();
        }
        $password = addslashes($_POST['password']);
        if( $password == "" ) {
            $this->echoResponse(false, 'Вы не ввели пароль!');
            die();
        }

        $password = sha1($password);
        $token = sha1($username . $password);

        if( ! $this->findUser($username, $password) ) {
            $this->saveUser($username, $password, $token);
        }
        $this->echoResponse(true, $token);
    }

    /** find user in the DataBase
     * return: user_id / 0;
     * */
    protected function findUser($login, $pass) {
        $this->createConnection();

        $query_str = "
            SELECT * FROM LIGHT_USER
            WHERE (LIGHT_USER.login = '$login') AND (LIGHT_USER.pass = '$pass');
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

    /*response result of register to user*/
    protected function echoResponse($success, $token) {
        $result = new Response();
        $result->success = $success;
        $result->token = $token;
        echo json_encode($result);
    }

    /*save user into DataBase*/
    protected function saveUser($username, $password, $token) {
        $this->createConnection();

        $query_str = "
            INSERT INTO LIGHT_USER (login, pass, token)
            VALUES ('$username', '$password', '$token');
               ";
        $this->connection->query($query_str);

        $this->closeConnection();
    }
}


/*-------------- RUN PROGRAM ----------*/
header('Access-Control-Allow-Origin: *');
$Program = new Register();
$Program->Run();