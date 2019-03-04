// トグルボタン
function navFunc() {
    document.querySelector('body').classList.toggle('open');
    var mymenu = document.querySelector(".header_menu");

    if (mymenu.style.height) {
        mymenu.style.height = null;
    } else {
        mymenu.style.height = 100 + "vh";
    }
}
// 上に戻るボタン
$(document).ready(function () {
    var pagetop = $('.pagetop');
    pagetop.click(function () {
        $('body, html').animate({ scrollTop: 0 }, 500);
        return false;
    });
});
