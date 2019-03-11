// トグルボタン
function navFunc() {
    document.querySelector('body').classList.toggle('open')
    var mymenu = document.querySelector('.header_menu')

    if (mymenu.style.height) {
        mymenu.style.height = null
    } else {
        mymenu.style.height = 100 + 'vh'
    }
}
// 上に戻るボタン
$(document).ready(function () {
    var pagetop = $('.pagetop')
    pagetop.click(function () {
        $('body, html').animate({
            scrollTop: 0
        }, 500)
        return false
    })
})

// ページを開いたときや該当箇所にスクロールしたときに画像のフェードイン
$(function () {
    $(window).scroll(function () {
        $('.fadein').each(function () {
            var elemPos = $(this).offset().top
            var scroll = $(window).scrollTop()
            var windowHeight = $(window).height()
            if (scroll > elemPos - windowHeight + 200) {
                $(this).addClass('scrollin')
            }
        })
    })
})

$(function () {
    var navBox = $('.top_sticky')
    navBox.hide()
    var TargetPos = 600
    $(window).scroll(function () {
        var ScrollPos = $(window).scrollTop()
        if (ScrollPos > TargetPos) {
            navBox.fadeIn()
        } else {
            navBox.fadeOut()
        }
    })
})

// // ページの途中から現れ、スクロールに追随してくるボタン
// $(document).ready(function() {
//     $('.top_sticky').hide()
//     // ↑ページトップボタンを非表示にする

//     $(window).on('scroll', function() {
//         if ($(this).scrollTop() < 500) {
//             // ↑ スクロール位置が500よりも小さい場合に以下の処理をする
//             $('.top_sticky').append()
//         }
//     })
// })
