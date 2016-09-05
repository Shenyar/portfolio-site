/**
 * Created by io05 on 30.05.2016.
 */
window.onload = function() {
    $('.goods_elem_btn').each(function() {
        this.onclick = addToCart;
    });

    $('.hdr_menu_order')[0].onclick = openCart;
};

function addToCart() {
    if(typeof localStorage == "undefined") {
        alert("К сожалению вы пользуетесь\nстарым браузером и мы не можем\nсохранять ваш список покупок(");
        return;
    }
    var list = localStorage.getItem('cartList');
    if(!list)
        list = this.attributes.goods_id.value;
    else
        list += "," + this.attributes.goods_id.value;
    localStorage.setItem('cartList',list);
    alert("Товар успешно добавлен в корзину!");
}

function openCart() {
    //open cart through GET-method (send list of goods)
    var list = localStorage.getItem('cartList');
    this.parentNode.href += "?listCart="+list;
}