<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>درباره مکانیکی اهواز</title>
        <!-- Styles -->
        @include('amh')
        <style>
            .explane_row{
                display: block;
                margin: 50px auto;
                padding: 0;
                width: 90%;
                border: solid #eee;
                border-radius: 30px;
                background: #fff;
            }
            .explane_title{
                display: inline-block;
                width: 95%;
                padding: 10px 2.5%;
                margin: 0;
                border-bottom: solid #eee;
            }
            .explane{
                display: inline-block;
                width: 90%;
                padding: 10px 5%;
                margin: 0;
            }
        </style>        
    </head>
    <body>
    @include('amb')
    @include('tm')
        <div class="explane_row">
            <p class="explane_title">درباره مکانیکی اهواز</p>
            <p class="explane">این مکانیکی، یک کارگردان خلاق، دارای تجربه و مهارت در تعمیر ماشین‌های خودرو و فعالیت در این زمینه است. با توجه به تخصص و تجربه ما در این زمینه، ما می‌توانیم مشکلات فنی در ماشین‌های شما را با دقت و تخصص بررسی و حل کنیم</p>
        </div>
        <div class="explane_row">
            <p class="explane_title">سابقه</p>
            <p class="explane">ما با توجه به سابقه کاری و تخصص خود، می‌توانیم در کوتاه‌ترین زمان ممکن به مشتریان خود کمک کنیم تا مشکلات فنی در ماشین‌هایشان را برطرف کنیم. همچنین، با استفاده از ابزار و تجهیزات مدرن، می‌توانیم ماشین‌های مشتریان را برای عملکرد بهینه بهبود دهیم</p>
        </div>
        <div class="explane_row">
            <p class="explane_title">تضمین</p>
            <p class="explane">این مکانیکی، همچنین در تعمیر و نگهداری ماشین‌های خودرو و تجهیزات مربوط به آن‌ها مهارت دارد. ما با استفاده از تجربه خود و آشنایی با تکنولوژی مدرن، می‌توانیم ماشین‌های مشتریان را تعمیر کنیم و به بهترین شکل ممکن نگهداری کنیم</p>
        </div>
        <div class="explane_row">
            <p class="explane_title">تصمیم گیری</p>
            <p class="explane">علاوه بر این، این مکانیکی دارای شخصیتی دوستانه و مهربان است که با مشتریان خود بسیار صمیمی و دوستانه رفتار می‌کند. ما به مشتریان خود کمک می‌کنیم تا بهترین تصمیم را درباره تعمیر و نگهداری ماشین‌هایشان بگیرند و همیشه در خدمتشان هستیم</p>
        </div>
        <div class="explane_row">
            <p class="explane_title">خطم کلام</p>
            <p class="explane">در کل، این مکانیکی به عنوان یک کارگردان خلاق و دارای تجربه، با استفاده از تخصص خود در تعمیر و نگهداری ماشین‌های خودرو، به مشتریان خود کمک می‌کند تا ماشین‌هایشان را به بهترین شکل ممکن نگهداری کنند. با شخصیت دوستانه و مهربان خود، ما به مشتریان خود اعتماد و اطمینان می‌دهیم که ماشین‌هایشان در دستان قابل اعتمادی هستند</p>
        </div>
    @include('f')
    </body>
</html>
