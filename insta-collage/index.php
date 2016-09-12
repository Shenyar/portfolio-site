<?php
session_start();

$Page = Strategy::SelectPage();
$Page->ShowPage();

/*
 * All program settings in one place
 * */
class ProgrammSettings {
    public static $url_access_token = "https://api.instagram.com/oauth/access_token";
    public static $config_access_token = Array(
        "client_id" => "9a02a57fefb34f5185a0beda58141047",
        "client_secret" => "57b2548510b1409ab30efc63ca70fae2",
        "grant_type" => "authorization_code",
        "redirect_uri" => "http://kurmel.esy.es/insta-collage/",
        "code" => ""
    );

    public static $url_user_recent = "";
    public static $url_user_liked = "";
    public static function prepareApiUrls() {
        self::$url_user_recent = "https://api.instagram.com/v1/users/self/media/recent/?access_token=" .
            $_SESSION['InstaAccessToken'] . "&count=10";
        self::$url_user_liked = "https://api.instagram.com/v1/users/self/media/liked/?access_token=" .
            $_SESSION['InstaAccessToken'] . "&count=10";
    }
}

/*
 * Strategy for choose type of page shown to user
 * */
abstract class Strategy {
    public static function SelectPage() {
        if( isset($_GET['error']) ) {
            return new StrategyError();
        }
        else if( ! isset($_SESSION['InstaAccessToken']) ) {
            return new StrategyAuth();
        } else {
            if( isset($_POST['kol_img']) ) {
                return new StrategyCollage();
            }
            else {
                return new StrategySettings();
            }
        }
    }
    public abstract function ShowPage();

    protected function ShowHeader() {
        echo <<<_END
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <link rel="stylesheet" href="index.css">
                <title>Collage from Instagram</title>
            </head>
            <body>
                <div class="header">
                        <div class="hdr_logo">
                            <a href="index.php">Insta-Collage</a>
                        </div>
                </div>
_END;

    }
    protected function ShowFooter() {
        echo <<<_END
            <div class="footer">
                    <div class="hdr_logo">
                        <a href="index.php">Insta-Collage</a>
                    </div>
            </div>
        </body>
        </html>
_END;

    }
}

/*
 * Authenticate user in Instagram
 * */
class StrategyAuth extends Strategy {
    public function ShowPage() {
        /* goto Instagram authorization */
        if( isset($_GET['instagram']) ) {
            header("Location: https://api.instagram.com/oauth/authorize/?client_id=".
                ProgrammSettings::$config_access_token['client_id']."&redirect_uri=".
                ProgrammSettings::$config_access_token['redirect_uri']."&response_type=code&scope=basic+public_content");
            die();
        }
        /* receiving 'access_token' from Instagram */
        else if( isset($_GET['code']) ) {
            ProgrammSettings::$config_access_token['code'] = $_GET['code'];
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, ProgrammSettings::$url_access_token);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, ProgrammSettings::$config_access_token);
            $res = curl_exec($curl);
            curl_close($curl);
            if( $res === "" ) {
                header("Location: index.php?error=nocurl");
                die();
            }

            $token = json_decode($res);
            $_SESSION['InstaAccessToken'] = $token->access_token;
            header("Location: index.php");
            die();
        }
        /* Ask user to authorize application for his Instagram */
        else {
            $this->ShowHeader();
            echo <<<_END
            <div class="main">
                <div class="page-center main_auth">
                    <h1>Разрешите нашему приложению доступ в Instagram</h1>
                    <span>* Кнопка ниже переведет вас на страницу авторизации Instagram</span>
                    <div class="main_btn btn_auth_center">
                        <a class="btn_link" href="index.php?instagram=auth">Перейти к Instagram</a>
                    </div>
                </div>
            </div>
_END;
            $this->ShowFooter();
        }
    }
}

/*
 * Show Page with settings of collage
 * */
