$(document).ready(function()
{
  jQuery(document).ready(function()
  {
      var date = new Date();
      var currentDate = date.getDate();
      var currentMonth = date.getMonth();
      var cancelDate = $('.date0');
      var firstThursday = parseInt($(cancelDate).html().split('-')[2],10);
      var firstMonth = parseInt($(cancelDate).html().split('-')[1],10);
      var diff = Math.abs(firstThursday-currentDate);
      var currentTime = date.getHours() + ':' + date.getMinutes();

      // Turn off PHP error
      $('.displayPHPerror').val('false');

      // Deactivate week
      if(diff < 4 || diff == 4 && currentTime >= "21:00" && currentMonth == firstMonth)
      {
          // Get first row of tables
          var cancelTR = $('.dateTR0');
          // Add bootstrap disabled class
          cancelTR.children().find('input').addClass('disabled');
          // Grey out the whole row
          cancelTR.css('color','#ccc');
          // Add text to last column in row
          cancelTR.find('td:last').html('Din order är nu på väg och kan ej avbeställas');
          // Disable checkbox
          cancelTR.children().find('input').prop('disabled', true);
          // Disable hidden input
          cancelDate.find('#weeksHidden').prop('disabled', true);
      }

      // Get all hidden fields when submit
      $("form").submit(function(e)
      {
          e.preventDefault();
          $('.skipDate').each(function()
          {
              // Disable if user have checked any
              if ($(this).is(":checked"))
              {
                  $(this).closest('tr').find("#weeksHidden").prop('disabled', true);
                  $(this).prop('disabled', true);
              }
          });
          this.submit();
      })
  });



});