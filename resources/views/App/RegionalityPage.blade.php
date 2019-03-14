<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- サイト説明 -->
        <meta property="og:description" content="">
        <!-- googleフォント -->
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP" rel="stylesheet">
        <!-- fontawesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <!-- ベースcss -->
        <link rel="stylesheet" href="{{ asset('/css/base.css') }}">
        <!-- ファビコン -->
        <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/vnd.microsoft.icon">
        <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/vnd.microsoft.icon">
        <!-- jQuery -->
        <script src="{{ asset('/js/jquery-3.3.1.min.js') }}"></script>
        <!-- ベーススクリプト -->
        <script src="{{ asset('/js/base.js') }}"></script>
        <title>ぐびっと:徳島の地酒と酒蔵</title>

        <!--メインCSSリンク-->
        <link rel="stylesheet" href="{{ asset('/css/regionality_page.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/jquery.bxslider.css') }}">


</head>
<body>

    <section class="key_visual">
        <!--キービジュアル-->
        <div class="slider">
            @foreach($allBrewers as $brewer)
            @if($brewer->keyVisual !== null )
        <div><a href="{{ route('BrewerDetailsPage', ['slug' => $brewer->slug]) }}/"><img src="{{ $brewer->keyVisual->files['1920x1080']->url }}"></a></div>
            @endif
            @endforeach
        </div>
        <section class="first_menu">
            <div class="key_visual_content">
                <div class="menu">
                    <div><img class="top_logo" src="{{ asset('/img/site_logo.jpg') }}"></div>
                    <ul>
                        <li class="selected"><a href="{{ route('RegionalityPage') }}/#regionality">徳島の風土と日本酒</a></li>
                        <li><a href="{{ route('SakesPage') }}/">徳島の地酒</a></li>
                        <li><a href="{{ route('BrewersPage') }}/">徳島の酒蔵</a></li>
                        <li><a href="{{ env('WP_URL') }}">読みもの</a></li>
                    </ul>
                    {{-- <ul class="brewer_info">
                        <li>
                            <p class="caption_text">徳島市</p>
                        </li>
                        <li><a href="{{ route('BrewerDetailsPage',['slug'=>$brewer->slug]) }}">{{ $brewers }}</a></li>
                    </ul> --}}
                </div>
            </div>
        </section>
    </section>
    <!-- ヘッダー -->
    <div class="sticky top_sticky">
        <header class="header_area">
            <!-- ヘッダーロゴ -->
            <h1 class="header_logo pagetop">
                <a href="{{ route('RegionalityPage') }}/"><img src="{{ asset('/img/logo.40x40.jpg') }}" alt="ぐびっと:徳島の地酒と酒蔵"></a>
            </h1>
            <!-- ／ヘッダーロゴ -->
            <!-- トグルボタン -->
            <button class="header_btn" onclick="navFunc()">
                <span><img src="{{ asset('/svg/hamburger_menu02.svg') }}" alt="" class="fa-times"></span>
                <span><img src="{{ asset('/svg/hamburger_menu01.svg') }}" alt="" class="fa-bars"></span>
            </button>
            <!-- ／トグルボタン -->
            <!-- メニュー -->
            <!-- 現在のページは li にクラス selected を指定して表します -->
            <div class="header_menu">
                <ul class="header_list">
                    <li class="selected"><a href="{{ route('RegionalityPage') }}/#regionality">徳島の風土と日本酒</a></li>
                    <li><a href="{{ route('SakesPage') }}/">徳島の地酒</a></li>
                    <li><a href="{{ route('BrewersPage') }}/">徳島の酒蔵</a></li>
                    <li><a href="{{ env('WP_URL') }}">読みもの</a></li>
                </ul>
            </div>
            <!-- ／メニュー -->
        </header>
    </div>
    <!-- ／ヘッダー -->
    <!-- ################################################################### -->
    <!-- メインエリア -->
    <main class="main_area">
    <!--/キービジュアル navi-->

    <article class="content" id="regionality">
        <!--contents01-->
        <section class="box01">
            <div class="logos">
                <div class="title_box">
                    <h1 class="title_text">徳島の風土と日本酒</h1>
                </div>
                <div><img class="title_logo02" src="{{ asset('/svg/textlogo_05.svg') }}"></div>
            </div>
            <div class="contents01">
                <ul class="text_logo">
                    <li>
                        <div class="poem">
                            <div><img src="{{ asset('/svg/navylogo01.svg') }}"></div>
                            <div class="text_box">
                                <p class="poem_title">県土で生まれた味わい</p>
                                <p>徳島の風土と蔵元それぞれの持つ伝統、日々の営みが響きあい、大人が楽しめる豊かな味が作り出されています。このサイトでは、徳島での酒蔵の活動と想いを紹介します。</p>
                            </div>
                        </div>
                    <li>
                        <div class="poem">
                            <div><img src="{{ asset('/svg/navylogo02.svg') }}"></div>
                            <div class="text_box">
                                <p class="poem_title">豊かな自然に育まれた「お米」</p>
                                <p>徳島県の醸造に使われるお米は、「山田錦」や「美山錦」などの全国的にも有名な酒造好適米をはじめ、その地域独自の酒米など多種多様なものがあります。</p>
                            </div>
                        </div>
                    <li>
                        <div class="poem">
                            <div><img src="{{ asset('/svg/navylogo03.svg') }}"></div>
                            <div class="text_box">
                                <p class="poem_title">「清流」の収束する吉野川</p>
                                <p>そして、お米同様に重要な「水」にも恵まれています。徳島県では、剣山山系や讃岐山脈からの伏流水が豊富な水源となり、酒造りに好んで使われています。そのため、吉野川などの河川沿いに多くの蔵元が存在しております。</p>
                            </div>
                        </div>
                    <li>
                        <div class="poem">
                            <div><img src="{{ asset('/svg/navylogo04.svg') }}"></div>
                            <div class="text_box">
                                <p class="poem_title">判断と、試行錯誤の日々</p>
                                <p>一見、このように生産資源に恵まれた徳島県ですが、自然すべてが味方というわけではありません。醸造には通常、十分な寒さが必要ですが、徳島県は温暖な地域なので温度管理に徹底した醸造が行われています。そこには日々、上質な徳島酒を生み出すために気候環境と戦う職人たちの試行錯誤重ねられています。</p>
                            </div>
                        </div>
                </ul>
            </div>
        </section>
        <!--/contents01-->

        <!--contents02-->
        <section class="box02">
            <div class="logos">
                <div class="title_box">
                    <h1 class="title_text">Instagramギャラリー</h1>
                </div>
                <div><img class="title_logo02" src="{{ asset('/svg/textlogo_05.svg') }}"></div>
            </div>
            <div class="contents02">
                <div class="photo_box">
                    <a href="https://www.instagram.com/gubittotokushima/?utm_source=ig_embed&amp;utm_medium=loading">
                        <img class="photo01" src="{{ asset('/img/photo01.jpg') }}" alt="">
                    </a>
                    <a href="https://www.instagram.com/p/BuaGKEYg6mg/?utm_source=ig_embed&amp;utm_medium=loading">
                        <img class="photo02" src="{{ asset('/img/photo02.jpg') }}" alt="">
                    </a>
                    <a href="https://www.instagram.com/p/BuaGKEYg6mg/?utm_source=ig_embed&amp;utm_medium=loading">
                        <img class="photo03" src="{{ asset('/img/photo03.jpg') }}" alt="">
                    </a>
                    <a href="https://www.instagram.com/p/BuaGKEYg6mg/?utm_source=ig_embed&amp;utm_medium=loading">
                        <img class="photo04" src="{{ asset('/img/photo04.jpg') }}" alt="">
                    </a>
                </div>
                <div class="photo_back"></div>
                <a href="https://www.instagram.com/p/BuaGKEYg6mg/?utm_source=ig_embed&amp;utm_medium=loading">
                    <img class="insta_icon" src="{{ asset('/svg/Insta_icon.svg') }}">
                </a>
            </div>
        </section>
        <!--/contents02-->
           <!-- バナー画像 -->
    <div class="banner">
        <div class="banner_pc">
            <img src="{{ asset('/img/bn-awanavi01.gif') }}" alt="">
            <img src="{{ asset('/img/bn-syuzo01.jpg') }}" alt="">
        </div>
        <div class="banner_sm">
            <img src="{{ asset('/img/bn-awanavi02.gif') }}" alt="">
            <img src="{{ asset('/img/bn-syuzo02.jpg') }}" alt="">
        </div>
    </div>
    <!-- ／バナー画像 -->
    </article>

    </main>
    <!-- ／メインエリア -->