class StrategySettings extends Strategy {
    public function ShowPage() {
        $this->ShowHeader();

        echo <<<_END
            <div class="main">
                <div class="page-center main_settings">
                    <h1>Создайте коллаж из Instagram фотографий</h1>
                    <form method="post">
                        <div>
                            <label for="kol_img">Количество фотографий: </label>
                            <span class="kol_img_prim">* введите от 1 до 9</span>
_END;

        if(isset($_SESSION['kol_img'])) {
            echo '<input type="text" value="'.$_SESSION['kol_img'].'" name="kol_img" id="kol_img">';
        }
        else {
            echo '<input type="text" value="4" name="kol_img" id="kol_img">';
        }

        echo <<<_END
                        </div>
                        <div>
                            <label for="type_img">Какие фотографии выбрать: </label>
                            <select name="type_img" id="type_img">
                                <option value="0" selected>Свои публикации</option>
                                <option value="1">Понравившиеся публикации</option>
                            </select>
                        </div>
                        <input type="hidden" name="page_type" value="collage">
                        <input type="submit" value="Создать" id="form_submit" class="main_btn">
                    </form>
                </div>
            </div>
_END;

        $this->ShowFooter();
    }
}

/*
 * Create collage for user
 * */
class StrategyCollage extends Strategy {
    public function ShowPage() {
        //select API for Instagram
        ProgrammSettings::prepareApiUrls();
        if($_POST['type_img'] == 1) { //get media liked by user
            $url = ProgrammSettings::$url_user_liked;
        }
        else { //get media posted by user
            $url = ProgrammSettings::$url_user_recent;
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPGET, true);
        $res = curl_exec($curl);
        curl_close($curl);
        if( $res === "" ) {
            header("Location: index.php?error=nocurl");
            die();
        }

        //fill array of links to user`s images
        $temp_arr = json_decode($res);
        for($i = 0, $len = count($temp_arr->data); $i < $len; $i++) {
            $images[$i] = $temp_arr->data[$i]->images->low_resolution->url;
        }

        $this->ShowHeader();

        echo <<<_END
            <div class="main">
                <div class="container_collage">
                    <canvas width="622" height="622" id="canvas"></canvas>
_END;

        $kol_img = $_POST['kol_img'];
        /* number of images can be from 1 to 9 */
        if( (intval($kol_img) < 1) || (intval($kol_img) > 9)) {
            $kol_img = 1;
        }
        $_SESSION['kol_img'] = intval($kol_img);
        for($i = 0; $i < $kol_img; $i++) {
            echo "<img src=\"$images[$i]\" class=\"hide\" width='640px' height='640px'>";
        }

        echo <<<_END
                    <div class="main_block_btns">
                        <div class="main_btn">
                            <a class="btn_link" href="index.php">Назад</a>
                        </div>
                        <div class="main_btn" id="save_btn">Сохранить</div>
                    </div>
                </div>
            </div>
            
            <script src="jquery-1.7.2.min.js"></script>
            <script src="FileSaver.min.js"></script>
            <script src="index.js"></script>
        </body>
        </html>
_END;

    }
}

/*
 * Error handler for application
 * */
class StrategyError extends Strategy {
    public function ShowPage() {
        /* Instagram rights was not granted by user */
        if( $_GET['error'] == "access_denied" ) {
            $this->ShowHeader();
            echo <<<_END
            <div class="main">
                <div class="page-center">
                    <h1>Вы не разрешили доступ в Instagram</h1>
                </div>
            </div>
_END;
            $this->ShowFooter();
        }
        /* Cannot connect to Instagram */
        else {
            $this->ShowHeader();
            echo <<<_END
            <div class="main">
                <div class="page-center">
                    <h1>Ошибка подключения к Instagram</h1>
                    <div class="main_btn btn_auth_center">
                        <a class="btn_link" href="index.php">Попробовать еще раз</a>
                    </div>
                </div>
            </div>
_END;
            $this->ShowFooter();
        }
    }
}