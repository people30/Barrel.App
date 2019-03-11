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
        <!-- brewerscss -->
        <link rel="stylesheet" href="{{ asset('/css/brewers_page.css') }}">
        <!-- ファビコン -->
        <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/vnd.microsoft.icon">
        <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/vnd.microsoft.icon">
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMUsphC2nSkQJ6Gq240PD0MyAt0EXSbJ4&callback=initMap"></script>
        <script type="text/javascript" src="{{ asset('/js/brewers_page_script.js') }}"></script>
        <!-- ベーススクリプト -->
        <script src="{{ asset('js/base.js') }}"></script>
        <title>ぐびっと:徳島の酒蔵</title>

    </head>

    <body data-brewers="{{ json_encode($brewers) }}">
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
                        <li><a href="{{ route('SakesPage') }}/">徳島の地酒</a></li>
                        <li class="selected"><a href="{{ route('BrewersPage') }}/">徳島の酒蔵</a></li>
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
            <!-- 地図コンテンツ -->
            <div class="content_fluid">
                <h1>徳島の酒蔵</h1>
                <div class="map">
                    <div id="map_canvas" style="width:100%; height:400px"></div>
                    <div id="pointlist" style="width:20em;float:left;">
                        <ul>
                            <li>地点リスト</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- ／地図コンテンツ -->
            <!-- 記事コンテンツ -->
            <article class="content">
                <!-- フィルター -->
                <div class="map_filter">
                    @if($selectedArea === null && $backstageTour === null)
                    <p class="all selected"><a href="{{ route('BrewersPage') }}/">すべて</a></p>
                    @else
                    <p class="all"><a href="{{ route('BrewersPage') }}/">すべて</a></p>
                    @endif
                    <div class="items">
                        <div class="group areas">
                            @foreach($areas as $area)
                            @if($selectedArea !== null && $area->id == $selectedArea->id)
                            <p class="item area selected"><a href="{{ route('BrewersPage') }}/?selectedArea={{ $area->id }}">{{ $area->name }}</a></p>
                            @else
                            <p class="item area"><a href="{{ route('BrewersPage') }}/?selectedArea={{ $area->id }}">{{ $area->name }}</a></p>
                            @endif
                            @endforeach
                        </div>
                        <div class="group backstageTours">
                            <p class="item backstageTour"><a href=""><img src="{{ asset('/svg/mapicon1.svg') }}" width="28" height="64" alt=""><span class="label">見学可</span></a></p>
                            <p class="item backstageTour"><a href=""><img src="{{ asset('/svg/mapicon2.svg') }}" width="28" height="64" alt=""><span class="label">見学不可</span></a></p>
                        </div>
                    </div>
                </div>
                <!-- ／フィルター -->
                <!-- カードリスト -->
                <div class="card_list">
                    <!-- カード1 -->
                    <div class="card">
                        <!-- ピン -->
                        <div class="card_pin">
                            <!-- ピンナンバー -->
                            <div class="card_pin_number">
                                <p>1</p>
                            </div>
                            <!-- ／ピンナンバー -->
                            <!-- ピン画像 -->
                            <div class="card_pin_figure">
                                <a href="#"><img src="{{ asset('/svg/mapicon1.svg') }}" alt="" width="28" height="64"></a>
                            </div>
                            <!-- ／ピン画像 -->
                        </div>
                        <!-- ／ピン -->
                        <!-- 写真 -->
                        <div class="card_figure">
                            <a href="#"><img src="{{ asset('/brewers_img/brewer.780x520.jpg') }}" width="780" height="520" alt="有限会社斉藤酒造場"></a>
                        </div>
                        <!-- ／写真 -->
                        <!-- カードテキスト -->
                        <div class="card_body">
                            <!-- 酒蔵タイトル -->
                            <div class="card_body_name">
                                <a href="#">有限会社斉藤酒造場</a>
                            </div>
                            <!-- ／酒蔵タイトル -->
                            <!-- 見学可不可 ※不可の場合は .card_body_not_seeable -->
                            <div class="card_body_available">
                                <p class="available">酒蔵見学可</p>
                            </div>
                            <!-- ／見学可不可 -->
                            <!-- 営業時間 -->
                            <div class="card_body_time caption_text">
                                <!-- 営業時間ヘッダ固定 -->
                                <div class="card_body_time_header">
                                    <p>営業時間</p>
                                </div>
                                <!-- ／営業時間ヘッダ固定 -->
                                <!-- 時間 -->
                                <div class="card_body_time_hour">
                                    <p>
                                        <span class="card_body_time_opening">8:00</span>
                                        <span> - </span>
                                        <span class="card_body_time_closing">20:00</span>
                                    </p>
                                </div>
                                <!-- ／時間 -->
                                <!-- 曜日 -->
                                <div class="card_body_time_buisiness">
                                    <p>月 - 土曜日(日・祝日休み)</p>
                                </div>
                                <!-- ／曜日 -->
                                <!-- ／営業時間 -->
                            </div>
                            <!-- アドレス -->
                            <div class="card_body_email">
                                <a href="#">www.sekinoi.co.jp</a>
                            </div>
                            <!-- ／アドレス -->
                        </div>
                        <!-- ／カードテキスト -->
                    </div>
                    <!-- ／カード1 -->
                </div>
                <!-- ／カードリスト -->
            </article>
            <!-- ／記事コンテンツ -->
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

    </body>

</html>