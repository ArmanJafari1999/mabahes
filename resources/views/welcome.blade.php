<?php
if(isset(Auth::user()->role)){
    if(Auth::user()->role == "admin"){
        header('Location: '.url('/manager'));
        die();
    }
}

?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>مکانیکی اهواز</title>
        @include('amh')
        <style>
            .main_outer_row{
                display: block;
                width: 100%;
                margin: 40px 0;
                box-shadow: 0px 0px 10px 10px #fff;
                background: #fff;
            }
            .welcome_text{
                display: block;
                width: 90%;
                padding: 10px 5%;
            }
            .car_logoes{
                display: flex;
                width: 100%;
            }
            .car_logoes_title{
                display: block;
                width: 100%;
                padding: 20px 0;
                margin: 0;
                text-align: center;
            }
            .car_logo_a{
                display: flex;
                width: 10%;
                margin: 10px auto;
                transition: background 0.3s;
                border-radius: 20px;
            }
            .car_logo_a:hover{
                background: skyblue;
            }
            .car_logo{
                display: block;
                max-width: 70%;
                max-height: 90%;
                margin: auto;
            }
        </style>            
    </head>
    <body>
        @include('amb')
        @include('tm')
            <?php
            $text = "به مکانیکی اهواز خوش آمدید";
            if(isset(Auth::user()->name)){
                $text .= " ".Auth::user()->name." عزیز";
            }
            ?>
            <div class="main_outer_row">
                <p class="welcome_text">{{$text}}</p>
                <p class="welcome_text">ما یک تیم مکانیک‌هایی هستیم که در زمینه تعمیرات خودروها و تجهیزات مکانیکی تخصص داریم. وظیفه ما شامل تشخیص خطاهای ماشین‌ها، تعمیر و نگهداری آنهاست. ما از تجربه و دانشی که در طول سال‌ها به دست آورده‌ایم، برای تشخیص و رفع مشکلات ماشین‌های مشتریان استفاده می‌کنیم.</p>
                <p class="welcome_text">معمولاً در یک کارگاه تعمیراتی مشغول به کار هستیم که به طور مناسبی طراحی شده است تا بتواند به آسانی ماشین‌های مختلف را پذیرفته و تعمیر کند. برای این منظور، از ابزارهای مکانیکی مختلفی استفاده می‌کنیم، از جمله دستگاه‌ها و وسایلی که برای تشخیص خطاهای ماشین‌ها استفاده می‌شوند. همچنین، به مشتریان خود نکاتی در مورد نگهداری و تعمیر درست ماشین‌هایشان می‌دهیم تا از آن‌ها بهتر مراقبت کنند و از آن‌ها بیشتر بهره ببرند.</p>
                <p class="welcome_text">با توجه به تجربه و تخصص خود، می‌توانیم هرگونه مشکلی که در ماشین‌های مشتریان پیش آمده را شناسایی و رفع کنیم. همچنین، با مشتریان خود مشورت می‌کنیم و به آن‌ها راه‌حل‌هایی برای ارتقای کیفیت و عمر مفید ماشین‌هایشان ارائه می‌دهیم.</p>
                <p class="welcome_text">در کل، به عنوان یک تیم مکانیک، با توجه به دانش و تجربه خود، می‌توانیم مشکلات ماشین‌های مشتریان را رفع کنیم و به آن‌ها راهنمایی‌هایی در مورد نگهداری و تعمیر درست ماشین‌هایشان ارائه دهیم.</p>
            </div>
            <div class="main_outer_row">
                <label class="car_logoes_title">تعمیر و نگهداری ماشین‌های شرکت‌های زیر</label>
                <div class="car_logoes">
                    <?php $car_logoes = glob('car_logoes/*.*'); ?>
                    <?php for($i=0;$i<count($car_logoes);$i++) : { ?>
                    <a class="car_logo_a" target="_blank" href="{{$car_logoes[$i]}}">
                        <img class="car_logo" src="{{$car_logoes[$i]}}">
                    </a>
                    <?php } endfor; ?>
                </div>
            </div>
        @include('f')
    </body>
</html>
