<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- サイト説明 -->
        <meta property="og:description" content="">
        <!-- ベースcss -->
        <link rel="stylesheet" href="{{ asset('/css/base.css') }}">
        <!-- sakes_page css -->
        <link rel="stylesheet" href="{{ asset('/css/sakes_page.css') }}">
        <!-- 価格スライダー -->
        <link rel="stylesheet" href="{{ asset('/css/nouislider.min.css') }}">
        <!-- googleフォント -->
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP" rel="stylesheet">
        <!-- fontawesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <!-- jQuery -->
        <script src="{{ asset('/js/jquery-3.3.1.min.js') }}"></script>
        <!-- ベーススクリプト -->
        <script src="{{ asset('/js/base.js') }}"></script>
        <!-- 地酒ページスクリプト -->
        <script src="{{ asset('/js/nouislider.min.js') }}"></script>
        <script src="{{ asset('/js/wNumb.js') }}"></script>
        <script src="{{ asset('/js/sakes_page.js') }}"></script>
        <title>ぐびっと:徳島の地酒</title>
    </head>

    <body data-context="{{ json_encode(compact([
        'priceMin',
        'priceMax',
        'selectedPriceMin',
        'selectedPriceMax'
    ])) }}">
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
                <!-- タイトル -->
                <h1 class="header_text">徳島の地酒</h1>
                <!-- ／タイトル -->

                <!-- 検索ボックス -->

                <div class="search_area">
                    <p class="search_control_expansion_button"><button type="button" id="text_block_button" class="text_block_button">{{ $sakes->count() }} 品 表示中: <span class="items">{{
                        count($filterContents) > 0
                        ? implode(', ', $filterContents)
                        : 'すべて'
                    }}</span></button></p>
                    <form id="filter_control" method="get" action="{{ route('SakesPage') }}/" class="hidden">
                        <!-- 味わい -->
                        <div id="tastes" class="search_layout">
                            <!-- 味わいヘッダー -->
                            <p class="search_header">味わい</p>
                            <!-- ／味わいヘッダー -->
                            <!-- 味わいボタン -->
                            <ul class="search_content">
                                @foreach($tastes as $taste)
                                @if($selectedTastes->contains(function($st) use($taste) { return $st->id == $taste->id; }))
                                <li><label><input type="checkbox" name="selectedTastes[]" value="{{ $taste->id }}" checked="checked"><span>{{ $taste->name }}</span></label></li>
                                @else
                                <li><label><input type="checkbox" name="selectedTastes[]" value="{{ $taste->id }}"><span>{{ $taste->name }}</span></label></li>
                                @endif
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
                                @foreach($designations as $designation )
                                @if($selectedDesignations->contains(function($d) use($designation) { return $d->id == $designation->id; }))
                                <li><label><input type="checkbox" name="selectedDesignations[]" value="{{ $designation->id }}" checked="checked"><span>{{ $designation->name }}</span></label></li>
                                @else
                                <li><label><input type="checkbox" name="selectedDesignations[]" value="{{ $designation->id }}"><span>{{ $designation->name }}</span></label></li>
                                @endif
                                @endforeach
                            </ul>
                            <!-- ／味わいボタン -->
                        </div>
                        <!-- 特定名称 -->
                        <!-- キーワード -->
                        <div id="keyword" class="search_layout">
                            <p class="search_header">キーワード</p>
                            <p class="search_content"><input type="text" name="keyword" value=""></p>
                        </div>
                        <!-- ／キーワード -->
                        <!-- 価格スライダー -->
                        <div id="price" class="search_layout">
                            <p class="search_header">価格</p>
                            <div class="search_content">
                                <div id="range"></div>
                                <input type="hidden" name="selectedPriceMin" id="selectedPriceMin" value="">
                                <input type="hidden" name="selectedPriceMax" id="selectedPriceMax" value="">
                            </div>
                        </div>
                        <!-- ／価格スライダー -->
                        <!-- 検索ボタン -->
                        <div class="button_layout">
                            <p class="button">
                                <button type="submit">検索</button>
                                <a href="{{ route('SakesPage') }}/">フィルタをクリア</a>
                            </p>
                        </div>
                        <!-- ／検索ボタン -->
                    </form>
                </div>
                <!-- ／検索ボックス -->

                <!-- ###################################### -->
                <!-- カードリスト -->
                <div class="card_list">
