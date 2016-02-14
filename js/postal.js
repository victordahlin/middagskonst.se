$(document).ready(function () {
    var danger = $('#danger').hide();
    var success = $('#success').hide();

    $('form').submit(function (e)
    {
        e.preventDefault();
        var postData = $(this).serializeArray();
        var formURL = $(this).attr('action');

        var request = $.ajax({
            url: formURL,
            type: 'POST',
            data: postData,
            dataType: 'html'
        });

        request.done(function (form)
        {
            if (form == "true") {
                success.show();
                danger.hide();
            }
            else {
                success.hide();
                danger.show();
            }
        });
    });
});
