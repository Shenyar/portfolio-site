/**
 * Created by io05 on 07.07.2016.
 */
window.onload = function() {
    //save collage on button click
    $('#save_btn')[0].onclick = saveFile;

    var context = document.getElementById('canvas').getContext('2d');
    var images = $('.main img'); //select images for collage

    //calculate number strings and columns for collage
    var exit=1;
    for(var col=1; true ; col++) {
        for(var str=col; str <= (col+1); str++) {
            if( (str*col) >= images.length ) {
                exit = 0;
                break;
            }
        }
        if(exit == 0) break;
    }
    var wide_img = str*col - images.length; //calculate number of wide images

    //resize canvas for collage
    document.getElementById('canvas').setAttribute('width',String(col*316+10));
    document.getElementById('canvas').setAttribute('height',String(str*316+10));
    context.fillStyle = "#FFFFFF";
    context.fillRect(0,0,context.canvas.width,context.canvas.height);

    //fill collage by images
    var can_wide, counter=0;
    for( var i=0; i<str; i++) {
        can_wide = 1;
        //when new string - it can begin from wide image
        for(var j=0; j<col; j++) {
            if(can_wide && wide_img) { //wide image
                context.drawImage(images[counter], 0, 140, 640, 340, j*316+10, i*316+10, 622, 306);
                counter++;
                j++;
                can_wide = 0;
                wide_img--;
            }
            else { //normal image
                context.drawImage(images[counter], j*316+10, i*316+10, 306, 306);
                counter++;
            }
        }
    }
};

function saveFile() {
    try {
        var isFileSaverSupported = !!new Blob;
    } catch (e) {
        alert("К сожалению ваш браузер не поддерживает сохранение файла.\nПопробуйте обновить до последней версии");
        return;
    }

    var canvas = document.getElementById('canvas');
    canvas.toBlob(function (blob) {
        saveAs(blob,"collage.png");
    });
}