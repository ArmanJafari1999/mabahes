<!DOCTYPE html>
<html dir="rtl" lang="fa"><head>
    <title>نظرات درباره مکانیکی اهواز</title>
    <meta name="description" content="درباره مکانیکی اهواز نظر دهید و نظرات دیگران را بخوانید">
    @include('amh')
<style>
.new_comment {
    display: block;
    width: 80%;
    padding: 30px 5%;
    margin: 40px auto;
    background: #fff;
    border-radius: 50px;
    box-shadow: 0px 0px 10px 10px #fff;
}
    .new_comment textarea {
        display: block;
        width: 96%;
        height: 250px;
        padding: 10px 2%;
        border-radius: 30px;
        margin: 20px 0;
        background:#fff;
        color: #000;
    }
    .new_comment div {
        display: block;
        width: 100%;
        margin: 0px auto;
    }
    .new_comment input{
        display: inline-block;
        height: auto;
        border-radius: 30px;
        width: 30%;
        padding: 10px 1%;
        margin: 10px 0;
        background: #fff;
        color: #000;
    }

button {
    display: block;
    width: auto;
    margin: auto;
    border-radius: 60px;
    text-align: center;
    font-weight: bold;
    cursor: pointer;
    padding: 10px 100px;
    background: #eee;
}
button:hover{
    background: #FF8C00 ;
}
</style>
    <style>
    button , input , textarea{
        font-weight:bold;
    }
.row {
    display: block;
    width: 90%;
    padding: 30px 0px;
    margin: 50px auto 30px;
    padding: 10px 0;
    border-radius: 30px;
    background: #fff;
    box-shadow: 0px 0px 10px 10px #fff;
}
.row .message_row{
    display: block;
    width:100%;
}
.row .message_row .messages {
    display: block;
    width:100%;
}
.row .message_row .messages .message {
    display: flex;
    width: 90%;
    max-width: 90%;
}
.row .message_row .messages .left {
    margin: 10px auto 10px 10px;
    direction:ltr;
}
.row .message_row .messages .right {
    margin: 10px 10px 10px auto;
}
.left .text{
    border-radius: 0 30px 30px 30px;
    background:#b9b9b9;
}
.right .text{
    border-radius: 30px 0 30px 30px;
    background:#eee;
}
.left_t{
    display: inline-block;
    width: 0;
    height: 0;
    border-top: 0 solid transparent;
    border-right: 50px solid #b9b9b9;
    border-bottom: 35px solid transparent;
}
.right_t{
    display: inline-block;
    width: 0;
    height: 0;
    border-top: 0 solid transparent;
    border-left: 50px solid #eee;
    border-bottom: 35px solid transparent;
}
.row .message_row .messages .message .text {
    display: inline-block;
    margin: 0;
    padding: 20px;
}
.row .message_row .messages .message .text pre {
    display: inline-block;
    width: 100%;
    text-align:right;
    direction: rtl;
    font-weight: bold;
    margin: 0;
    white-space: break-spaces;
}
.row .message_row .messages .message .text .time {
    display: block;
    width: 100%;
    margin: 0;
    direction: ltr;
}
.row .message_row .messages .message .text .time p {
    display: inline-block;
    margin: 0;
    font-size: small;
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
    
    .comments_tittle_row{
        display: block;
        width: 100%;
        margin: 20px auto 10px;
        padding: 0;
        background: #fff;
        box-shadow: 0px 0px 30px 10px #fff;
    }

    .comments_tittle_row .explaine {
        box-shadow: inset 0px 0px 0px 3px #eee;
        padding: 15px 5%;
    }

</style>
</head>
<body>
    @include('amb')
    @include('tm')
    <div class="tittle_row">
        <p class="explaine">نظر خود را درباره مکانیکی اهواز بنویسید و نظر دیگران را بخوانید</p>
    </div>
    <form class="new_comment" id="new_comment">
        @csrf
        @if (Route::has('login'))
            @auth
        <input id="name" name="name" placeholder="نام و نام خانوادگی" type="text" value="{{Auth::user()->name}}">
        <input id="phone_number" name="phone_number" placeholder="شماره همراه" type="number" value="{{Auth::user()->phone_number}}">
        <input id="email" name="email" dir="ltr" style="width: 96%;padding: 10px 2%;" placeholder="ایمیل" type="text" value="{{Auth::user()->email}}">
            @else
        <input id="name" name="name" placeholder="نام و نام خانوادگی" type="text">
        <input id="phone_number" name="phone_number" placeholder="شماره همراه" type="number">
        <input id="email" name="email" dir="ltr" style="width: 96%;padding: 10px 2%;" placeholder="ایمیل" type="text">
            @endauth
        @endif
        <textarea id="comment" name="comment" rows="5" cols="60" placeholder="نظر خود را اینجا بنویسید"></textarea>
        <button title="ثبت نظر" type="submit">ثبت نظر</button>
    </form>

    <div class="comments_tittle_row" id="comments_tittle_row">
        <p class="explaine">نظرات</p>
    </div>
<div class="row">
    <div class="message_row" id="message_row"></div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">

function is_mail(m) {
    var for_check = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if (m.match(for_check)) {
        return true;
    } else {
        return false;
    }
}
function is_number(m) {
    for(var i=0;i<m.length;i++){
        if (m[i] > '9' || m[i] < '0') {
            return false;
        }
    return true;
    }
}
$(function () {
    $('#new_comment').submit(function (event) {
        event.preventDefault();
        wait_alert();
        var name = document.getElementById("name").value;
        var phone_number = document.getElementById("phone_number").value;
        var email = document.getElementById("email").value;
        var comment = document.getElementById("comment").value;

        if(name == "" || phone_number == "" || email == "" || comment == ""){
            show_alert("blue","تمام مقادیر را پر کنید");
        } else if(is_mail(email) == false){
            show_alert("blue","ایمیلتان را درست وارد کنید");
        } else if(is_number(phone_number) == false){
            show_alert("blue","شماره موبایلتان را درست وارد کنید");
        } else {
            $.ajax({
                url: "{{ route('addcomment') }}",
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    console.log(response);
                    document.getElementById("name").value = "";
                    document.getElementById("phone_number").value = "";
                    document.getElementById("email").value = "";
                    document.getElementById("comment").value = "";
                    show_alert(response.color,response.message);
                    if(response.color == "green"){
                        $('html, body').animate({scrollTop: $("#comments_tittle_row").offset().top}, 1000);
                    }
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

check_new_comments();
var cc = 0;
function check_new_comments(){
    $.get('/getallcomments', function(data) {
        if(cc != data.length){
            var for_show = "";
            for (var i = data.length-1; i >= 0 ; i--) {
                var comment = data[i];
                for_show += '<div class="messages">';
                for_show += '   <div class="message right">';
                for_show += '       <div style="direction:ltr;display:flex;">';
                for_show += '           <div class="text">';
                for_show += '               <pre>'+data[i].comment+'</pre>';
                for_show += '               <div class="time">';
                for_show += '                   <p>'+set_date(data[i].created_at)+'</p>';
                for_show += '               </div>';
                for_show += '           </div>';
                for_show += '           <div class="right_t"></div>';
                for_show += '       </div>';
                for_show += '   </div>';
                for_show += '</div>';
            }
            document.getElementById("message_row").innerHTML = for_show;
            }
        cc = data.length;
    });
    setTimeout(check_new_comments, 4000);
}

</script>


</body>
</html>