<!-- ################################################################### -->
        <!-- フッター外枠 -->
        <footer class="footer_area">
            <!-- フッター内枠 -->
            <div class="footer_list">
                <!-- 酒倉タイトル -->
                <div class="footer_brewery_title">徳島の酒蔵</div>
                <!-- ／酒蔵タイトル -->
                <!-- 酒蔵リストサンプル 酒蔵名はかわります。 -->
                <div class="footer_brewery caption_text">
                    <ul>
                        @foreach($allBrewers as $brewer)
                        <li><a href="{{ route('BrewerDetailsPage', ['slug' => $brewer->slug]) }}">{{ $brewer->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <!-- ／酒蔵リスト -->
                <!-- フッターリンクメニュー -->
                <div class="footer_menu subtitle_text">
                    <ul>
                        <li><a href="{{ route('RegionalityPage') }}/#regionality">徳島の風土と日本酒</a></li>
                        <li><a href="{{ route('SakesPage') }}/">徳島の地酒</a></li>
                        <li><a href="{{ route('BrewersPage') }}/">徳島の酒蔵</a></li>
                        <li><a href="{{ env('WP_URL') }}">読みもの</a></li>
                    </ul>
                </div>
                <!-- ／フッターリンクメニュー -->
                <!-- SNS -->
                <div class="sns header_text">
                    <a href="#" class="fab fa-facebook"><span class="sr-only">Facebook</span></a>
                    <a href="#" class="fab fa-twitter"><span class="sr-only">Twitter</span></a>
                    <a href="#" class="fab fa-instagram"><span class="sr-only">instagram</span></a>
                </div>
                <!-- ／SNS -->
                <!-- 注意書き-->
                <div class="footer_note caption_text">
                    <p>お酒は20歳になってから、未成年及び年齢確認のできない方へのお酒の販売は法律で禁止されています。<br>
                        妊娠中や授乳期の飲酒は、胎児、乳児の発育に悪影響を与える恐れがあります。<br>
                        お酒は楽しく、ほどほどに、飲んだ後はリサイクル。</p>
                </div>
                <!-- ／注意書き -->
                <!-- コピーライト-->
                <div class="copyright">
                    <small class="caption_text">Copyright ©2019 Project Barrel</small>
                </div>
                <!-- ／コピーライト -->
            </div>
            <!-- ／フッター内枠 -->
        </footer>
        <!-- ／フッター外枠 -->

    <!--キービジュアル-->
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.slider').bxSlider({
                auto: true,
                mode: 'fade',
                maxSlide: 1,
                randomStart: true,
                pager: false,
                controls: false,
            })
        })

    </script>


</body>

</html>
