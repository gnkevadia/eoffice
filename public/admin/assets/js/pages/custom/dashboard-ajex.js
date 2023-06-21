$(document).ready(function () {
    $(document).on('click', '.punchIn_btn', function () {
        $(this).hide();
        $(this).prop('disabled', true);
        $.ajax({
            url: 'dashboard/punchin',
            type: 'get',
            success: function (data) {
                $('.punchIn').html('<p class="my-2 mx-4"> Your Punch in Time is ' + data + '</p> <div class="kt-widget20__content p-0"> <button class="btn btn-success btn-md  btn-bold punchOut_btn">  Punch Out </button> </div>')
                console.log(data);
            }
        });
    })
    $(document).on('click', '.punchOut_btn', function () {
        $.ajax({
            url: 'dashboard/punchout',
            type: 'get',
            success: function (data) {
                $('.punchOut').html('<p class="my-2 mx-4"> Your Punch out Time is ' + data + '</p>')
            }
        });
        $(this).removeClass('btn-success');
        $(this).addClass('btn-secondary');
    })

});