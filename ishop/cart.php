<?php

$connection = new mysqli('localhost','u670633594_ushow','archmage2501','u670633594_show');// ('localhost','ishop','','ishop');
if($connection->connect_error) die("Не удалось подключиться к MySQL: ".$connection->connect_error);
$connection->set_charset('utf8');

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="main_style.css">
    <link rel="stylesheet" href="cart_style.css">
    <script src="jquery-1.7.2.min.js"></script>
    <script src="cart_script.js"></script>
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
                    <a href="index.php"><div>ГЛАВНАЯ</div></a>
                    <a href="other/delivery.html"><div>ДОСТАВКА</div></a>
                    <a href="other/paying.html"><div>ОПЛАТА</div></a>
                    <a href="other/guarante.html"><div>ГАРАНТИЯ</div></a>
                    <a href="other/contacts.html"><div>КОНТАКТЫ</div></a>
                    <a href="other/credit.html"><div>КРЕДИТ</div></a>
                </div>
                <div class="hdr_menu_order fRight"><img src="shop-cart.png"> Корзина</div>
                <div class="fClear"></div>
            </div>
        </div>
    </div>
    <div class="wrapper shadow">
        <div class="main">
            <div class="main_goods">
<?php
$listCart = $_GET['listCart'];
$listCart = $connection->real_escape_string($listCart);

$db_query = $connection->query("SELECT * FROM ishop_goods WHERE ishop_goods.id IN ($listCart);");
if((!$db_query) || ($db_query->num_rows < 1))
    echo "<h1>Ваша корзина пуста</h1>";
else {
    echo "<h1>Ваш заказ:</h1>";
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
        echo "Количество: <input type=\"text\" value=\"1\"></div>";
    }
}
?>
            </div>
            <div class="fClear"></div>
            <div>
                <a href="index.php"><input class="goods_elem_btn discard_btn" type="button" value="Отменить"></a>
                <input class="goods_elem_btn accept_btn" type="button" value="Подтвердить!">
            </div>
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
