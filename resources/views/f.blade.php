<style>
    .footer{
        width: 100%;
        background: #e1e1e1;
        box-shadow: 0px -20px 10px 10px #e1e1e1;
        margin: 50px 0 0 0;
        padding: 0 0 50px;
    }
    .footer .inner_footer{
        display: block;
        margin: 10px auto;
        width: 30%;
    }
    .footer .inner_footer .footer_tittle{
        display: inline-block;
        width: 95%;
        margin: 0 2.5%;
        padding: 5px 0;
    }
    .footer .inner_footer .footer_social_media .singel_test{
        display: block;
        text-align: center;
        margin: 10px auto;
    }
    .footer .inner_footer .footer_social_media{
        display: flex;
        width: 95%;
        padding: 0 2.5%;
        box-shadow: 0px 0px 0px 2px #ffffffab;
        border-radius: 10px;
        margin: 0 0 10px 0;
        transition: background 0.5s;
    }
    .footer .inner_footer .footer_social_media:hover{
        background: #ffffff;
    }
    .footer .inner_footer .footer_social_media .footer_social_media_logo{
        display: flex;
        width: 15%;
        padding: 0;
    }
    .footer .inner_footer .footer_social_media .footer_social_media_logo .footer_social_media_logo_image{
        display: block;
        max-width: 90%;
        max-height: 90%;
        padding: 0;
        margin: auto;
    }
    .footer .inner_footer .footer_social_media .social_media_name{
        display: flex;
        width: 25%;
        padding: 0;
        text-align: center;
    }
    .footer .inner_footer .footer_social_media .social_media_name p{
        display: block;
        margin: auto 5% auto auto;
        max-width: 100%;
        line-break: anywhere;
    }
    .footer .inner_footer .footer_social_media .social_media_info{
        display: flex;
        width: 60%;
        padding: 0;
        text-align: center;
    }
    .footer .inner_footer .footer_social_media .social_media_info p{
        display: block;
        margin: auto 5% auto auto;
        max-width: 100%;
        line-break: anywhere;
    }
    .footer .inner_footer .footer_explain{
        display: flex;
        width: 95%;
        padding: 0 2.5%;
    }
</style>
<div class="footer flex">
    <div class="inner_footer">
        <p class="footer_tittle">راه‌های ارتباطی</p>
        <hr>
        <a class="footer_social_media" href="tel:09051263424" target="blank">
            <div class="footer_social_media_logo">
                <img class="footer_social_media_logo_image" src="social_media_logo/call.png" tittle="call" alt="call">
            </div>
            <div class="social_media_name"><p>تماس</p></div>
            <div class="social_media_info"><p>09051263424</p></div>
        </a>
        <a class="footer_social_media" href="https://api.whatsapp.com/send?phone=989051263424" target="blank">
            <div class="footer_social_media_logo">
                <img class="footer_social_media_logo_image" src="social_media_logo/whatsapp.png" tittle="whatsapp" alt="whatsapp">
            </div>
            <div class="social_media_name"><p>واتساپ</p></div>
            <div class="social_media_info"><p>09051263424</p></div>
        </a>
        <a class="footer_social_media" href="mailto:jafari.arman1999@gmail.com" target="blank">
            <div class="footer_social_media_logo">
                <img class="footer_social_media_logo_image" src="social_media_logo/mail.png" tittle="mail" alt="mail">
            </div>
            <div class="social_media_name"><p>ایمیل</p></div>
            <div class="social_media_info"><p>jafari.arman1999@gmail.com</p></div>
        </a>
    </div>
    <div class="inner_footer">
        <p class="footer_tittle">درباره مکانیکی اهواز</p>
        <hr>
        <pre class="footer_explain">ما یک تیم مکانیک‌هایی هستیم که در زمینه تعمیرات خودروها و تجهیزات مکانیکی تخصص داریم. وظیفه ما شامل تشخیص خطاهای ماشین‌ها، تعمیر و نگهداری آنهاست. ما از تجربه و دانشی که در طول سال‌ها به دست آورده‌ایم، برای تشخیص و رفع مشکلات ماشین‌های مشتریان استفاده می‌کنیم</pre>
    </div>
    <div class="inner_footer">
        <p class="footer_tittle">لینک‌های مربوط</p>
        <hr>
        <a class="footer_social_media" href="https://www.instagram.com/arman_jafari_1999/" target="blank">
            <div class="footer_social_media_logo">
                <img class="footer_social_media_logo_image" src="social_media_logo/instagram.png" tittle="instagram" alt="instagram">
            </div>
            <div class="social_media_name"><p>اینستاگرام</p></div>
            <div class="social_media_info"><p>arman_jafari_1999</p></div>
        </a>
        <a class="footer_social_media" href="https://t.me/lighter_star" target="blank">
            <div class="footer_social_media_logo">
                <img class="footer_social_media_logo_image" src="social_media_logo/telegram.png" tittle="telegram" alt="telegram">
            </div>
            <div class="social_media_name"><p>کانال تلگرام</p></div>
            <div class="social_media_info"><p>lighter_star</p></div>
        </a>
            @if (Route::has('login'))
                    @auth
                    <a class="footer_social_media" href="{{ url('/dashboard') }}"><p class="singel_test">میزکار</p></a>
                    @else
                        <a class="footer_social_media" href="{{ route('login') }}"><p class="singel_test">ورود به حساب/ثبت نام در سایت</p></a>
                    @endauth
            @endif
    </div>
    
</div>