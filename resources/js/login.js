$(document).ready(function () {
    var validator = $('#checkout').validate({ // initialize the plugin
        rules: {
            email: {
                required:true,
                email:true
            },
            password: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            email: "Ni måste ange en giltig e-post address",
            password: {
                required: "Ni måste ange ett lösenord",
                minlength: "Lösenordet måste vara minst 5 bokstäver"
            }
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
