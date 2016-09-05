/**
 * Created by io05 on 11.05.2016.
 */

window.onload = function() {
    document.getElementById('btn_calc').onclick = calculate;
};

function calculate() {
    var height = document.getElementById('in_height').value;
    var mass = document.getElementById('in_mass').value;
    //check for errors
    if(( ! parseFloat(height) ) || (height < 0)) {
        alert('Вы не ввели рост!\n(Допускаются только положительные числа)');
        return;
    }
    if(( ! parseFloat(mass) ) || (mass < 0)) {
        alert("Вы не ввели вес!\n(Допускаются только положительные числа)");
        return;
    }
    var imt = parseFloat(mass) / Math.pow(( parseFloat(height)/100 ),2);
    document.getElementById('result').innerHTML = "Результат: "+imt.toPrecision(4);

    //coloring row of the table
    if( imt < 18.5 ) {
        uncheck();
        document.getElementById('result').style.color = 'blue';
        document.getElementById('t1').style.backgroundColor = 'blue';
    } else
    if( imt < 25.0 ) {
        uncheck();
        document.getElementById('result').style.color = 'green';
        document.getElementById('t2').style.backgroundColor = 'green';
    } else
    if( imt < 30.0 ) {
        uncheck();
        document.getElementById('result').style.color = 'yellowgreen';
        document.getElementById('t3').style.backgroundColor = 'yellowgreen';
    } else
    if( imt < 35.0 ) {
        uncheck();
        document.getElementById('result').style.color = 'yellow';
        document.getElementById('t4').style.backgroundColor = 'yellow';
    } else
    if( imt < 40.0 ) {
        uncheck();
        document.getElementById('result').style.color = 'orange';
        document.getElementById('t5').style.backgroundColor = 'orange';
    } else {
        uncheck();
        document.getElementById('result').style.color = 'red';
        document.getElementById('t6').style.backgroundColor = 'red';
    }

    //apply animation
    if(getComputedStyle(document.getElementById('show-in')).marginTop == '110px') {
        document.getElementById('show-in').style.marginTop = '10px';
        document.getElementById('show-out').style.marginTop = '-10px';
        document.getElementById('show-out').style.height = '400px';
        document.getElementById('btn_calc').value = 'Стереть данные';
    } else {
        document.getElementById('show-in').style.marginTop = '';
        document.getElementById('show-out').style.marginTop = '';
        document.getElementById('show-out').style.height = '';
        document.getElementById('btn_calc').value = 'Рассчитать ИМТ';
        document.getElementById('in_height').value = '';
        document.getElementById('in_mass').value = '';
    }
}

function uncheck() {
    //uncheck colored table rows
    for(var i=1; i<7; i++) {
        document.getElementById('t'+i).style.backgroundColor = '';
    }
}