<?php
if(Auth::user()->role != "admin"){
    die();
}
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
                margin: 10px 0;
                padding: 0 0;
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
                background: #ffd700;
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
        background: #2BA4DF;
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
        <form class="main_order_row flex" id="main_order_row">
        @csrf
            <label class="title">اطلاعات ویزیت و زمان تحویل ماشین</label>
            <p class="order_item"><?php echo "مشتری: ".$user->name; ?></p>
            <p class="order_item"><?php echo "شماره موبایل: ".$user->phone_number; ?></p>
            <p class="order_item"><?php echo "ایمیل: ".$user->email; ?></p>
            <p class="order_item"><?php echo "ماشین: ".$car->model." ".$car->color; ?></p>
            <p class="order_item" style="direction: ltr; text-align:right;"><?php echo $order->time_for_visit; ?></p>
            <p class="order_item"><?php echo "هزینه: ".number_format($order->price)." تومان"; ?></p>
            <pre class="order_item" style="width: 97%;"><?php echo "مشکل ماشین: ".$order->problem; ?></pre>
            <input class="order_item" id="time_for_take_car" name="time_for_take_car" placeholder="زمان تحویل ماشین را بنویسید" value="<?php echo $order->time_for_take_car; ?>" type="text">
            <button class="order_item" type="submit">ثبت زمان تحویل</button>
        </form>
        <div class="main_order_row flex">
            <label class="title">کارهای انجام شده</label>
            <div class="inner_order_row">
                <label class="title">قطعات استفاده شده</label>
                <form class="inner_order_row_form" id="new_car_part">
                    <input class="inner_order_item" id="car_part_name" placeholder="نام قطعه" type="text">
                    <input class="inner_order_item" id="car_part_price" placeholder="هزینه قطعه" type="text">
                    <button class="inner_order_item" type="submit">ثبت تغییرات</button>
                </form>
                <label class="title">قطعات استفاده شده و ثبت شده</label>
                <label class="title" id="car_parts_count"></label>
                <div class="inner_order_row_list" id="car_parts_row"></div>
            </div>
            <div class="inner_order_row">
                <label class="title">تعمیرات انجام شده</label>
                <form class="inner_order_row_form" id="new_repair">
                    <input class="inner_order_item" id="repair_text" placeholder="متن تعمیر" type="text">
                    <input class="inner_order_item" id="repair_price" placeholder="هزینه تعمیر" type="text">
                    <button class="inner_order_item" type="submit">ثبت تغییرات</button>
                </form>
                <label class="title">تعمیرات انجام شده و ثبت شده</label>
                <label class="title" id="repairs_count"></label>
                <div class="inner_order_row_list" id="repairs_row"></div>
            </div>
        </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">

$(function () {
    $('#main_order_row').submit(function (event) {
        event.preventDefault();
        wait_alert();
        var time_for_take_car = document.getElementById("time_for_take_car").value;

        if(time_for_take_car == ""){
            show_alert("blue","زمان تحویل ماشین را بنویسید");
        } else {
            $.ajax({
                url: '/update_time_for_take_car',
                type: 'POST',
                data: {
                    id: <?php echo $order->id; ?>,
                    time_for_take_car: time_for_take_car,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    show_alert(response.color, response.message);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    });
});

$(function () {
    $('#new_car_part').submit(function (event) {
        event.preventDefault();
        wait_alert();
        var car_part_name = document.getElementById("car_part_name").value;
        var car_part_price = document.getElementById("car_part_price").value;

        if(car_part_name == "" || car_part_price == ""){
            show_alert("blue","نام و هزیته قطعه را وارد کنید");
        } else {
            $.ajax({
                url: '/add_car_part',
                type: 'POST',
                data: {
                    order_id: <?php echo $order->id; ?>,
                    name: car_part_name,
                    price: car_part_price,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    show_alert(response.color, response.message);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    });
});

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
                    for_show += '       <button class="inner_car_part_item red" onclick="delete_car_part('+r.id+')">حذف</button>';
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

function delete_car_part(id){
    wait_alert();
    var result = confirm("آیا مطمئن هستید که می‌خواهید این قطعه را حذف کنید؟");
    if (result) {
        $.ajax({
            url: '/delete_car_part/'+id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                show_alert(response.color,response.message);
                if(response.color == "green"){
                    $('#car_part'+id).remove();
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
}


$(function () {
    $('#new_repair').submit(function (event) {
        event.preventDefault();
        wait_alert();
        var repair_text = document.getElementById("repair_text").value;
        var repair_price = document.getElementById("repair_price").value;

        if(repair_text == "" || repair_price == ""){
            show_alert("blue","نام و هزیته تعمیر را وارد کنید");
        } else {
            $.ajax({
                url: '/add_repair',
                type: 'POST',
                data: {
                    order_id: <?php echo $order->id; ?>,
                    text: repair_text,
                    price: repair_price,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    show_alert(response.color, response.message);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    });
});

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
                    for_show += '       <button class="inner_car_part_item red" onclick="delete_repair('+r.id+')">حذف</button>';
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

function delete_repair(id){
    wait_alert();
    var result = confirm("آیا مطمئن هستید که می‌خواهید این تعمیر را حذف کنید؟");
    if (result) {
        $.ajax({
            url: '/delete_repair/'+id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                show_alert(response.color,response.message);
                if(response.color == "green"){
                    $('#repair'+id).remove();
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
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

</script>

    </body>
</html>
