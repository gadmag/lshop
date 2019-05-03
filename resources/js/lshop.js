
$(document).ready(function () {
    //dropdown hover ul.nav li.dropdown
    $('ul.navbar-nav li.dropdown').hover(function () {
        $(this).find('.dropdown-menu').first().stop(true, true).delay(200).fadeIn(500);
    }, function () {
        $(this).find('.dropdown-menu').first().stop(true, true).delay(200).fadeOut(500);
    });

    $('.cart-block .table').on("click.bs.dropdown", function (e) { e.stopPropagation(); e.preventDefault(); });
    // $("#cartDetailBlock").on("click", function(e) {
    //     e.preventDefault();
    //     $(this).find('.cart-block').fadeToggle( "fast");
    // });
    //
    $('.block-forms a.btn').click(function (e) {
        e.preventDefault();
        $('.block-forms a.active').removeClass('active');
        $(this).addClass('active');
        var tab = $(this).attr('href');
        $('.form-content').not(tab).css({'display': 'none'});
        $(tab).fadeIn(400);
    });

    var toggleAffix = function(affixElement, scrollElement, wrapper) {
        var height = affixElement.outerHeight(),
            top = wrapper.offset().top;

        if (scrollElement.scrollTop() >= top + 40){
              wrapper.height(height);
            affixElement.addClass("affix");
        }
        else {
            affixElement.removeClass("affix");
            wrapper.height('auto');
        }

    };


    $('[data-toggle="affix"]').each(function() {
        var ele = $(this),
            wrapper = $('<div></div>');

        ele.before(wrapper);
        $(window).on('scroll resize', function() {
            toggleAffix(ele, $(this), wrapper);
        });

        // init
        toggleAffix(ele, $(window), wrapper);
    });
});





// $(window).on('load', function () {
//     var $preloader = $('.holder'),
//         $spinner   = $preloader.find('.preloader');
//     $spinner.fadeOut();
//     $preloader.delay(350).fadeOut('slow');
// });
