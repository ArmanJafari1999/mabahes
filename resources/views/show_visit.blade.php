<?php
use App\Models\User;
use App\Models\Cars;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;

$id = request('id');
$order = DB::table('orders')->where('id', $id)->get()[0];
$user = User::select('id', 'name', 'phone_number', 'email')->where('id', $order->user_id)->get()[0];
$car = DB::table('cars')->where('id', $order->car_id)->get()[0];

if($order->time_for_take_car == "-"){
    $order->time_for_take_car = "";
}
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>جزئیات ملاقات</title>
        @include('amh')
        <style>
            .title{
                display: block;
                width: 100%;
                text-align: center;
            }
            .main_order_row{
                display: flex;
                width: 90%;
                margin: 40px auto;
                padding: 0 2.5%;
                box-shadow: 0px 0px 10px 10px #fff;
                background: #fff;
                border-radius: 30px;
            }
            .order_item{
                display: block;
                width: 30%;
                margin: 10px auto;
                padding: 10px 1%;
                border-radius: 30px;
            }
            .main_order_row button{
                background: red;
                color: #fff;
                cursor: pointer;
            }
            .inner_order_row{
                display: block;
                width: 45%;
                margin: 20px auto;
                border-radius: 30px;
                background: #fff;
                border: solid;
            }
            .inner_order_row_form{
                display: block;
                width: 95%;
                margin: 10px auto;
                padding: 10px 0;
                border-radius: 30px;
                background: #eee;
            }
            .inner_order_item{
                display: block;
                width: 85%;
                padding: 10px 5%;
                margin: 10px auto;
                border-radius: 30px;
            }
    .car_part_item{
        display: block;
        width: 90%;
        margin: 30px auto;
        border: solid;
        border-radius: 30px;
    }
    .car_part_item button{
        background: #C91524;
    }
    .car_part_item button{
        background: #C91524;
    }
    button:hover{
        background: skyblue;
        color: #000;
    }
    .car_part_item .inner_car_part_item{
        display: block;
        width: 50%;
        padding: 5px 0;
        border-left: solid;
        margin: 0 auto;
        text-align: center;
    }
    .car_part_item .inner_car_part_item:last-child{
        border: none;
        border-radius: 0 0 0 28px;
        cursor: pointer;
    }
        </style>
    </head>
    <body>
        @include('tm')
        @include('amb')
        <div class="main_order_row flex" id="main_order_row">
            <label class="title">اطلاعات ویزیت و زمان تحویل ماشین</label>
            <p class="order_item"><?php echo "مشتری: ".$user->name; ?></p>
            <p class="order_item"><?php echo "شماره موبایل: ".$user->phone_number; ?></p>
            <p class="order_item"><?php echo "ایمیل: ".$user->email; ?></p>
            <p class="order_item"><?php echo "ماشین: ".$car->model." ".$car->color; ?></p>
            <p class="order_item" style="direction: ltr; text-align:right;"><?php echo $order->time_for_visit; ?></p>
            <p class="order_item"><?php echo "هزینه: ".$order->price." تومان"; ?></p>
            <p class="order_item"><?php echo "زمان تحویل ماشین: ".$order->time_for_take_car; ?></p>
            <pre class="order_item" style="width: 97%;"><?php echo "مشکل ماشین: ".$order->problem; ?></pre>
            <button class="order_item" type="submit" onclick="delete_visit({{$order->id}})">حذف زمان ملاقات</button>
        </div>
        <div class="main_order_row flex">
            <label class="title">کارهای انجام شده</label>
            <div class="inner_order_row">
                <label class="title">قطعات استفاده شده</label>
                <label class="title" id="car_parts_count"></label>
                <div class="inner_order_row_list" id="car_parts_row"></div>
            </div>
            <div class="inner_order_row">
                <label class="title">تعمیرات انجام شده و ثبت شده</label>
                <label class="title" id="repairs_count"></label>
                <div class="inner_order_row_list" id="repairs_row"></div>
            </div>
        </div>
        @include('f')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">

var cpc = 0;
function check_car_parts(){
    $.ajax({
        url: '/get_my_car_parts',
        type: 'POST',
        data: {
            order_id: <?php echo $order->id; ?>,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if(cpc != response.length){
                var for_show = "";
                var car_parts_count = 0;
                for (var i = response.length-1; i >= 0 ; i--) {
                    var r = response[i];
                    for_show += '<div class="car_part_item" id="car_part'+r.id+'">';
                    for_show += '   <div style="display:flex;border-bottom:solid;">';
                    for_show += '       <p class="inner_car_part_item">'+r.name+'</p>';
                    for_show += '       <p class="inner_car_part_item">'+format_number(r.price)+' تومان</p>';
                    for_show += '   </div>';
                    for_show += '   <div style="display:flex;">';
                    for_show += '       <p class="inner_car_part_item" style="direction:ltr;">'+set_date(r.created_at)+'</p>';
                    for_show += '   </div>';
                    for_show += '</div>';
                    car_parts_count += parseInt(r.price);
                }
                document.getElementById("car_parts_row").innerHTML = for_show;
                document.getElementById("car_parts_count").innerHTML = format_number(car_parts_count)+" تومان تا کنون";
            }
            cpc = response.length;
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

var cr = 0;
function check_repairs(){
    $.ajax({
        url: '/get_my_repairs',
        type: 'POST',
        data: {
            order_id: <?php echo $order->id; ?>,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if(cr != response.length){
                var for_show = "";
                var repairs_count = 0;
                for (var i = response.length-1; i >= 0 ; i--) {
                    var r = response[i];
                    for_show += '<div class="car_part_item" id="repair'+r.id+'">';
                    for_show += '   <div style="display:flex;border-bottom:solid;">';
                    for_show += '       <p class="inner_car_part_item">'+r.text+'</p>';
                    for_show += '       <p class="inner_car_part_item">'+format_number(r.price)+' تومان</p>';
                    for_show += '   </div>';
                    for_show += '   <div style="display:flex;">';
                    for_show += '       <p class="inner_car_part_item" style="direction:ltr;">'+set_date(r.created_at)+'</p>';
                    for_show += '   </div>';
                    for_show += '</div>';
                    repairs_count += parseInt(r.price);
                }
                document.getElementById("repairs_row").innerHTML = for_show;
                document.getElementById("repairs_count").innerHTML = format_number(repairs_count)+" تومان تا کنون";
            }
            cr = response.length;
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

refresh();
function refresh(){
    check_car_parts();
    check_repairs();
    setTimeout(refresh, 4000);
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
function delete_visit(id){
    var result = confirm("آیا مطمئن هستید که می‌خواهید زمان ملاقات را حذف کنید؟");
    if (result) {
        $.ajax({
            url: '/deleteorder',
            type: 'POST',
            data: {
                id: <?php echo $order->id; ?>,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.color == "green"){
                    location.replace("{{url('/my_visits')}}");
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
}
</script>

    </body>
</html>
