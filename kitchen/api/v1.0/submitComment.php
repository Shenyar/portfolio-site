<?php
/**
 * Created by PhpStorm.
 * User: io05
 * Date: 22.08.2016
 * Time: 11:19
 */

/*
 *
 * */
include 'ConnectDataBase.php';
class SubmitComment extends ConnectDataBase{
    private $commentName;
    private $commentEmail;
    private $commentContent;
    private $commentCaptcha;
    private $captchaId;
    private $postId;
    private $AnsversCaptcha = Array(
        'Barrel',
        'Kitchen',
        'Grapes'
    );

    public function getParams() {
        //for legacy servers which cannot get params if header: 'Content-Type: application/json'
        $_POST = json_decode(file_get_contents('php://input'), true);

        $this->postId = ($_POST['postId']);
        if( $this->postId < 1 ) {
            throw new Exception("Internal error. Incorrect postId.");
        }
        $this->commentName = addslashes($_POST['commentName']);
        if( $this->commentName == "" ) {
            throw new Exception("You did not type Name");
        }
        $this->commentEmail = addslashes($_POST['commentEmail']);
        if( ! preg_match('/^[\w-]+@[\w-]+\.[\w-]+$/i', $this->commentEmail) ) {
            throw new Exception('Incorrect Email');
        }
        $this->commentContent = addslashes($_POST['commentContent']);
        if( $this->commentContent == "" ) {
            throw new Exception("You did not type Comment");
        }
        $this->captchaId = intval($_POST['captchaId']);
        $this->commentCaptcha = addslashes($_POST['commentCaptcha']);
        if( ! preg_match("/".$this->AnsversCaptcha[$this->captchaId-1]."/i", $this->commentCaptcha) ) {
            throw new Exception("You type incorrect Captcha");
        }
    }

    public function saveComment() {
        $this->createConnection();

        $query_str = "
            INSERT INTO Kitchen_Comment (content, post_id, name, email)
            VALUES ('$this->commentContent', $this->postId, '$this->commentName', '$this->commentEmail');
               ";
        $this->connection->query($query_str);
        echo "Comment was successfully added!";

        $this->closeConnection();
    }
}



$Program = new SubmitComment();
try {
    $Program->getParams();
    $Program->saveComment();
}
catch (Exception $err) {
    echo $err->getMessage();
}