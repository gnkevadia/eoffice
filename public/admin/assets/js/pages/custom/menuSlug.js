$(document).ready(function () {
    // Basic Example with form
    var form = $("#frmAddEdit").validate();
    /*$("#reset").click(function(){
        $(':input','#edit-pages-form').not(':button, :submit, :reset, :hidden').val('').prop('checked', false).prop('selected', false);
    });*/
    $('.select2').select2();
    $('.toggleslug').hide();
    $('.editslug').click(function () {
        $('.toggleslug').toggle();
        if ($('.updateslug').val() == 0) {
            $('.updateslug').val(1);
            $('#alias').removeAttr('readonly');
        } else {
            $('.updateslug').val(0);
            $('#alias').attr('readonly', 'true');
        }
    });
    $('#btnCancel').click(function () {
        $('.editslug').trigger('click');
    });
    $('#btnEdit').click(function () {
        var updateSlug = $("#updateslug").val();
        var updatedAlias = $("#alias").val();
        var id = $("#id").val();
        var csrf_token = $("#csrfToken").val();

        $.ajax({
            type: 'POST',
            url: '/admin/menu/update-slug',
            dataType: 'json',
            data: { update_slug: updateSlug, update_alias: updatedAlias, id: id, _token: csrf_token },
            success: function (response) {
                $('.editslug').trigger('click');
                $('#alias').val(response.result);
            }
        });
    });
});