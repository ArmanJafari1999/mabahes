<?php
if(Auth::user()->role != "admin"){
    header('Location: '.url('/'));
    die();
}
?>
<!DOCTYPE html>
<html dir="rtl" lang="fa"><head>
    <title>ملاقات‌های کاربران</title>
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
        width: 25%;
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
    .person{
        display: inline-block;
        width: 23%;
        padding: 5px 0;
        margin: 10px 1.6% 10px 0;
        text-align: center;
        background: #eee;
        cursor: pointer;
        border-radius: 30px;
    }
    .person:hover{
        background: skyblue;
    }
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
    <div class="tittle_row">
        <p class="explaine">در اینجا اطلاعات ماشین‌تان را وارد کنید</p>
    </div>
    <form class="new_car" id="search_user">
        @csrf
        <input id="name" name="name" placeholder="نام" type="text">
        <input id="phone_number" name="phone_number" placeholder="شماره موبایل" type="number">
        <input id="email" name="email" placeholder="ایمیل" type="text">
        <button type="submit">جست و جو</button>
    </form>
    <div class="row">
        <div class="cars_row" id="persons_row"></div>
    </div>
    <div class="visit"><p class="visit_item" id="all_price"></p></div>
    <div id="visits_row"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">

var uc = 0;
$(function () {
    $('#search_user').submit(function (event) {
        event.preventDefault();
        wait_alert();
        $.ajax({
            url: '/findusers',
            type: 'POST',
            data: {
                name: document.getElementById("name").value,
                phone_number: document.getElementById("phone_number").value,
                email: document.getElementById("email").value,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response);
                if(uc != response.length){
                    var for_show = "";
                    for (var i = response.length-1; i >= 0 ; i--) {
                        var user = response[i];
                        for_show += '<div class="person" id="p'+user.id+'" onclick="get_visits('+user.id+')">'+user.name+'</div>';
                    }
                    document.getElementById("persons_row").innerHTML = for_show;
                }
                uc = response.length;
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });
});

function get_visits(id){
    $.ajax({
        url: '/getuservisits',
        type: 'POST',
        data: {
            id: id,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            var for_show = "";
            var all_price = 0;
            var orders = response;
            for (var i = orders.length-1; i >= 0 ; i--) {
                var v = orders[i];
                for_show += '<a class="visit" href="<?php echo url('/manage_visit?id='); ?>'+v.id+'">';
                for_show += '   <p class="visit_item" style="direction: ltr;">'+v.time_for_visit+'</p>';
                for_show += '   <p class="visit_item">هزینه: '+format_number(v.price)+' تومان</p>';
                for_show += '   <p class="visit_item">زمان تحویل ماشین: '+v.time_for_take_car+'</p>';
                for_show += '   <p class="visit_item">'+v.c_model+'</p>';
                for_show += '   <pre class="visit_item">'+v.problem+'</pre>';
                for_show += '</a>';
                all_price += v.price;
            }
            document.getElementById("visits_row").innerHTML = for_show;
            document.getElementById("all_price").innerHTML = document.getElementById("p"+id).innerHTML+" تا کنون "+format_number(all_price)+" تومان در سایت هزینه کرده است";
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

</script>

</body>
</html>