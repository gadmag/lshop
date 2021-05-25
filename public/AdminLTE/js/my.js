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


(function ($) {

    $('.alert').not('alert-important').delay(3000).slideUp(300);

    // $('.dateru input').datepicker({
    //     dateFormat: 'yy-mm-dd',
    //     language: 'ru'
    // });
    //
    // $('.dateru input').change(function () {
    //     var dateFormat = $('.dateru input').datepicker('getDate');
    //     var value = $.datepicker.formatDate('yy-mm-dd', dateFormat);
    //     console.log(value)
    //     $(this).attr('value', value).val();
    // });
    $('#reservationdate_start').datetimepicker({
        format: 'YYYY-MM-DD',
        locale: 'ru',

    });
    $(' #reservationdate_end').datetimepicker({
        format: 'YYYY-MM-DD',
        locale: 'ru',

    });
    // $('.select2').select2({
    //     placeholder: 'Выберите теги',
    // });
    // $('#tag_lists').select2({
    //     placeholder: 'Выберите теги',
    //     tags: true
    //    data: [
    //        {id: 'one', text: 'One'},
    //        {id: 'two', text: 'Two'}
    //
    //    ]
    //
    // });

    // $('#catalog_lists').select2({
    //     placeholder: 'Выберите категории',
    //     catalogs: true
    // });


}(jQuery));



//    ckeditor init
var options = {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
};
(function ($) {
    $('[data-toggle="tooltip"]').tooltip()
    $('textarea.editor').ckeditor(options);
}(jQuery))

