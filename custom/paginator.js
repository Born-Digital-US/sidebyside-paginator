$(function() {
  // var $appeared = $('#appeared');
  // var $disappeared = $('#disappeared');
  //
  // $('section h3').appear();
  // $('#force').on('click', function() {
  //   $.force_appear();
  // });

  $(document.body).on('appear', 'a.scroll-trigger', function(e, $affected) {
    // this code is executed for each appeared element

    $('#page-scroller').scrollTo( $("#page-2"), {duration:30} )
  });

  $(document.body).on('disappear', 'a.scroll-trigger', function(e, $affected) {
    // this code is executed for each disappeared element

    // intentionally blank for the time being
  });
});
