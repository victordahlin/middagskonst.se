$(document).ready(function(){
    $("a.menu").click(function(){
        var id = $(this).children().val();
        $('input[name=option]').val(id);
        $("form").submit();
    });
});