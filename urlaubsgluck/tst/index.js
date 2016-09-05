/**
 * Created by io05 on 02.07.2016.
 */
window.onload = function() {
    $('.main1-step-arrR, .main1-step-arrL').on('click', callArrRightLeft);

    //автоматическое перелистывание
    window.setInterval( function(){arrRightLeft('main1-step1',1)}, 5000 );
    window.setInterval( function(){arrRightLeft('main1-step2',1)}, 5500 );
    window.setInterval( function(){arrRightLeft('main1-step3',1)}, 6000 );
};

function callArrRightLeft() {
    if( $(this).hasClass('main1-step-arrR') ) {
        arrRightLeft(this.getAttribute('my_parentSlide'),1);//RIGHT
    }
    else {
        arrRightLeft(this.getAttribute('my_parentSlide'),0);//LEFT
    }
}

/*листать карусель. "parentSlide" - класс слайда; "direction" - направление */
function arrRightLeft(parentSlide, direction) {
    var texts = $('.'+parentSlide+' > .main1-step-align');

    if(direction == 1) { //листать вправо
        var end_chain = texts.length - 1;
        var beg_chain = 0;
        var direc = 1;
    }
    else { //листать влево
        end_chain = 0;
        beg_chain = texts.length - 1;
        direc = -1;
    }

    for(var i=0; i<texts.length; i++) {
        if( ! $(texts[i]).hasClass('hide') ) {
            $(texts[i]).addClass('hide');
            if (i == end_chain) {//если видимый был последний(или первый) - запустить цепочку по кругу
                $(texts[beg_chain]).removeClass('hide');
            }
            else {//иначе просто отобразить следующий(или предыдущий) в цепочке елемент
                $(texts[i+direc]).removeClass('hide');
            }
            break;
        }
    }
}