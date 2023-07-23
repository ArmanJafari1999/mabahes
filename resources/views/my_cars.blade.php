<!DOCTYPE html>
<html dir="rtl" lang="fa"><head>
    <title>ماشین‌های شما</title>
    @include('amh')
<style>
.new_car {
    display: flex;
}
.row {
    display: block;
}
.new_car , .row{
    width: 80%;
    padding: 30px 5%;
    margin: 40px auto;
    background: #fff;
    border-radius: 50px;
    box-shadow: 0px 0px 10px 10px #fff;
}
    .new_car input{
        display: block;
        height: auto;
        border-radius: 30px;
        width: 30%;
        padding: 10px 1%;
        margin: 10px auto;
        background:#fff;
    }

    .new_car button {
    display: block;
    width: auto;
    margin: auto;
    border-radius: 60px;
    text-align: center;
    font-weight: bold;
    cursor: pointer;
    padding: 10px 30px;
    background:#ffc107;
    color: #000;
}
button:hover{
    background: #FF8C00 ;
}

.tittle_row{
        display: block;
        width: 70%;
        margin: 40px auto 10px;
        padding: 10px 0;
        border-radius: 30px;
        background: #fff;
        border: solid #eee;
        box-shadow: 0px 0px 30px 10px #fff;
    }
    
    .explaine {
        display: inline-block;
        width: 90%;
        padding: 5px 5%;
        margin: 0;
        text-align: center;
        font-weight:bold;
    }
    .car{
        display: flex;
        width: 90%;
        margin: 30px auto;
        border: solid;
        border-radius: 30px;
    }
    .car .car_item{
        display: block;
        width: 30%;
        padding: 5px 0;
        border-left: solid;
        margin: 0;
        text-align: center;
    }
    .car .car_item:last-child{
        width: 10%;
        border: none;
        padding: 5px 0;
        border-radius: 30px 0px 0px 30px;
        cursor: pointer;
    }
    .cars_row a:hover{
        background: skyblue;
    }
</style>
</head>
<body>
    @include('tm')
    @include('amb')
    <div class="tittle_row">
        <p class="explaine">در اینجا اطلاعات ماشین‌تان را وارد کنید</p>
    </div>
    <form class="new_car" id="new_car">
        @csrf
        <input id="model" name="model" placeholder="مدل ماشین" type="text">
        <input id="color" name="color" placeholder="رنگ ماشین" type="text">
        <button title="ثبت ماشین" type="submit">ثبت ماشین</button>
    </form>
    <div class="tittle_row">
        <p class="explaine">در اینجا لیست ماشین‌هایتان را ببینید</p>
    </div>
    <div class="row">
        <div class="cars_row" id="cars_row"></div>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">

$(function () {
    $('#new_car').submit(function (event) {
        event.preventDefault();
        wait_alert();
        var model = document.getElementById("model").value;
        var color = document.getElementById("color").value;

        if(model == "" || color == ""){
            show_alert("blue","تمام مقادیر را پر کنید");
        } else {
            $.ajax({
                url: "{{ route('addcar') }}",
                method: 'POST',
                data: {
                    model: model,
                    color: color,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    console.log(response);
                    document.getElementById("model").value = "";
                    document.getElementById("color").value = "";
                    show_alert(response.color,response.message);
                    check_cars();
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    });
});

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


var cc = 0;
function check_cars(){
    $.ajax({
        url: '/getmycars',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            console.log(response);
            if(cc != response.length){
                var for_show = "";
                for (var i = response.length-1; i >= 0 ; i--) {
                    var car = response[i];
                    for_show += '<div class="car" id="car'+car.id+'">';
                    for_show += '   <p class="car_item">'+car.model+'</p>';
                    for_show += '   <p class="car_item">'+car.color+'</p>';
                    for_show += '   <p class="car_item" style="direction:ltr;">'+set_date(car.created_at)+'</p>';
                    for_show += '   <a class="car_item" href="<?php echo url('/car_visits/?id='); ?>'+car.id+'">ملاقات‌ها</a>';
                    for_show += '   <button class="car_item red" onclick="delete_car('+car.id+')">حذف</button>';
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

refresh();
function refresh(){
    check_cars();
    setTimeout(refresh, 4000);
}

function delete_car(id){
    var result = confirm("آیا مطمئن هستید که می‌خواهید ماشین را حذف کنید؟");
    if (result) {
        wait_alert();
        $.ajax({
            url: '/deletecar/'+id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                show_alert(response.color,response.message);
                if(response.color == "green"){
                    $('#car'+id).remove();
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