$(function() {

  $('a.scroll-trigger').appear();

  $('a.scroll-trigger').on('appear', function(event, $all_appeared_elements) {
      // this element is now inside browser viewport

      // e.g. $('#page-scroller').scrollTo( $( "#page-2" ), {duration:30} );
      $('#page-scroller').scrollTo( $( "#page-"+$all_appeared_elements[0].rel ), {duration:300} );

      //alert('hi');
    });
});
