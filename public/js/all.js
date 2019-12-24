
$(document).ready(function () {

    $('ul.navbar-nav li.dropdown').hover(function () {
        $(this).addClass('show');
        $(this).find('.dropdown-menu').addClass('show');

    }, function () {
        $(this).removeClass('show');
        $(this).find('.dropdown-menu').removeClass('show');
    });

    $('ul.navbar-nav li.dropdown').on('click', function() {
        var $el = $(this);
        if ($el.hasClass('show')) {
            var $a = $el.children('a');
            if ($a.length && $a.attr('href')) {
                  location.href = $a.attr('href');
            }
        }
    });

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
