$(function ()
{
    var settings = function ()
    {
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

    function slideSetting()
    {
        mySlider.reloadSlider(settings());
    }

    mySlider = $(".slider").bxSlider(settings());
    $(window).resize(slideSetting);

    var dataContext = JSON.parse($('body').attr('data-context'));
    var map = new google.maps.Map(
        document.getElementById("map"),
        {
            zoom: 15,
            center: new google.maps.LatLng(dataContext.brewer.lat, dataContext.brewer.lon),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
    );

    var iconUrl = dataContext.brewer.isBackstageSeeable ? dataContext.backstageSeeableBrewerMarkerUrl : dataContext.backstageUnseeableBrewerMarkerUrl;
    var marker = new google.maps.Marker({
        map: map,
        position: new google.maps.LatLng(dataContext.brewer.lat, dataContext.brewer.lon),
        icon: new google.maps.MarkerImage(
            iconUrl,
            new google.maps.Size(28, 64),    //マーカー画像のサイズ
            new google.maps.Point(0, 0),     //位置（0,0で固定）
            //new google.maps.Point(値x,値y), //位置（任意の調整値）
        )
    });
});

// fullScreen(function ($) {
//     $(".full_scr").attr('rel', 'group').fancybox();
// });
$('[data-fancybox]').fancybox({
    // オプションはここに書きます
    hideOnOverlayClick: true,
    protect: true, //右クリック抑止
});
