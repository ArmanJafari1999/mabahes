<?php
include('jdf.php');

function get_dat_of_week_name($d){
    switch ($d) {
        case 1: return 'یکشنبه'; break;
        case 2: return 'دوشنبه'; break;
        case 3: return 'سه‌شنبه'; break;
        case 4: return 'چهارشنبه'; break;
        case 5: return 'پنجشنبه'; break;
        case 6: return 'جمعه'; break;
    }
    return 'شنبه';
}
function is_open($m,$d,$dow){
    $holidays = [
        '01-01' => 'عید نوروز',
        '01-02' => 'عید نوروز',
        '01-03' => 'عید نوروز',
        '01-04' => 'عید نوروز',
        '01-05' => 'عید نوروز',
        '01-06' => 'عید نوروز',
        '01-07' => 'عید نوروز',
        '01-08' => 'عید نوروز',
        '01-09' => 'عید نوروز',
        '01-12' => 'روز جمهوری اسلامی ایران',
        '01-13' => 'روز طبیعت',
        '03-20' => 'رحلت حضرت امام خمینی (ره)',
        '03-21' => 'قیام ۱۵ خرداد',
        '05-06' => 'مبعث حضرت رسول اکرم (ص)',
        '05-08' => 'شهادت حضرت علی (ع)',
        '06-03' => 'تاسوعا',
        '06-04' => 'عاشورا',
        '06-05' => 'شهادت امام سجاد (ع)',
        '08-20' => 'شهادت امام رضا (ع)',
        '09-08' => 'عید سعید قربان',
        '09-09' => 'عید سعید قربان',
        '09-10' => 'عید سعید قربان',
        '11-09' => 'شهادت امام حسن عسکری (ع)',
        '11-28' => 'شهادت پیامبر اکرم (ص) و امام حسن مجتبی (ع)',
        '12-01' => 'شهادت امام رضا (ع)',
        '12-17' => 'میلاد پیامبر اکرم (ص)',
        '12-29' => 'وفات حضرت رسول اکرم (ص) و شهادت امام حسن مجتبی (ع)'
    ];
    if(isset($holidays[$m.'-'.$d]))
        return $holidays[$m.'-'.$d];
    if($dow == 6)
        return 'جمعه';
    return '';
}
function get_next_day_date(int $y, int $m, int $d, int $dow, $is_leap){
    if($m <= 6){
        if($d<=30){
            $d++;            
        } else {
            $m++;
            $d = 1;            
        }
    } else if($m == 12){
        if($d<=28){
            $d++;            
        } else if($d == 29) {
            if($is_leap == true){
                $d++;
            } else {
                $y++;
                $m = 1;
                $d = 1;
            }
        }
    } else {
        if($d<=29){
            $d++;            
        } else {
            $m++;
            $d = 1;            
        }
    }
    $dow++;
    if($dow > 6)
        $dow = 0;
    if($m < 10)
        $m = "0".$m;
    if($d < 10)
        $d = "0".$d;
    $date_for_show = $y.'/'.$m.'/'.$d.' '.get_dat_of_week_name($dow);
    return array('y'=>$y,'m'=>$m,'d'=>$d,'day_of_week'=>$dow,'date_for_show'=>$date_for_show,'is_open'=>is_open($m,$d,$dow));
}

$year = jdate('Y');
$month = jdate('m');
$day = jdate('d');
$hour = jdate('H');
$minute = jdate('i');
$second = jdate('s');
$day_of_week = jdate('w');

