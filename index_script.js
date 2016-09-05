/**
 * Created by io05 on 30.08.2016.
 */
window.onload = function() {
    $('.my-carousel-right').bind('click',carousel_right);
    $('.my-carousel-left').bind('click',carousel_left);

    $('#accordion').accordion();

    /*open dropdown menu on click*/
    $('.js-dropdown-label').bind('click',function() {
        event.stopPropagation();
        $('.js-dropdown-menu').removeClass('hidden-xs').addClass('js-menu-visible');
        window.addEventListener('click', function() {
            $('.js-dropdown-menu').addClass('hidden-xs').removeClass('js-menu-visible');
            window.removeEventListener('click',function(){});
        })
    });
};

function carousel_right() {
    var elems = $('.my-carousel-item');
    for( var i = 0, len = elems.length; i<len; i++) {
        if( $(elems[i]).hasClass('my-carousel-left') ) {

            $(elems[i])
                .addClass('my-carousel-hide')
                .removeClass('my-carousel-left')
                .unbind('click');
            $( elems[(i+1)%len] )
                .addClass('my-carousel-left')
                .removeClass('my-carousel-active')
                .bind('click',carousel_left);
            $( elems[(i+2)%len] )
                .unbind('click')
                .addClass('my-carousel-active')
                .removeClass('my-carousel-right');
            $( elems[(i+3)%len] )
                .addClass('my-carousel-right')
                .removeClass('my-carousel-hide')
                .bind('click',carousel_right);
            break;

        }
    }
}

function carousel_left() {
    var elems = $('.my-carousel-item');
    for( var i = 0, len = elems.length; i<len; i++) {
        if( $(elems[i]).hasClass('my-carousel-left') ) {

            if( i == 0 ) {
                i = len-1;
            } else {
                i --;
            }
            $(elems[i])
                .addClass('my-carousel-left')
                .removeClass('my-carousel-hide')
                .bind('click',carousel_left);
            $( elems[(i+1)%len] )
                .addClass('my-carousel-active')
                .removeClass('my-carousel-left')
                .unbind('click');
            $( elems[(i+2)%len] )
                .addClass('my-carousel-right')
                .removeClass('my-carousel-active')
                .bind('click',carousel_right);
            $( elems[(i+3)%len] )
                .addClass('my-carousel-hide')
                .removeClass('my-carousel-right')
                .unbind('click');
            break;

        }
    }
}