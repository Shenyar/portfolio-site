<?php
$route = addslashes($_GET['route']);
if($route == '') {
    $route = 'portfolio';
}

$lang = addslashes($_GET['lang']);
if( $lang != "" ) {
    setcookie('lang',$lang,mktime(0,0,0,1,1,2100));
}
else {
    $lang = $_COOKIE['lang'];
    if ($lang == "") {
        $lang = "EN";
    }
}

class obj{};
$page_lang = new obj();
if($lang == "RU") {
    $page_lang->menu = 'МЕНЮ';
    $page_lang->resume = 'РЕЗЮМЕ';
    $page_lang->portfolio = 'ПОРТФОЛИО';
    $page_lang->contacts = 'КОНТАКТЫ';
    $page_lang->copyright = 'Все права защищены &copy; 2016 Курмель Андрей';
} else {
    $page_lang->menu = 'MENU';
    $page_lang->resume = 'RESUME';
    $page_lang->portfolio = 'PORTFOLIO';
    $page_lang->contacts = 'CONTACTS';
    $page_lang->copyright = 'Copyright &copy; 2016 Kurmel Andrey';
}
?>
<!DOCTYPE html>
<html lang="RU">
<head>
    <meta charset="UTF-8">
    <title>Portfolio</title>
    <link href="lib/bootstrap.min.css" rel="stylesheet">
    <link href="lib/font-awesome.min.css" rel="stylesheet">
    <link href="lib/jquery-ui.min.css" rel="stylesheet">
    <link href="index_style.css" rel="stylesheet">

    <script src="lib/jquery-2.2.1.min.js"></script>
    <script src="lib/jquery-ui.min.js"></script>
    <script src="lib/bootstrap.min.js"></script>
    <script src="index_script.js"></script>
</head>
<body>
    <div class="wrapper container">

        <div class="header">
            <div class="row">
                <div class="pull-left">
                    <a href="/" class="link">
                        <div class="vert-align hdr-height">
                            <div class="logo">KURMEL</div>
                            <div class="logo-min">A N D R E Y</div>
                        </div>
                    </a>
                </div>
                <div class="pull-right visible-xs js-dropdown-label">
                    <div class="vert-align hdr-height hdr-menu-item link">
                        <i class="fa fa-bars"></i>
                        <div>
                            <?php
                            echo $page_lang->menu;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="pull-right hidden-xs js-dropdown-menu">
                    <?php
                    if($route == 'resume') {
                        echo '<a class="hdr-activated">';
                    }
                    else {
                        echo '<a href="/?route=resume" class="link">';
                    }
                    ?>
                        <div class="vert-align hdr-height hdr-menu-item">
                            <i class="fa fa-twitter"></i>
                            <div>
                                <?php
                                echo $page_lang->resume;
                                ?>
                            </div>
                        </div>
                    </a>
                    <?php
                    if($route == 'portfolio') {
                        echo '<a class="hdr-activated">';
                    }
                    else {
                        echo '<a href="/?route=portfolio" class="link">';
                    }
                    ?>
                    <div class="vert-align hdr-height hdr-menu-item">
                            <i class="fa fa-camera"></i>
                            <div>
                                <?php
                                echo $page_lang->portfolio;
                                ?>
                            </div>
                        </div>
                    </a>
                    <?php
                    if($route == 'contacts') {
                        echo '<a class="hdr-activated">';
                    }
                    else {
                        echo '<a href="/?route=contacts" class="link">';
                    }
                    ?>
                    <div class="vert-align hdr-height hdr-menu-item">
                            <i class="fa fa-envelope"></i>
                            <div>
                                <?php
                                echo $page_lang->contacts;
                                ?>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <?php
            if($route == "resume") {
                include 'resume.php';
            }
            elseif($route == 'contacts') {
                include 'contacts.php';
            }
            else {
                include 'portfolio.php';
            }
        ?>

        <div class="footer">
            <div class="row">
                <div class="pull-left">
                    <?php
                    if($lang == 'RU') {
                        echo "<a href=\"?route=$route&lang=EN\" class=\"link\">";
                        echo '    <div class="vert-align hex hex-hover">EN</div>';
                        echo '</a>';
                    } else {
                        echo '<div class="vert-align hex hex-bg">EN</div>';
                    }
                    ?>
                </div>
                <div class="pull-left">
                    <?php
                    if($lang != 'RU') {
                        echo "<a href=\"?route=$route&lang=RU\" class=\"link\">";
                        echo '    <div class="vert-align hex hex-hover">RU</div>';
                        echo '</a>';
                    } else {
                        echo '<div class="vert-align hex hex-bg">RU</div>';
                    }
                    ?>
                </div>
                <div class="pull-right">
                    <a href="http://facebook.com" class="link">
                        <div class="vert-align hex hex-bg hex-hover">
                            <i class="fa fa-facebook"></i>
                        </div>
                    </a>
                    <a href="http://linkedin.com" class="link">
                        <div class="vert-align hex hex-bg hex-hover">
                            <i class="fa fa-linkedin"></i>
                        </div>
                    </a>
                    <a href="http://github.com" class="link">
                        <div class="vert-align hex hex-bg hex-hover">
                            <i class="fa fa-github"></i>
                        </div>
                    </a>
                </div>
                <div class="footer-center">
                    <?php
                    echo $page_lang->copyright;
                    ?>
                </div>
            </div>
        </div>

    </div>
</body>
</html>