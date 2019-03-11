var map;
var marker_ary = new Array();
var currentInfoWindow

$(function ()
{
    var dataContext = JSON.parse($('body').attr('data-context'));

    var vm = new Vue({
        el: '#brewers',
        data: {
            'allBrewers': dataContext.brewers,
            'mapNELat': 0,
            'mapNELon': 0,
            'mapSWLat': 0,
            'mapSWLon': 0
        },

        computed: {
            'brewers': function()
            {
                // if(this.brewers == null) return [];

                return this.allBrewers.filter(function(brewer) {
                    return true;
                });
            }
        },

        methods: {
            setMarker: function (lat, lon, text)
            {
                var marker_num = marker_ary.length;
                var marker_position = new google.maps.LatLng(lat, lon);
                var markerOpts = {
                    map: map,
                    position: marker_position,
                    icon: new google.maps.MarkerImage(
                        '../svg/mapicon1.svg',
                        new google.maps.Size(12, 44),    //マーカー画像のサイズ
                        new google.maps.Point(0, 0),     //位置（0,0で固定）
                        //new google.maps.Point(値x,値y), //位置（任意の調整値）
                    ),
                };
                marker_ary[marker_num] = new google.maps.Marker(markerOpts);

                //textが渡されていたらふきだしをセット
                if (text.length > 0) {
                    var infoWndOpts = {
                        content: text
                    };
                    var infoWnd = new google.maps.InfoWindow(infoWndOpts);
                    google.maps.event.addListener(marker_ary[marker_num], "click", function ()
                    {

                        //先に開いた情報ウィンドウがあれば、closeする
                        if (currentInfoWindow) {
                            currentInfoWindow.close();
                        }

                        //情報ウィンドウを開く
                        infoWnd.open(map, marker_ary[marker_num]);

                        //開いた情報ウィンドウを記録しておく
                        currentInfoWindow = infoWnd;
                    });
                }
            },

            //マーカー削除
            clearMarker: function ()
            {
                //表示中のマーカーがあれば削除
                if (marker_ary.length > 0) {
                    //マーカー削除
                    for (i = 0; i < marker_ary.length; i++) {
                        marker_ary[i].setMap();
                    }
                    //配列削除
                    for (i = 0; i <= marker_ary.length; i++) {
                        marker_ary.shift();
                    }
                }
            },

            //XMLで取得した地点を地図上でマーカーに表示
            setPointMarker: function ()
            {
                //マーカー削除
                this.clearMarker();

                //地図の範囲内を取得
                var bounds = map.getBounds();
                map_ne_lat = bounds.getNorthEast().lat();
                map_sw_lat = bounds.getSouthWest().lat();
                map_ne_lng = bounds.getNorthEast().lng();
                map_sw_lng = bounds.getSouthWest().lng();
                //     this.mapNELat = bounds.getNorthEast().lat();
                // this.mapNELon = bounds.getNorthEast().lon();
                // this.mapSWLat = bounds.getSouthWest().lat();
                // this.mapSWLon = bounds.getSouthWest().lon();

                //帰ってきた地点の数だけループ
                this.brewers.forEach((function (brewer)
                {
                    //マーカーをセット
                    this.setMarker(brewer.lat, brewer.lon, brewer.name);
                }).bind(this));
            }
        }
    });

    var latlng = new google.maps.LatLng(34.078547, 134.523913);
    var myOptions = {
        zoom: 10,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

    //イベント登録　地図の表示領域が変更されたらイベントを発生させる
    google.maps.event.addListener(map, 'idle', (function ()
    {
        vm.setPointMarker();
    }).bind(this, vm));
});
