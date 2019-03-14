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
        <link rel="stylesheet" href="{{ asset('/css/jquery.bxslider_kura.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/jquery.fancybox.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/brewer_details_page.css') }}">

        <!-- ファビコン -->
        <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/vnd.microsoft.icon">
        <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/vnd.microsoft.icon">

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
        <!-- スクリプト -->
        <script src="{{ asset('/js/base.js') }}"></script>
        <script src="{{ asset('/js/jquery.bxslider.min.js') }}"></script>
        <script src="{{ asset('/js/jquery.fancybox.min.js') }}"></script>
        <script src="{{ asset('/js/brewer_details_page.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GMAP_KEY') }}"></script>

        <title>ぐびっと:{{$brewer->name}}</title>
    </head>

    <body data-context="{{ json_encode([
    'brewer' => $brewer,
    'backstageSeeableBrewerMarkerUrl' => asset('svg/mapicon1.svg'),
    'backstageUnseeableBrewerMarkerUrl' => asset('svg/mapicon2.svg')
]) }}">
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
            <div class="content_fluid"></div>

            <article class="content">
                <!-- 蔵の写真、基本情報 -->
                <section>
                    <h1 class="header_text">{{ $brewer->name }}</h1>
                    <section class="kura_info">
                        <div class="main_image">
                            @if($brewer->keyVisual != null)
                            <img src="{{$brewer->keyVisual->files['780x520']->url}}" srcset="{{$brewer->keyVisual->files['780x520']->url}} 780w, 
                                    {{$brewer->keyVisual->files['580x384']->url}} 580w, 
                                    {{$brewer->keyVisual->files['320x240']->url}} 320w">
                            @endif
                        </div>
                        <article class="about_kura">
                            <ul>
                                <li class="about_kura_outline">
                                    {{ $brewer->text }}
                                </li>
                                <li class="about_kura_seeable">
                                    @if ($brewer->isBackstageSeeable)
                                    <p class="available">酒蔵見学可</p>
                                    @else
                                    <p>酒蔵見学不可</p>
                                    @endif
                                </li>
                                <li class="about_kura_open">
                                    <table>
                                        <tr>
                                            <th>営業時間</th>
                                            <td>
                                                {{ $brewer->openingTime }} - {{ $brewer->closingTime }}
                                                <br>{{ $brewer->buisinessDay}}
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                                @if($brewer->links->has('website'))
                                <li class="about_kura_url">
                                    <a href="{{ $brewer->links['website']->url }}">
                                        {{ $brewer->links['website']->url }}</a>
                                </li>
                                @endif
                                @if ($brewer->isBackstageSeeable)
                                <li class="about_kura_caution caption_text">酒蔵の見学は予約が必要な場合があります。</li>
                                @endif
                            </ul>
                        </article>
                    </section>

                    <div class="sub_image slider">
                        @foreach ($photos as $photo)
                        <div>
                            <a class="full_scr" href="{{ $photo->files['780x520']->url }}" data-fancybox>

                                <img src="{{$photo->files['780x520']->url}}" srcset="{{$photo->files['780x520']->url}} 280w, 
                        {{$photo->files['780x520']->url}} 280w, 
                        {{$photo->files['780x520']->url}} 380w"></a>

                        </div>
                        @endforeach

                    </div>
                </section>
                <!--／ 蔵の写真、基本情報 -->

                <!-- その蔵や製造品に関する記事、詳細情報 -->
                <section class="kura_details">
                    <article>
                        <h2 class="title_text">読みもの</h2>
                        <div class="kura_stories">
                            @if($stories->count() > 0)
                            <!-- ブログ記事 リスト -->
                            <ul>
                                @foreach ($stories as $story)
                                <!-- ブログ記事 一件 -->
                                <li class="post_item">
                                    <div class="blog_head">
                                        <div class="category">
                                            @foreach($story->categories as $category)
                                            <a href="{{ $category->link }}">{{ $category->name }}</a>
                                            @endforeach
                                        </div>
                                        <div class="title">
                                            <h3>
                                                <a class="subtitle_text story_title" href="{{ $story->link }}">{{ $story->title }}</a>
                                            </h3>
                                        </div>
                                    </div>
                                    <p>
                                        {!! $story->html !!}
                                    </p>
                                </li>
                                <!-- ／ブログ記事 一件-->
                                @endforeach

                            </ul>
                            <!-- ブログ記事 リスト -->
                            @else
                            <p>投稿が存在しないか予期しないエラーにより表示できません。</p>
                            @endif

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
                                    <td>{{ $brewer->owner }}</td>
                                </tr>
                                @if($brewer->toji != null)
                                <tr>
                                    <th>杜氏</th>
                                    <td>{{ $brewer->toji }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>営業日</th>
                                    <td>{{ $brewer->buisinessDay }}</td>
                                </tr>
                                <tr>
                                    <th>営業時間</th>
                                    <td>{{ $brewer->openingTime }} - {{ $brewer->closingTime }}</td>
                                </tr>
                                @if($brewer->phoneNumber != null)
                                <tr>
                                    <th>TEL</th>
                                    <td>{{ $brewer->phoneNumber }}</td>
                                </tr>
                                @endif
                                @if($brewer->faxNumber != null)
                                <tr>
                                    <th>FAX</th>
                                    <td>{{ $brewer->faxNumber }}</td>
                                </tr>
                                @endif
                                @if($brewer->email != null)
                                <tr>
                                    <th>E-mail</th>
                                    <td>{{ $brewer->email }}</td>
                                </tr>
                                @endif
                                @if($brewer->links->has('website'))
                                <tr>
                                    <th>URL</th>
                                    <td>
                                        <a class="gaiyou_url" href="{{ $brewer->links['website']->url }}">{{ $brewer->links['website']->url }}</a>
                                    </td>
                                </tr>
                                @endif
                                @if($brewer->address != null)
                                <tr>
                                    <th>住所</th>
                                    <td>{{ $brewer->address }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <div id="map"></div>
                    </article>
                </section>

                <!--／ その蔵や製造品に関する記事、詳細情報 -->
                <!-- 製造品一覧 -->
                <section class="products">
                    <h1 class="title_text">代表銘柄</h1>
                    <div class="items">
                        @foreach($products as $product)
                        <!-- カード -->
                        <div class="item_card">
                            <div class="spec">
                                <img src="{{ $product->bottle->files['80x260']->url }}" alt="" width="80" height="260">
                                <ul class="products_info">
                                    <li class="caption_text tokutei_meishou">
                                        {{ $product->designation->name }}
                                    </li>
                                    <li class="caption_text {{$product->taste->slug}}">
                                        {{ $product->taste->name }}
                                    </li>
                                    <li class="meigara">{{ $product->name }}</li>

                                    <li class="product_alc">
                                        <div class="grid_item">
                                            @if (ceil(($product->alcoholicity * 100) / 5) * 5 == 5 )
                                            <img src="{{ asset('/svg/al5.svg') }}" width="25px" height="50px" alt="">
                                            @elseif (ceil(($product->alcoholicity * 100) / 5) * 5 == 10 )
                                            <img src="{{ asset('/svg/al10.svg') }}" width="25px" height="50px" alt="">
                                            @elseif (ceil(($product->alcoholicity * 100) / 5) * 5 == 15 )
                                            <img src="{{ asset('/svg/al15.svg') }}" width="25px" height="50px" alt="">
                                            @elseif (ceil(($product->alcoholicity * 100) / 5) * 5 == 20 )
                                            <img src="{{ asset('/svg/al20.svg') }}" width="25px" height="50px" alt="">
                                            @endif
                                        </div>
                                        <ul>
                                            <li>{{ $product->alcoholicity * 100 }}%</li>
                                            <li>アルコール度</li>
                                        </ul>
                                    </li>
                                    <li class="product_seimai">
                                        <div class="grid_item">
                                            @if (ceil($product->ricePollishingRatio * 10) == 1 )
                                            <img src="{{ asset('/svg/seimai10.svg') }}" width="30px" height="50px" alt="">
                                            @elseif (ceil($product->ricePollishingRatio * 10) == 2 )
                                            <img src="{{ asset('/svg/seimai20.svg') }}" width="30px" height="50px" alt="">
                                            @elseif (ceil($product->ricePollishingRatio * 10) == 3 )
                                            <img src="{{ asset('/svg/seimai30.svg') }}" width="30px" height="50px" alt="">
                                            @elseif (ceil($product->ricePollishingRatio * 10) == 4 )
                                            <img src="{{ asset('/svg/seimai40.svg') }}" width="30px" height="50px" alt="">
                                            @elseif (ceil($product->ricePollishingRatio * 10) == 5 )
                                            <img src="{{ asset('/svg/seimai50.svg') }}" width="30px" height="50px" alt="">
                                            @elseif (ceil($product->ricePollishingRatio * 10) == 6 )
                                            <img src="{{ asset('/svg/seimai60.svg') }}" width="30px" height="50px" alt="">
                                            @elseif (ceil($product->ricePollishingRatio * 10) == 7 )
                                            <img src="{{ asset('/svg/seimai70.svg') }}" width="30px" height="50px" alt="">
                                            @elseif (ceil($product->ricePollishingRatio * 10) == 8 )
                                            <img src="{{ asset('/svg/seimai80.svg') }}" width="30px" height="50px" alt="">
                                            @elseif (ceil($product->ricePollishingRatio * 10) == 9 )
                                            <img src="{{ asset('/svg/seimai90.svg') }}" width="30px" height="50px" alt="">
                                            @endif

                                        </div>
                                        <ul>
                                            <li>{{ $product->ricePollishingRatio * 100 }}%</li>
                                            <li>精米歩合</li>
                                        </ul>
                                    </li>
                                    <li class="rice">
                                        <ul>
                                            <li>原料米</li>
                                            <li>{{ $product->rawRice }}</li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <p class="product_point">
                                {{ $product->text }}
                            </p>
                            <table class="price_list">
                                <tbody>
                                    @foreach ($product->sizes as $size)
                                    <tr>
                                        <th class=" caption_text">{{ number_format($size->content)}}ml</th>
                                        <td class="price">{{ number_format($size->price) }}円</td>
                                        <td class="tax caption_text">(税抜)</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- ／カード -->
                        @endforeach
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
                    <a href="https://www.facebook.com/Gubittotokushima-628717054256840/?modal=admin_todo_tour" class="fab fa-facebook"><span class="sr-only">Facebook</span></a>
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