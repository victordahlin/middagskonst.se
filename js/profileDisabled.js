$( document ).ready(function() {
    var date = new Date();
    var day = date.getDay();
    var hours = date.getHours();

    // Customer not allowed to change bags between sunday 21 until tuesday 21
    if((day == 6 && hours >= 21) || day == 1 || day == 2 && hours <= 21){
        $("table > tbody > tr").each(function(){
            // Find row and input then add disabled class
            $(this).find('input').addClass('disabled');
        });
    }
});
