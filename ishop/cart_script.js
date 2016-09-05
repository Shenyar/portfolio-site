/**
 * Created by io05 on 02.06.2016.
 */
window.onload = function() {
    $('.accept_btn')[0].onclick = acceptCart;
    $('.discard_btn')[0].onclick = discardCart;
};

function acceptCart() {
    alert("К сожалению это тестовый магазин\nи заказать ничего нельзя((")
}

function discardCart() {
    localStorage.removeItem('cartList');
    alert("Заказ отменен");
}