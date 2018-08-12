$(document).ready(function () {
    //dropdown hover
    $('ul.nav li.dropdown').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
    });

    //
    $('.block-forms a.btn').click(function (e) {
        e.preventDefault();
        $('.block-forms a.active').removeClass('active');
        $(this).addClass('active');
        var tab = $(this).attr('href');
        $('.form-content').not(tab).css({'display': 'none'});
        $(tab).fadeIn(400);
    });

    //
    $('div.alert').not('alert-important').delay(3000).slideUp(300);
});

//# sourceMappingURL=all.js.map