<?php
                $alcoholicityPict = [];
                for($i = 5; $i < 100; $i += 5)
                {
                    if($i <= 20)
                        $alcoholicityPict[$i] = asset('/svg/al' . $i . '.svg');
                    else
                        $alcoholicityPict[$i] = asset('/svg/al20.svg');
                }
                
                $pollishingPict = [];
                for($i = 10; $i < 100; $i += 10)
                {
                    $pollishingPict[$i] = asset('/svg/seimai' . $i . '.svg');
                }
?>
                    <!-- カード -->
                    @foreach($sakes as $sake)
                    <div class="card">
                        <div class="card_inner">
                            <!-- 酒画像 -->
                            <div class="card_figure">
                                @if($sake->bottle != null)
                                <img src="{{ $sake->bottle->files['80x260']->url }}" alt="" width="80" height="260">
                                @endif
                            </div>
                            <!-- ／酒画像 -->
                            <!-- カードボディ -->
                            <div class="card_body">
                                <!-- 純米大吟醸 -->
                                <p class="sake_designation caption_text">{{ $sake->designation->name }}</p>
                                <!-- ／純米大吟醸 -->
                                <!-- コクのある -->
                                <p class="sake_taste">
                                    <span class="caption_text {{ $sake->taste->slug }}">{{ $sake->taste->name }}</span>
                                </p>
                                <!-- ／コクのある -->
                                <!-- 名前 -->
                                <p class="sake_name non_bar_text">{{ $sake->name }}</p>
                                <!-- ／名前 -->
                                <!-- アルコール度 -->
                                <div class="sake_alcoholicity">
                                    <!-- アルコール度イメージ -->
                                    <img src="{{ asset($alcoholicityPict[ceil($sake->alcoholicity * 100 / 5) * 5]) }}" alt="" width="25" height="50">
                                    <!-- アルコール度イメージ -->
                                    <!-- 数字 -->
                                    <p class="subtitle_text">
                                        <span>{{ $sake->alcoholicity * 100}}</span>
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
                                    <img src="{{ asset($pollishingPict[ceil($sake->ricePollishingRatio * 10) * 10]) }}" alt="" width="30" height="50">

                                    <!-- ／精米歩合イメージ -->
                                    <!-- 数字 -->
                                    <p class="subtitle_text">
                                        <span>{{ $sake->ricePollishingRatio * 100 }}</span>
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
                                    @foreach($sake->sizes as $size)
                                    <p><span class="sake_price caption_text">{{ number_format($size->content) }}</span>
                                        <span class="caption_text">ml</span>
                                        <span class="sake_price subtitle_text">{{ number_format($size->price) }}</span>
                                        <span class="caption_text">円 (税抜)</span></p>
                                    @endforeach
                                    <!-- 製造の文字 赤色 -->
                                    <p class="card_brewer"><a href="{{ route('BrewerDetailsPage', ['slug' => $sake->brewer->slug]) }}/"><span>製造:</span><span>{{ $sake->brewer->name }}</span></a></p>
                                    <!-- ／製造の文字 赤色 -->
                                </div>
                            </div>
                            <!-- ／カードボディ -->
                        </div>
                        <!-- ／カードインナー -->
                    </div>
                    @endforeach
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
                    <a href="https://www.facebook.com/Gubittotokushima-628717054256840/" class="fab fa-facebook"><span class="sr-only">Facebook</span></a>
                    <a href="https://www.instagram.com/gubittotokushima/" class="fab fa-instagram"><span class="sr-only">instagram</span></a>
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