$date_for_show = $year.'/'.$month.'/'.$day.' '.get_dat_of_week_name($day_of_week);
$future_visit_days = array(array('y'=>$year,'m'=>$month,'d'=>$day,'day_of_week'=>$day_of_week,'date_for_show'=>$date_for_show,'is_open'=>is_open($month,$day,$day_of_week)));
for($i=0;$i<13;$i++){
    $t = $future_visit_days[$i];
    $temp_date = get_next_day_date($t['y'],$t['m'],$t['d'],$t['day_of_week'],is_leap($t['y']));
    array_push($future_visit_days, $temp_date);
}
$future_visit_days_count = count($future_visit_days);
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>گرفتن وقت ملاقات</title>
        <!-- Styles -->
        @include('amh')
        <style>
            .main_outer_row{
                display: block;
                width: 100%;
                margin: 40px 0;
                padding: 0 0 30px;
                box-shadow: 0px 0px 10px 10px #fff;
                background: #fff;
            }
            .visit_days_row{
                display: flex;
                width: 100%;
            }
            .visit_day{
                display: block;
                width: 6.6%;
                margin: 20px auto;
                padding: 10px 0;
                text-align: center;
                border-radius: 20px;
                cursor: pointer;
            }
            .open_day, .open_time{
                background: #eee;
            }
            .visit_day:hover{
                background: skyblue;
            }
            .visit_times_row{
                width: 100%;
                margin: 20px 0;
            }
            .visit_time{
                display: inline-block;
                width: 12%;
                margin: 10px 0.44% 10px 0;
                padding: 5px 0;
                text-align: center;
                cursor: pointer;
                border-radius: 100px;
                background: #eee;
            }
            .visit_time:hover{
                background: skyblue;
            }
    .car{
        display: flex;
        width: 30%;
        margin: 30px auto;
        border: solid #454545;
        border-radius: 30px;
    }
    .car_item{
        display: block;
        width: 50%;
        padding: 5px 0;
        border-left: solid #454545;
        margin: 0;
        text-align: center;
        cursor: pointer;
    }
    .car_item:last-child{
        border: none;
        border-radius: 30px 0px 0px 30px;
    }
    .selected .car_item{
        border-left: solid #00ff28;
    }
    .selected .car_item:last-child{
        border: none;
    }
    .selected{
        box-shadow: 0 0 0 3px #00ff28;
    }
    #cars_row .selected{
        border: solid #00ff28;
        box-shadow: none;
    }
    .cant_select{
        border: solid #f00;
    }
    .problem{
        display: block;
        width: 85%;
        padding: 5px 2.5%;
        margin: 20px auto;
        color: #000;
        border-radius: 30px;
    }

    .explan{
        display: block;
        width: 100%;
        border-top: solid #454545;
        padding: 20px 0 0px;
        margin: 20px auto 10px;
        text-align: center;
    }
    .explan:first-child{
        border: none;
        border-radius: 30px 0px 0px 30px;
    }
    .add_button{
        display: block;
        background: #eee;
        padding: 10px 30px;
        margin: 20px auto 10px;
        text-align: center;
        border-radius: 100px;
        border: solid #454545;
        cursor: pointer;
    }
    .car:hover,
    .add_button:hover{
        background: skyblue;
    }
        </style>
    </head>
    <body>
        @include('tm')
        @include('amb')
        <form class="main_outer_row" id="new_vesit">
            <p class="explan">برای گرفتن وقت ملاقات باید زمان ماشین را نتخاب کنید</p>
            <p class="explan">از بین روزهای زیر یکی را انتخاب کنید</p>
            <div class="visit_days_row">
<?php
    $first_open_day = -1;
for($i=0;$i<$future_visit_days_count;$i++) {
    $temp = $future_visit_days[$i];
    $closed_class = "open_day";
    $title = "";
    if($temp['is_open'] != "") {
        $title = 'title="'.$temp['is_open'].'"';
        $closed_class = "red";
    }
    $selected = "";
//    if($first_open_day == -1 && $temp['is_open'] == "" && $i > 0){
    if($first_open_day == -1 && $i > 0){
            $selected = " selected";
        $first_open_day = $i;
    }
    echo '<label class="visit_day '.$closed_class.$selected.'" '.$title.' id="day'.$i.'" onclick="set_selected_day('.$i.')">'.$future_visit_days[$i]["date_for_show"].'</label>';
} ?>
            </div>
            <p class="explan">از بین زمان‌های زیر یکی را انتخاب کنید</p>
            <div class="visit_times_row flex" id="visit_times_row"></div>
            <p class="explan">از بین ماشین‌های زیر یکی را انتخاب کنید</p>
            <div class="flex" id="cars_row"></div>
            <p class="explan">در بخش زیر توضیحاتی درمورد شرایط خرابی بدهید</p>
            <textarea class="problem" id="problem" name="problem" rows="5" cols="60" placeholder="توضیحاتی درمورد مشکل ماشین خود اینجا بنویسید"></textarea>
            <p class="explan">در آخر با کلیک روی دکمه زیر وقت خود را ثبت کنید</p>
            <button class="add_button" type="submit">پرداخت هزینه و ثبت وقت</button>
        </form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">

