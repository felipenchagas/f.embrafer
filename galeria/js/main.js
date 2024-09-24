$(function () {
    //auto dropdown
    if ($(window).width() >= 800) {
        $('ul.nav li.dropdown').hover(function () {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn();
        }, function () {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut();
        });
    }
});

