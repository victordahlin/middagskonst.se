$( document ).ready(function() {
  $(".trigger-button").click(function(){
        $(this).next().toggle();
  });
});