var selected_day = <?php echo $first_open_day; ?>;
function set_selected_day(id){
    const i1 = document.querySelector("#day"+selected_day);
    const i2 = document.querySelector("#day"+id);
    i1.classList.remove("selected");
    i2.classList.add("selected");
    selected_day = id;
    if(i2.classList.contains('red'))
        show_alert("green","دلیل تعطیلی: "+document.getElementById("day"+id).title);
    check_visit_times();
}
var selected_time = "0";
var selected_time_id = 0;
function set_selected_time(id){
    if(selected_time != "0"){
        const i1 = document.querySelector("#time"+selected_time_id);
        const i2 = document.querySelector("#time"+id);
        if(i2.classList.contains('red')){
            show_alert("blue","این ساعت گرفته شده است");
        } else {
            if(i1.classList.contains('selected')){
                i1.classList.remove("selected");
            }
            i2.classList.add("selected");
            selected_time_id = id;
            selected_time = document.getElementById("time"+id).innerHTML;
        }
    } else {
        const i2 = document.querySelector("#time"+id);
        if(i2.classList.contains('red')){
            show_alert("blue","این ساعت گرفته شده است");
        } else {
            i2.classList.add("selected");
            selected_time_id = id;
            selected_time = document.getElementById("time"+id).innerHTML;
        }
    }
}
var selected_car = -1;
function set_selected_car(id){
    const i1 = document.querySelector("#car"+selected_car);
    const i2 = document.querySelector("#car"+id);
    if(i1.classList.contains('selected')){
        i1.classList.remove("selected");
    }
    i2.classList.add("selected");
    selected_car = id;
}

$(function () {
    $('#new_vesit').submit(function (event) {
        event.preventDefault();
        var problem = document.getElementById("problem").value;
        var vd = document.getElementById("day"+selected_day).innerHTML;
        var vt = "";
        if(selected_time != "0")
            vt = selected_time;
        if(vt == ""){
            show_alert("blue","زمان ملاقات را انتخاب کنید");
        } else if(problem == ""){
            show_alert("blue","توضیحاتی درباره مشکل خود بنویسید");
        } else {
            wait_alert();
            $.ajax({
                url: '/addvisit',
                type: 'POST',
                data: {
                    car_id: selected_car,
                    time_for_visit: get_date_for_save(vd,vt),
                    date: get_date_for_search(vd),
                    time: vt,
                    problem: problem,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    show_alert(response.color, response.message);
                    if(response.color == "green")
                        location.replace("{{url('/my_visits')}}");
                    check_visit_times();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    });
});


var cc = 0;
function check_cars(){
    $.ajax({
        url: '/getmycars',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if(cc != response.length){
                var for_show = "";
                for (var i = response.length-1; i >= 0 ; i--) {
                    var car = response[i];
                    var s = "";
                    if(selected_car == -1 && i == response.length-1)
                        selected_car = car.id;
                    if(selected_car == car.id)
                        s = " selected";
                    for_show += '<div class="car'+s+'" id="car'+car.id+'" onclick="set_selected_car('+car.id+')">';
                    for_show += '   <p class="car_item">'+car.model+'</p>';
                    for_show += '   <p class="car_item">'+car.color+'</p>';
//                    for_show += '   <p class="car_item" style="direction:ltr;">'+set_date(car.created_at)+'</p>';
                    for_show += '</div>';
                }
                document.getElementById("cars_row").innerHTML = for_show;
            }
            cc = response.length;
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

function check_visit_times(){
    var tfv_day = document.getElementById("day"+selected_day).innerHTML;
    $.ajax({
        url: '/getfreetimes',
        type: 'get',
        data: {
            date: get_date_for_search(tfv_day),
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            var for_show = "";
            for (var i = 0; i < response.length ; i++) {
                var t = response[i].time;
                var s = "";
                if(selected_time == t)
                    s = " selected";
                for_show += '<label class="visit_time'+s+'" id="time'+i+'" onclick="set_selected_time('+i+')">'+t+'</label>';
            }
            document.getElementById("visit_times_row").innerHTML = for_show;
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

refresh();
function refresh(){
    check_cars();
    check_visit_times();
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

function get_date_for_save(vd,vt){
    var dd = "";
    for(var i=0;i<vd.length;i++){
        if(vd[i] == ' '){
            dd += " ";
            for(var j=0;j<vt.length;j++){
                dd += vt[j];
            }
            dd += " ";
        } else {
            dd += vd[i];
        }
    }
    return dd;
}

function get_date_for_search(d){
    var dd = "";
    for(var i=0;i<10;i++)
        dd += d[i];
    return dd;
}

function is_in_array(a,value){
    for(var i=0;i<a.length;i++){
        if(a[i].time_for_visit == value)
            return true;
    }
    return false;
}

</script>

        @include('f')
    </body>
</html>
