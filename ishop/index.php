<?php

$connection = new mysqli('localhost','u670633594_ushow','archmage2501','u670633594_show');// ('localhost','ishop','','ishop');
if($connection->connect_error) die("Не удалось подключиться к MySQL: ".$connection->connect_error);
$connection->set_charset('utf8');

$sel_category = intval( $_GET['category'] );
if( !$sel_category )
    $sel_category = 1;

$search = $_GET['search'];
$search = $connection->real_escape_string($search);

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="main_style.css">
    <script src="jquery-1.7.2.min.js"></script>
    <script src="main_script.js"></script>
    <title>Магазин техники iShop</title>
</head>
<body>
    <div class="header">
        <div class="wrapper">
            <div>
                <div class="hdr_logo fLeft">
                    <div>iSHOP.ua</div>
                    <div>ИНТЕРНЕТ МАГАЗИН</div>
                </div>
                <div class="hdr_telephone fRight">
                    <div>Контактный телефон:</div>
                    <div>(000) 123-456-78</div>
                </div>
                <div class="fClear"></div>
            </div>
            <div class="hdr_menu">
                <div class="hdr_menu_btns fLeft">
                    <div class="hdr_menu_selected">ГЛАВНАЯ</div>
                    <a href="other/delivery.html"><div>ДОСТАВКА</div></a>
                    <a href="other/paying.html"><div>ОПЛАТА</div></a>
                    <a href="other/guarante.html"><div>ГАРАНТИЯ</div></a>
                    <a href="other/contacts.html"><div>КОНТАКТЫ</div></a>
                    <a href="other/credit.html"><div>КРЕДИТ</div></a>
                </div>
                <a href="cart.php">
                    <div class="hdr_menu_order fRight"><img src="shop-cart.png"> Корзина</div>
                </a>
                <div class="fClear"></div>
            </div>
        </div>
    </div>
    <div class="wrapper shadow">
        <div class="main">
            <div class="main_aside fRight">
                <div class="aside_menu">
                    <div>КАТЕГОРИИ ТОВАРОВ</div>
                    <ul>
<?php
$db_query = $connection->query("SELECT * FROM ishop_categories;");
if((!$db_query) || ($db_query->num_rows < 1))
    echo "<div>Извините, не найдены<br>категории товаров,<br>сайт будет работать<br>некорректно(</div>";
else {
    for ($i = 0; $i < $db_query->num_rows; $i++) {
        $db_query->data_seek($i);
        $row = $db_query->fetch_assoc();
        $id = $row['id'];
        $category = $row['category'];
        if( $i == ($sel_category-1) )
            echo "<li id=\"aside_menu_selected\"><span>></span> $category</li>";
        else
            echo "<li><span>></span> <a href='index.php?category=$id'>$category</a></li>";
    }
}
?>
                    </ul>
                </div>
            </div>
            <div class="main_goods">
                <form action="index.php">
                    <input type="hidden" name="category" value="2147483647">
                    <input class="search_input" type="text" name="search" placeholder="Введите название товара...">
                    <input class="search_btn" type="submit" value="Найти">
                </form>
<?php
if($search) {
    $db_query = $connection->query("SELECT * FROM ishop_goods WHERE ishop_goods.caption LIKE '%$search%';");
} else {
    $db_query = $connection->query("SELECT * FROM ishop_goods WHERE ishop_goods.category = $sel_category;");
}
if((!$db_query) || ($db_query->num_rows < 1))
    echo "<div>Извините, товаров не найдено(</div>";
else {
    for ($i = 0; $i < $db_query->num_rows; $i++) {
        $db_query->data_seek($i);
        $row = $db_query->fetch_assoc();
        echo "<div class=\"goods_elem\">";
        $field = $row['image'];
        echo "<img src=\"$field\" width=\"190\" height=\"100\">";
        $field = $row['caption'];
        echo "<div class=\"goods_elem_name\">$field</div>";
        $field = $row['description'];
        echo "<div class=\"goods_elem_description\">$field</div>";
        $field = $row['price'];
        echo "<div class=\"goods_elem_price\">$ $field</div>";
        $field = $row['id'];
        echo "<input class=\"goods_elem_btn\" type=\"button\" value=\"В корзину!\" goods_id=\"$field\"></div>";
    }
}
?>
            </div>
            <div class="fClear"></div>
        </div>
        <div class="footer">
            <div>
                © Интернет-магазин <<<a href="http://iShop.com"><span>iShop</span></a>>> 2012<br>
                О магазине<br>
                Контакты<br>
                Сотрудничество с нами<br>
                Условия использования сайта
            </div>
            <div>
                <span>Подарочные сертификаты</span><br>
                Помощь<br>
                Сервисные центры<br>
                Проблемы с заказом<br>
                Обратная связь
            </div>
            <div>
                <span>Следите за нами:</span><br>
                <div class="footer_btns">B</div>
                <div class="footer_btns">F</div>
                <div class="footer_btns">T</div>
                <br>RSS: Новости<br>
                RSS: Акции и скидки<br>
            </div>
        </div>
    </div>
</body>
</html>
