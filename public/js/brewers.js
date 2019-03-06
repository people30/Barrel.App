var MyComponent = {
    template: '                <div class="card">
    <!-- ピン -->
    <div class="card_pin">
        <!-- ピンナンバー -->
        <div class="card_pin_number">
            <p>1</p>
        </div>
        <!-- ／ピンナンバー -->
        <!-- ピン画像 -->
        <div class="card_pin_figure">
            <a href="#"><img src="../svg\mapicon1.28ｘ64.svg" alt="有限会社斉藤酒造場"></a>
        </div>
        <!-- ／ピン画像 -->
    </div>
    <!-- ／ピン -->
    <!-- 写真 -->
    <div class="card_figure">
        <a href="#"><img src="brewers_img/brewer.780x520.jpg" alt="有限会社斉藤酒造場"></a>
    </div>
    <!-- ／写真 -->
    <!-- カードテキスト -->
    <div class="card_body">
        <!-- 酒蔵タイトル -->
        <div class="card_body_name">
            <a href="#">有限会社斉藤酒造場</a>
        </div>
        <!-- ／酒蔵タイトル -->
        <!-- 見学可不可 -->
        <div class="card_body_seeable">
            <p>酒蔵見学可</p>
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
</div>'
}
new Vue({
    el: '#app',
    components: {
        'my-component': MyComponent
    }
})