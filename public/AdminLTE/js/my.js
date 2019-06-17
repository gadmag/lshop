$('.remove-file').on('click', function (e) {
    // var inputData = $('#formDeleteProduct').serialize();


    var dataId = $(this).attr('data-id');
    var url = "/admin/upload/" + dataId;
    console.log(url);

    $.ajax({

        url: url,
        type: "GET",
        success: function (data) {
            console.log(data.status);

            $("#file-item-" + dataId).remove();
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });


    return false;
});

$('div.alert').not('alert-important').delay(3000).slideUp(300);

(function ($) {
    $('.dateru input').datepicker({
        dateFormat: 'yy-mm-dd',
        language: 'ru'
    });

    $('.dateru input').change(function () {
        var dateFormat = $('.dateru input').datepicker('getDate');
        var value = $.datepicker.formatDate('yy-mm-dd', dateFormat);
        console.log(value)
        $(this).attr('value', value).val();
    });

    $('#tag_lists').select2({
        placeholder: 'Выберите теги',
        tags: true
//        data: [
//            {id: 'one', text: 'One'},
//            {id: 'two', text: 'Two'}
//
//        ]

    });

    $('#catalog_lists').select2({
        placeholder: 'Выберите категории',
        catalogs: true
    });


}(jQuery));

//Nested set
$(document).ready(function () {

    function updateMenu(jsonString) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/admin/menu/updatesort',
            type: 'POST',
            dataType: 'json',
            data: {
                jsonString: jsonString
            },
            success: function (data) {
                console.log(data.status);

            },
            error: function (data) {
                console.log('Error:', data);
                // if ( data.status === 422 ) {
                //     toastr.error('Cannot delete the category');
                // }
            }
        });


    }

    var updateOutput = function (e) {

        var list = e.length ? e : $(e.target),
            output = list.data('output');
        // console.log(list.data('output'));
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            updateMenu(window.JSON.stringify(list.nestable('serialize')));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };

    // activate Nestable for list 1
    $('#nestable').nestable({
        group: 1
    }).on('change', updateOutput);

    var variable = $('#nestable').data();
    if (typeof variable !== "undefined" && variable) {
        updateOutput($('#nestable').data('output', $('#nestable-output')));
    }


    $('#nestable-menu').on('click', function (e) {
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });


    $(".dd a").on("mousedown", function (event) { // mousedown prevent nestable click
        event.preventDefault();
        return false;
    });
    $(".dd a").on("click", function (event) { // click event
        event.preventDefault();
        window.location = $(this).attr("href");
        return false;
    });

});

//options product
(function ($) {
    var row = $('table.table tbody').children().length - 1;
    $('#add-options').on('click', function (e) {
        // var  row = $('optionHide');
        //  console.log(optionCoating.querySelectorAll('tr'));
        e.preventDefault();
        // $('#option-value-row').clone().toggleClass('hide').attr('id', '#option-value-row' + row).appendTo('.tab-option-coating table.table tbody');
        $('.tab-option-coating table.table tbody')[0].appendChild(optionCoating.content.cloneNode(true));
        row++;
    });


    $('.tab-options').on("click", '.remove-options', function (e) {
        // e.preventDefault();
        // var dataId = $(this).attr('data-id');
        // var fields = $(this).parent().parent();
        // if (dataId) {
        //     var url = "/admin/option/" + dataId;
        //
        //     $.ajax({
        //         type: 'GET',
        //         url: url,
        //         dataType: 'json',
        //         cache: false,
        //         success: function (data) {
        //             fields.remove();
        //         },
        //         error: function (xhr, ajaxOptions, thrownError) {
        //             console.log(xhr.status + ' ' + thrownError);
        //         }
        //     });
        // } else {
        //     fields.remove();
        // }

    })


    $('input').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });


}(jQuery))