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
        <title>مدیریت زمان‌ها</title>
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
                margin: 10px auto;
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
    .selected{
        box-shadow: 0px 0px 0px 2px #00ff28;
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
        <form class="main_outer_row" id="new_times">
            <p class="explan">در اینجا شما میتوانید زمان‌های ویزیت را انتخاب کنید</p>
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
    if($first_open_day == -1 && $temp['is_open'] == "" && $i > 0){
        $selected = " selected";
        $first_open_day = $i;
    }
    echo '<label class="visit_day '.$closed_class.$selected.'" '.$title.' id="day'.$i.'" onclick="set_selected_day('.$i.')">'.$future_visit_days[$i]["date_for_show"].'</label>';
} ?>
            </div>
            <p class="explan">از بین زمان‌های زیر زمان‌هایی که میخواهید برای رزرو در اختیار دیگران قرار دهید را انتخاب کنید</p>
            <div class="visit_times_row flex" id="visit_times_row"></div>
            <p class="explan">در آخر با کلیک روی دکمه زیر وقت خود را ثبت کنید</p>
            <button class="add_button" type="submit">ثبت زمان‌ها</button>
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
    check_times();
}
function set_selected_time(id){
    const i = document.querySelector("#time"+id);
    if(i.classList.contains('selected')){
        i.classList.remove("selected");
    } else {
        i.classList.add("selected");
    }
}

function create_times_array_for_save(){
    let times = [];
    for (var i = 0; i <= 23 ; i++) {
        var h = "";
        if(i<10)
            h = "0";
        h = h+i;
        const i1 = document.querySelector("#time"+h+"_00");
        if(i1.classList.contains('selected')){
            times.push(h+":00");
        }
        const i2 = document.querySelector("#time"+h+"_30");
        if(i2.classList.contains('selected')){
            times.push(h+":30");
        }
    }
    return times;
}
function get_date_for_search(d){
    var dd = "";
    for(var i=0;i<10;i++){
        dd += d[i];
    }
    return dd;
}

$(function () {
    $('#new_times').submit(function (event) {
        event.preventDefault();
        var d = document.getElementById("day"+selected_day).innerHTML;
        let times = create_times_array_for_save();
        if(times.length == 0){
            show_alert("blue","حداقل یکی از زمان‌ها را انتخاب کنید");
        } else {
            wait_alert();
            $.ajax({
                url: '/addtimes',
                type: 'POST',
                data: {
                    date: get_date_for_search(d),
                    times: JSON.stringify(times),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    show_alert(response.color, response.message);
                    check_times();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    });
});

function is_in_array(a,value){
    for(var i=0;i<a.length;i++){
        if(a[i].time == value)
            return true;
    }
    return false;
}
function get_date_for_search(d){
    var dd = "";
    for(var i=0;i<10;i++)
        dd += d[i];
    return dd;
}

check_times();
function check_times(){
    var day = document.getElementById("day"+selected_day).innerHTML;
    $.ajax({
        url: '/gettimes',
        type: 'get',
        data: {
            date: get_date_for_search(day),
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
                var for_show = "";
                for (var i = 0; i <= 23 ; i++) {
                    var s1="",s2="",h="";
                    if(i<10)
                        h = "0";
                    h = h+i;
                    if(is_in_array(response,h+':00')){
                        s1 = " selected";
                    }
                    if(is_in_array(response,h+':30')){
                        s2 = " selected";
                    }
                    for_show += '<label class="visit_time'+s1+'" id="time'+h+'_00" onclick="set_selected_time(\''+h+'_00\')">'+h+':00</label>';
                    for_show += '<label class="visit_time'+s2+'" id="time'+h+'_30" onclick="set_selected_time(\''+h+'_30\')">'+h+':30</label>';
                }
                document.getElementById("visit_times_row").innerHTML = for_show;
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

</script>

    </body>
</html>
