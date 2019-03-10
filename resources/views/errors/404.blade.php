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
        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
        <!-- ベーススクリプト -->
        <script src="{{ asset('js/base.js') }}"></script>
        <title>ぐびっと:徳島の酒蔵</title>

    </head>

    <body onload="initialize()">
        <!-- ヘッダー -->
        <div class="sticky">
            <header class="header_area">
                <!-- ヘッダーロゴ -->
                <h1 class="header_logo">
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
            <div class="content">
                <h1 class="header_text">このページは存在しません。</h1>
                <p>URL が正しいことを確認してください。</p>
            </div>
        </main>
        <!-- ／メインエリア -->
        <!-- ################################################################### -->

        <!-- フッター外枠 -->
        <footer class="footer_area">
            <!-- フッター内枠 -->
            <div class="footer_list">
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