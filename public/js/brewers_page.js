document.addEventListener('DOMContentLoaded', function () {
    var dataContext = JSON.parse(document.getElementsByTagName('body')[0].getAttribute('data-context'));

    dataContext.brewers.forEach(function (brewer) {
        brewer.backstageTour = brewer.isBackstageSeeable ? '酒蔵見学可' : '酒蔵見学不可';
    });

    var margin = 0;

    var vm = new Vue({
        el: '#brewers',
        data: {
            'brewers': dataContext.brewers,
            'mapNorth': 0,
            'mapEast': 0,
            'mapSouth': 0,
            'mapWest': 0
        },

        computed: {
            'brewersVisible': function () {
                return this.brewers.filter((function (brewer) {
                    return brewer.lat >= this.mapSouth - margin && brewer.lat <= this.mapNorth + margin && brewer.lon >= this.mapWest - margin && brewer.lon <= this.mapEast + margin;
                }).bind(this));
            }
        },

        methods: {
            // 各地点の緯度と経度の平均から中心点の座標を求める
            getCenter: function () {
                // 緯度
                var lats = this.brewers.map(function (brewer) { return brewer.lat; });
                var centerLat = lats.length > 0 ? lats.reduce(function (prev, current) { return prev + current; }) / lats.length : 34.071620;

                // 経度
                var lons = this.brewers.map(function (brewer) { return brewer.lon; });
                var centerLon = lons.length > 0 ? lons.reduce(function (prev, current) { return prev + current; }) / lons.length : 134.558074;

                return {
                    lat: centerLat,
                    lon: centerLon
                };
            }
        }
    });

    var flyoutCurrent = null;
    var markers = [];
    var center = vm.getCenter();
    var map = new google.maps.Map(
        document.getElementById("map"),
        {
            zoom: 10,
            center: new google.maps.LatLng(center.lat, center.lon),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
    );

    // 地図が移動している時にマップの端をビュー モデルに渡す
    map.addListener('bounds_changed', function () {
        // 地図の端を取得
        var bounds = map.getBounds();
        vm.mapNorth = bounds.getNorthEast().lat();
        vm.mapSouth = bounds.getSouthWest().lat();

        vm.mapEast = bounds.getNorthEast().lng();
        vm.mapWest = bounds.getSouthWest().lng();
    });

    // マーカーを地図に登録
    vm.brewers.forEach((function (brewer, index) {
        brewer.mapNumber = index + 1;
        var marker_num = markers.length;
        var iconUrl = brewer.isBackstageSeeable ? dataContext.backstageSeeableBrewerMarkerUrl : dataContext.backstageUnseeableBrewerMarkerUrl;

        markers[index] = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(brewer.lat, brewer.lon),
            icon: new google.maps.MarkerImage(
                iconUrl,
                new google.maps.Size(28, 64),    //マーカー画像のサイズ
                new google.maps.Point(0, 0),     //位置（0,0で固定）
                //new google.maps.Point(値x,値y), //位置（任意の調整値）
            )
        });

        // マーカーをクリックした時の吹き出し
        if (brewer.name.length > 0) {
            var flyout = new google.maps.InfoWindow({
                content: brewer.name
            });

            markers[index].addListener('click', (function () {

                //先に開いた情報ウィンドウがあれば、closeする
                if (flyoutCurrent) {
                    flyoutCurrent.close();
                }

                //情報ウィンドウを開く
                flyout.open(map, markers[index]);

                //開いた情報ウィンドウを記録しておく
                flyoutCurrent = flyout;
            }).bind(this));
        }

        if (brewer.keyVisual != null) {
            brewer.keyVisual.srcset =
                brewer.keyVisual.files['280x184'].url + ' 280w, ' +
                brewer.keyVisual.files['380x252'].url + ' 380w, ' +
                brewer.keyVisual.files['580x384'].url + ' 580w, ' +
                brewer.keyVisual.files['780x520'].url + ' 780w';
        }
    }).bind(this));
});
