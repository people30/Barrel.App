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

        <!-- 蔵詳細専用css -->
        <link rel="stylesheet" href="{{ asset('../../css/jquery.bxslider_kura.css') }}">
        <link rel="stylesheet" href="{{ asset('../../css/jquery.fancybox.min.css') }}">
        <link rel="stylesheet" href="{{ asset('../../css/brewer_details_page.css') }}">

        <!-- ファビコン -->
        <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/vnd.microsoft.icon">
        <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/vnd.microsoft.icon">

    <title>ぐびっと:{{$brewer->name}}</title>
</head>

<body onload="initialize()">
        <!-- ヘッダー -->
        <div class="sticky">
                <header class="header_area">
                    <!-- ヘッダーロゴ -->
                    <h1 class="header_logo pagetop">
                        <a href="{{ route('RegionalityPage') }}/"><img src="{{ asset('/img/logo.40x40.jpg') }}" width="40" height="40" alt="ぐびっと:徳島の地酒と酒蔵"></a>
                    </h1>
                    <!-- ／ヘッダーロゴ -->
                    <!-- トグルボタン -->
                    <button class="header_btn" onclick="navFunc()">
                        <span><img src="{{ asset('/svg/hamburger_menu02.svg') }}" width="40" height="40" alt="" class="fa-times"></span>
                        <span><img src="{{ asset('/svg/hamburger_menu01.svg') }}" width="40" height="40" alt="" class="fa-bars"></span>
                    </button>
                    <!-- ／トグルボタン -->
                    <!-- メニュー -->
                    <!-- 現在のページは li にクラス selected を指定して表します -->
                    <div class="header_menu">
                        <ul class="header_list">
                            <li><a href="{{ route('RegionalityPage') }}/#regionality">徳島の風土と日本酒</a></li>
                            <li class="selected"><a href="{{ route('SakesPage') }}/">徳島の地酒</a></li>
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
        <div class="content_fluid"></div>

        <article class="content">
            <!-- 蔵の写真、基本情報 -->
            <section>
                <h1 class="header_text">{{ $brewer->name }}</h1>
                <section class="kura_info">
                    <div class="main_image">
                        <img src="{{$brewer->KeyVisual->files['780x520']->url}}" 
                srcset="{{$brewer->KeyVisual->files['780x520']->url}} 780w, 
                        {{$brewer->KeyVisual->files['580x384']->url}} 580w, 
                        {{$brewer->KeyVisual->files['320x240']->url}} 320w">
                    </div>
                    <article class="about_kura">
                        <ul>
                            <li class="about_kura_outline">
                               {{ $brewer->text }}
                            </li>
                            <li class="about_kura_kengaku">
                                <p>{{$brewer->isBackstageSeeable}}</p>
                                <p class="available">{{$brewer->isBackstageSeeable}}</p>
                            </li>

                            <li class="about_kura_open">
                                <table>
                                    <tr>
                                        <th>営業時間</th>
                                        <td>
                                            {{ $brewer->openingTime }} - {{ $brewer->closingTime }}
                                            <br>{{ $brewer->businessDay}}
                                        </td>
                                    </tr>
                                </table>
                            </li>

                            <li class="about_kura_url">
                            <a href="{{ $brewer->link->url }}">
                                    {{ $brewer->link->url }}</a>
                            </li>
                        </ul>
                    </article>
                </section>

                <div class="sub_image slider">
                    @for ($i = 0; $i < 4; $i++)
                    <div>
                    <a class="full_scr" href="{{ asset('../../img/$brewer->slug->random().jpg') }}" data-fancybox>
                        <img src="{{$brewer->KeyVisual->files['780x520']->url}}" 
                srcset="{{$brewer->KeyVisual->files['380x252']->url}} 380w, 
                        {{$brewer->KeyVisual->files['280x184']->url}} 280w, 
                        {{$brewer->KeyVisual->files['320x240']->url}} 280w"></a>
                    </div>
                    @endfor

                </div>
            </section>
            <!--／ 蔵の写真、基本情報 -->

            <!-- その蔵や製造品に関する記事、詳細情報 -->
            <section class="kura_details">
                <article>
                    <h2 class="title_text">読みもの</h2>
                    <div class="kura_stories">
                        <!-- ブログ記事 リスト -->
                        <ul>
                            @for ($i = 0; $i < 3; $i++)
                              <!-- ブログ記事 一件 -->
                            <li>
                                <div class="blog_head">
                                    <div class="category">
                                    <a href="{{ env('WP_URL')}}">{{ $stories->article->categories->name }}</a>
                                    </div>
                                    <div>
                                        <h3>
                                            <a class="subtitle_text story_title" href="{{ env }}">{{ $stories->article->title }}</a>
                                        </h3>
                                    </div>
                                </div>
                                <p>
                                    {{ $stories->$article->text }}
                                </p>
                            </li>
                            <!-- ／ブログ記事 一件-->
                            @endfor
 
                        </ul>
                        <!-- ブログ記事 リスト -->

                    </div>
                </article>

                <article class="company_gaiyou">
                    <h2 class="title_text">会社概要</h2>

                    <table>
                        <tbody>
                            <tr>
                                <th>蔵名</th>
                                <td>{{ $brewer->name }}</td>
                            </tr>
                            <tr>
                                <th>代表者名</th>
                                <td>{{ $brewer->owner}}</td>
                            </tr>
                            <tr>
                                <th>杜氏</th>
                            <td>{{ $brewer->toji }}</td>
                            </tr>
                            <tr>
                                <th>営業日</th>
                                <td>{{ $brewer->businessDay}}</td>
                            </tr>
                            <tr>
                                <th>営業時間</th>
                            <td>{{ $brewer->openingTime }}～{{ $brewer->closingTime }}</td>
                            </tr>
                            <tr>
                                <th>TEL</th>
                            <td>{{ $brewer->phoneNumber }}}</td>
                            </tr>
                            <tr>
                                <th>FAX</th>
                            <td>{{ $brewer->faxNumber }}</td>
                            </tr>
                            <tr>
                                <th>E-mail</th>
                            <td>{{ $brewer->email }}</td>
                            </tr>
                            <tr>
                                <th>URL</th>
                                <td>
                                    <a class="gaiyou_url" href="{{ $brewer->link->url }}">{{ $brewer->link->url }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>住所</th>
                                <td>{{ $brewer->address }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div id="map_canvas"></div>
                </article>
            </section>

            <!--／ その蔵や製造品に関する記事、詳細情報 -->
            <!-- 製造品一覧 -->
            <section class="products">
                <h1 class="title_text">代表柄</h1>
                <div class="items">
                    @for ($i = 0; $i < 3; $i++)
                    <!-- カード -->
                        <div class="item_card">
                                <div class="spec">
                                    <img src="{{ asset('../../svg/bin.svg') }}" alt="酒瓶の画像">
                                    <ul class="products_info">
                                        <li class="caption_text tokutei_meishou">
                                            {{ $sake->designation }}
                                        </li>
                                        <li class="caption_text taste">
                                            {{ $sake->tastes }}
                                        </li>
                                        <li class="meigara">{{ $sake->name }}</li>
        
                                        <li class="product_alc">
                                            <div class="grid_item">
                                                <img src="{{ asset('../../svg/al20.svg') }}" alt="">
                                            </div>
                                            <ul>
                                            <li>{{ $sake->alcoholicity * 100 }}%</li>
                                                <li>アルコール度</li>
                                            </ul>
                                        </li>
                                        <li class="product_seimai">
                                            <div class="grid_item">
                                                <img src="{{ asset('../../svg/seimai40.svg') }}" alt="">
                                            </div>
                                            <ul>
                                                <li>{{ $sake->ricePollishingRatio * 100 }}%</li>
                                                <li>精米歩合</li>
                                            </ul>
                                        </li>
                                        <li class="rice">
                                            <ul>
                                                <li>原料米</li>
                                                <li>{{ $sake->rawRice }}</li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <p class="product_point">
                                        {{ $sake->text }}
                                </p>
                                <table class="price_list">
                                    <tbody>
                                        @foreach ($sake->saizes as $size)
                                        <tr>
                                            <th class=" caption_text">{{ $sake->size->content}}ml</th>
                                            <td class="price">{{ $sake->size->price }}円</td>
                                            <td class="tax caption_text">（税抜）</td>
                                        </tr>      
                                        @endforeach
                                    </tbody>
                                </table>
                        </div>
                    <!-- ／カード -->
                    @endfor
            </section>

            <!-- ／ 製造品一覧 -->
        </article>
    </main>
    <!-- ／メインエリア -->

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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
    <!-- スクリプト -->
    <script src="{{ asset('../../js/base.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

    <script>
        $(document).ready(function () {
            var settings = function () {
                var settings1 = {
                    moveSlides: 1,
                    maxSlides: 3,
                    minSlides: 2,
                    touchEnabled: true,
                    slideWidth: 380,
                    slideMargin: 20,
                    pager: false
                };
                var settings2 = {
                    moveSlides: 1,
                    maxSlides: 2,
                    minSlides: 2,
                    touchEnabled: true,
                    slideWidth: 280,
                    slideMargin: 20,
                    pager: false
                };

                var settings3 = {
                    moveSlides: 1,
                    maxSlides: 2,
                    minSlides: 2,
                    touchEnabled: true,
                    slideWidth: 280,
                    slideMargin: 20,
                    pager: true,
                    controls: false,
                    auto: true
                };

                return $(window).width() > 1240 ?
                    settings1 :
                    settings2 && $(window).width() > 800 ?
                    settings2 :
                    settings3;
            };

            var mySlider;

            function slideSetting() {
                mySlider.reloadSlider(settings());
            }

            mySlider = $(".slider").bxSlider(settings());
            $(window).resize(slideSetting);
        });

    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMUsphC2nSkQJ6Gq240PD0MyAt0EXSbJ4&callback=initMap"
        type="text/javascript"></script>
    <script type="text/javascript">
        var map;
        var marker_ary = new Array();
        var currentInfoWindow;

        function initialize() {
            var latlng = new google.maps.LatLng(34.078547, 134.523913);
            var myOptions = {
                zoom: 10,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(
                document.getElementById("map_canvas"),
                myOptions
            );

            // //イベント登録　地図の表示領域が変更されたらイベントを発生させる
            // google.maps.event.addListener(map, 'idle', function(){
            //     setPointMarker();
            // });
        }

    </script>
    <script type="text/javascript" src="{{ asset('../../js/jquery.fancybox.min.js') }}"></script>
    <script type="text/javascript">
        fullScreen(function ($) {
            $(".full_scr").attr('rel', 'group').fancybox();
        });
        $('[data-fancybox]').fancybox({
            // オプションはここに書きます
            hideOnOverlayClick: true,
            protect: true, //右クリック抑止
        });

    </script>


</body>

</html>
