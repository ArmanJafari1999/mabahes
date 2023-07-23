<?php
use App\Models\Cars;
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>زمان ملاقات‌های شما</title>
        <!-- Styles -->
        @include('amh')
        <style>
            .visit{
                display: flex;
                width: 90%;
                margin: 40px auto;
                background: #fff;
                border: solid 1px;
                border-radius: 30px;
            }
            #visits_row a:hover{
                background: skyblue;
            }
            .visit p, .visit pre{
                display: block;
                width: 90%;
                margin: auto;
                padding: 10px 0;
            }
            .visit p{
                text-align: center;
            }
        </style>
    </head>
    <body>
        @include('tm')
        @include('amb')
        <div class="visit"><p class="visit_item" id="all_price"></p></div>
        <div id="visits_row"></div>
        @include('f')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">

var vc = 0;
check_visits();
function check_visits(){
    $.get('/getmyvisits', function(data) {
        if(vc != data.length){
            var for_show = "";
            var all_price = 0;
            for (var i = data.length-1; i >= 0 ; i--) {
                var v = data[i];
                for_show += '<a class="visit" href="<?php echo url('/show_visit?id='); ?>'+v.id+'">';
                for_show += '   <p class="visit_item" style="direction: ltr;">'+v.time_for_visit+'</p>';
                for_show += '   <p class="visit_item">هزینه: '+format_number(v.price)+' تومان</p>';
                for_show += '   <p class="visit_item">زمان تحویل ماشین: '+v.time_for_take_car+'</p>';
                for_show += '   <p class="visit_item">'+v.c_model+'</p>';
                for_show += '   <pre class="visit_item">'+v.problem+'</pre>';
                for_show += '</a>';
                all_price += v.price;
            }
            document.getElementById("visits_row").innerHTML = for_show;
            document.getElementById("all_price").innerHTML = format_number(all_price)+" تومان تا کنون هزینه کرده‌اید";
            }
        vc = data.length;
    });
    setTimeout(check_visits, 4000);
}

function set_date(d){
    var dd = "";
    for(var i=0;i<=18;i++){
        if(i == 10){
            dd += " ";
        } else if(d[i] == '-'){
            dd += "/";
        } else {
            dd += d[i];
        }
    }
    return dd;
}

</script>

    </body>
</html>
