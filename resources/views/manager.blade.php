<?php
if(Auth::user()->role != "admin"){
    header('Location: '.url('/'));
    die();
}
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>زمان ملاقات‌های سایت</title>
        <!-- Styles -->
        @include('amh')
        <style>
            .main_row{
                display: block;
                width: 100%;
                padding: 20px 0;
                margin: 60px 0;
                background: #fff;
                box-shadow: 0px 0px 10px 10px #fff;
            }
            .controlls{
                padding: 0 0 20px 0;
            }
            .controll{
                display: inline-block;
                width: 19%;
                margin: 20px 0.63% 0 0;
                padding: 10px 0;
                background: #eee;
                border-radius: 30px;
                text-align: center;
            }
            .visit{
                display: flex;
                width: 90%;
                margin: 40px auto;
                background: #fff;
                border: solid 1px;
                border-radius: 30px;
            }
            #visits_row a:hover, .controll:hover{
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
            .title{
                display: block;
                width: 100%;
                padding: 10px 0;
                margin: 10px 0;
                text-align: center;
            }
        </style>
    </head>
    <body>
        @include('tm')
        @include('amb')
        <div class="main_row controlls">
            <label class="title">لیست کنترل‌ها</label>
            <a class="controll" href="{{ url('/all_site_visits') }}">مدیریت ویزیت‌ها</a>
            <a class="controll" href="{{ url('/manage_times') }}">مدیریت زمان‌ها</a>
            <a class="controll" href="{{ url('/users_visits') }}">ملاقات‌های کاربران</a>
            <a class="controll" href="{{ url('/cars_visits') }}">ماشین‌ها</a>
        </div>
        <div class="main_row">
            <label class="title">لیست ملاقات‌های امروز</label>
            <div class="visit"><p class="visit_item" id="all_price"></p></div>
            <div id="visits_row"></div>
        </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">

function find_in_array(a,id){
    for (var i = 0; i < a.length ; i++) {
        if(a[i].id == id){
            return a[i];
        }
    }
    return null;
}

var vc = 0;
function check_visits(){
    $.get('/gettodayvisits', function(data) {
            console.log(data);
        var orders = data;
        if(vc != orders.length){
            var for_show = "";
            var all_price = 0;
            for (var i = orders.length-1; i >= 0 ; i--) {
                var v = orders[i];
                for_show += '<a class="visit" href="<?php echo url('/manage_visit?id='); ?>'+v.id+'">';
                for_show += '   <p class="visit_item" style="direction: ltr;">'+v.time_for_visit+'</p>';
                for_show += '   <p class="visit_item">هزینه: '+format_number(v.price)+' تومان</p>';
                for_show += '   <p class="visit_item">زمان تحویل ماشین: '+v.time_for_take_car+'</p>';
                for_show += '   <p class="visit_item">'+v.c_model+'</p>';
                for_show += '   <p class="visit_item">'+v.u_name+'</p>';
                for_show += '   <pre class="visit_item">'+v.problem+'</pre>';
                for_show += '</a>';
                all_price += v.price;
            }
            document.getElementById("visits_row").innerHTML = for_show;
            document.getElementById("all_price").innerHTML = "امروز "+format_number(all_price)+" تومان درآمد از ویزیت خواهید داشت";
        }
        vc = orders.length;
    });
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

refresh();
function refresh(){
    check_visits();
    setTimeout(refresh, 4000);
}
</script>

    </body>
</html>
