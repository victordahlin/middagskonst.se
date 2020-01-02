$(document).ready(function () {
    var validator = $('#checkout').validate({ // initialize the plugin
        rules: {
            firstName: "required",
            lastName: "required"
        },
        messages: {
            firstName: "Ni har glömt att fylla i ditt förnamn",
            lastName: "Ni har glömt att fylla i ditt efternamn"
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block'
    })
});
