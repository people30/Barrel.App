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
            <!-- sakes_page css -->
        <link rel="stylesheet" href="{{ asset('/css/sakes_page.css') }}"> 
        <!-- 価格スライダー -->
        <link rel="stylesheet" href="{{ asset('/css/nouislider.min.css') }}">
        <!-- brewerscss -->
        <link rel="stylesheet" href="{{ asset('/css/brewers_page.css') }}">
        <!-- ファビコン -->
        <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/vnd.microsoft.icon">
        <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/vnd.microsoft.icon">
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMUsphC2nSkQJ6Gq240PD0MyAt0EXSbJ4&callback=initMap" type="text/javascript"></script>
        <script type="text/javascript" src="{{ asset('/js/brewers_page_script.js') }}"></script>
        <!-- ベーススクリプト -->
        <script src="{{ asset('js/base.js') }}"></script>
        <script src="{{ asset('js/sakes_page.js') }}"></script>
        <title>ぐびっと:徳島の地酒</title>

    </head>

</head>

<body>
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
        <article class="content">
            <div class="title_area">
                <!-- タイトル -->
                <h1 class="header_text">徳島の地酒</h1>
                <!-- ／タイトル -->
                <!-- 検索を表示か非表示か -->
                <p class="search_onoff"><a href="">検索を非表示</a></p>
                <!-- ／検索を表示か非表示か -->
            </div>

            <!-- 検索ボックス -->
            <form class="search_area">
                <!-- 味わい -->
                <div id="tastes" class="search_layout">
                    <!-- 味わいヘッダー -->
                    <p class="search_header">味わい</p>
                    <!-- ／味わいヘッダー -->
                    <!-- 味わいボタン -->
                    <ul class="search_content">
                        @foreach
                        <li><label><input type="checkbox" name="selectedTastes[]" value=""><span>{{ selectedTastes }}</span></label></li>
                        @endforeach
                    </ul>
                    <!-- ／味わいボタン -->
                </div>
                <!-- ／味わい -->
                <!-- 特定名称 -->
                <div id="designations" class="search_layout">
                    <!-- 特定名称ヘッダー -->
                    <p class="search_header">特定名称</p>
                    <!-- ／特定名称ヘッダー -->
                    <!-- 味わいボタン -->
                    <ul class="search_content">
                    @foreach
                        <li><label><input type="checkbox" name="selectedDesignations[]" value=""><span>{{ selectedDesignation }}</span></label></li>
                    @endforeach
                    </ul>
                    <!-- ／味わいボタン -->
                </div>
                <!-- 特定名称 -->
                <!-- キーワード -->
                <div id="keyword" class="search_layout">
                    <p class="search_header">キーワード</p>
                    <p class="search_content"><input type="text" name="keyword" value="keyword"></p>
                </div>
                <!-- ／キーワード -->
                <!-- 価格スライダー -->
                <div id="price" class="search_layout">
                    <p class="search_header">価格</p>
                    <div id="noUiSlider">
                        <input type="number" name="space_low" step="500" id="min" class="area" placeholder="下限なし" value="selectedPriceMin"><span>～</span>
                        <input type="number" name="space_high" step="500" id="max" class="area" placeholder="上限なし"
                            value="selectedPriceMax"><span></span>
                        <div id="range"></div>
                    </div>
                </div>
                <!-- ／価格スライダー -->
                <!-- 検索ボタン -->
                <div class="button_layout">
                    <p class="button"><button type="submit">検索</button></p>
                </div>
                <!-- ／検索ボタン -->
            </form>
            <!-- ／検索ボックス -->

            <!-- ###################################### -->

            <!-- 表示数 -->
            <div class="card_sum caption_text">
                <span>{{ 54 }}</span><span>品 表示中</span>
            </div>
            <!-- ／表示数 -->

            <!-- ###################################### -->
            <!-- カードリスト -->
            <div class="card_list">

                <!-- カード -->
                <div class="card">
                    <div class="card_inner">
                        <!-- 酒画像 -->
                        <div class="card_figure">
                            @foreach
                            <img src="{{ asset('/sake/sake-slug/designation-slug/kirai.80x260.png') }}" alt="" width="80" height="260">
                            @endforeach
                        </div>
                        <!-- ／酒画像 -->
                        <!-- カードボディ -->
                        <div class="card_body">
                            <!-- 純米大吟醸 -->
                            <p class="sake_designation caption_text">{{ $sake->designation }}</p>
                            <!-- ／純米大吟醸 -->
                            <!-- コクのある -->
                            <p class="sake_taste">
                                <span class="caption_text taste_heavy">{{ $sake->taste }}</span>
                            </p>
                            <!-- ／コクのある -->
                            <!-- 名前 -->
                            <p class="sake_name non_bar_text">{{ $sake->name }}</p>
                            <!-- ／名前 -->
                            <!-- アルコール度 -->
                            <div class="sake_alcoholicity">
                                <!-- アルコール度イメージ -->
                                <img src="{{ asset('/svg/al15.svg') }}" alt="" width="25px" height="50px">
                                <!-- アルコール度イメージ -->
                                <!-- 数字 -->
                                <p class="subtitle_text">
                                    <span>{{ $sake->alcoholicity }}</span>
                                    <span>%</span>
                                </p>
                                <!-- ／数字 -->
                                <!-- アルコール度文字 -->
                                <p class="caption_text">アルコール度</p>
                                <!-- ／アルコール度文字 -->
                            </div>
                            <!-- ／アルコール度 -->
                            <!-- 精米歩合 -->
                            <div class="rice_pollishing_ratio">
                                <!-- 精米歩合イメージ -->
                                <img src="{{ asset('/svg/seimai40.svg') }}" alt="" width="30px" height="50px">
                                
                                <!-- ／精米歩合イメージ -->
                                <!-- 数字 -->
                                <p class="subtitle_text">
                                    <span>{{ $sake->ricePollishingRatio }}</span>
                                    <span>%</span>
                                    <!-- ／数字 -->
                                </p>
                                <!-- 精米歩合文字 -->
                                <p class="caption_text">精米歩合</p>
                                <!-- ／精米歩合文字 -->
                            </div>
                            <!-- ／精米歩合 -->
                            <div class="card_footer">
                                <!-- 容量 -->
                                <p><span class="sake_price caption_text">{{ $size->content }}</span>
                                    <span class="caption_text">ml</span>
                                    <span class="sake_price subtitle_text">{{ $size->price }}</span>
                                    <span class="caption_text">円 (税抜)</span></p>
                                <!-- 製造の文字 赤色 -->
                                <p class="card_brewer"><a href="{{ route('BrewerDetailsPage', ['slug' => $brewer->slug]) }}"><span>製造:</span><span>{{ $brewer->name }}</span></a></p>
                                <!-- ／製造の文字 赤色 -->
                            </div>
                        </div>
                        <!-- ／カードボディ -->
                    </div>
                    <!-- ／カードインナー -->
                </div>
                <!-- ／カード -->
            </div>
            <!-- ／カードリスト -->
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
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="../js/nouislider.min.js"></script>

    <script>
        var $slider = $('#range').get(0); //スライダー要素
        var $min = $('#min'); //最小値のテキストフィールド
        var $max = $('#max'); //最大値のテキストフィールド
        var minVal = 0; //最小値
        var maxVal = 50000; //最大値
        var gap = 500; // 数値を500刻みにする

        //noUiSliderをセット
        noUiSlider.create($slider, {
            start: [minVal - gap, maxVal + gap], //
            connect: true,
            step: gap,
            range: {
                'min': minVal - gap, //最小値を-5
                'max': maxVal + gap //最小値を+5
            },
            pips: {
                mode: 'range',
                density: gap
            }
        });

        //noUiSliderイベント
        $slider.noUiSlider.on('update', function (values, handle) {

            //現在の最小値・最大値を取得
            var value = Math.floor(values[handle]);

            if (handle) {
                $max.get(0).value = value; //現在の最大値
            } else {
                $min.get(0).value = value; //現在の最小値
            }

            //noUiSlider下部の数値変更（そのままだと+-5の数値が表示されるため）
            $('.noUi-value-large').text(minVal);
            $('.noUi-value-large:last-child').text(maxVal);

            //最小値以下・最大値以上でinputを空にする
            if ($min.get(0).value <= minVal || $min.get(0).value > maxVal) {
                $min.val('');
            }
            if ($max.get(0).value <= minVal || $max.get(0).value > maxVal) {
                $max.val('');
            }

        });

        //最小値をinputにセット
        $min.get(0).addEventListener('change', function () {
            $slider.noUiSlider.set([this.value, null]);
        });

        //最大値をinputにセット
        $max.get(0).addEventListener('change', function () {
            $slider.noUiSlider.set([null, this.value]);
        });
    </script>
</body>

</html>