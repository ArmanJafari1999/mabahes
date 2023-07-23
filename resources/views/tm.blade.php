<style>
            .top_image{
                display: block;
                width: 100%;
                margin: 0;
            }
            .top_menu{
                background: #fff;
                display: flex;
                width: 100%;
                padding: 0;
                margin: 0 0 10px 0;
                box-shadow: 0px 0px 10px 10px #fff;
            }
            .top_menu_item{
                display: inline-block;
                padding: 5px 10px;
                margin: 0 10px;
                text-decoration: none;
                border-radius: 100px;
            }
            .top_menu_item:hover{
                background: skyblue;
            }
        </style>
        <img class="top_image" src="top_image.jpg">
            @if (Route::has('login'))
                <div class="top_menu">
                    <a class="top_menu_item" href="{{ url('/') }}">صفحه اصلی</a>
                    @auth
                    <a class="top_menu_item" href="{{ url('/dashboard') }}">میزکار</a>
                    @if(Auth::user()->role != "admin")
                        <a class="top_menu_item" href="{{ url('/my_visits') }}">ویزیت‌های شما</a>
                        <a class="top_menu_item" href="{{ url('/my_cars') }}">ماشین‌های شما</a>
                        <a class="top_menu_item" href="{{ url('/visits') }}">گرفتن وقت ویزیت</a>
                    @endif
                    @else
                        <a class="top_menu_item" href="{{ route('login') }}">ورود به حساب</a>
                        @if (Route::has('register'))
                            <a class="top_menu_item" href="{{ route('register') }}">ثبت نام</a>
                        @endif
                    @endauth
                    <a class="top_menu_item" href="{{ url('/about_us') }}">درباره ما</a>
                    <a class="top_menu_item" href="{{ url('/comments') }}">نظرات مشتریان</a>
                </div>
            @endif
