<?php

/**
 * Template Name: Interpretation Side-by-Side Paginator
 */

get_header();

?>
    <style media="screen">
      .site-header {padding: 1em 4em !important;}
      img.page {max-height: 600px;}
      #narrative, #page-scroller { max-width: 45%;}
      #narrative {margin-bottom: 600px;}
      #page-scroller {position: fixed; margin-left: 50%; height: 600px; overflow-y: scroll;}
    </style>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="http://cdn.jsdelivr.net/jquery.scrollto/2.1.2/jquery.scrollTo.min.js"></script>
    <script >
    /*
     * jQuery appear plugin
     *
     * Copyright (c) 2012 Andrey Sidorov
     * licensed under MIT license.
     *
     * https://github.com/morr/jquery.appear/
     *
     * Version: 0.3.6
     */
    (function($) {
      var selectors = [];

      var check_binded = false;
      var check_lock = false;
      var defaults = {
        interval: 250,
        force_process: false
      };
      var $window = $(window);

      var $prior_appeared = [];

      function appeared(selector) {
        return $(selector).filter(function() {
          return $(this).is(':appeared');
        });
      }

      function process() {
        check_lock = false;
        for (var index = 0, selectorsLength = selectors.length; index < selectorsLength; index++) {
          var $appeared = appeared(selectors[index]);

          $appeared.trigger('appear', [$appeared]);

          if ($prior_appeared[index]) {
            var $disappeared = $prior_appeared[index].not($appeared);
            $disappeared.trigger('disappear', [$disappeared]);
          }
          $prior_appeared[index] = $appeared;
        }
      }

      function add_selector(selector) {
        selectors.push(selector);
        $prior_appeared.push();
      }

      // "appeared" custom filter
      $.expr[':'].appeared = function(element) {
        var $element = $(element);
        if (!$element.is(':visible')) {
          return false;
        }

        var window_left = $window.scrollLeft();
        var window_top = $window.scrollTop();
        var offset = $element.offset();
        var left = offset.left;
        var top = offset.top;

        if (top + $element.height() >= window_top &&
            top - ($element.data('appear-top-offset') || 0) <= window_top + $window.height() &&
            left + $element.width() >= window_left &&
            left - ($element.data('appear-left-offset') || 0) <= window_left + $window.width()) {
          return true;
        } else {
          return false;
        }
      };

      $.fn.extend({
        // watching for element's appearance in browser viewport
        appear: function(options) {
          var opts = $.extend({}, defaults, options || {});
          var selector = this.selector || this;
          if (!check_binded) {
            var on_check = function() {
              if (check_lock) {
                return;
              }
              check_lock = true;

              setTimeout(process, opts.interval);
            };

            $(window).scroll(on_check).resize(on_check);
            check_binded = true;
          }

          if (opts.force_process) {
            setTimeout(process, opts.interval);
          }
          add_selector(selector);
          return $(selector);
        }
      });

      $.extend({
        // force elements's appearance check
        force_appear: function() {
          if (check_binded) {
            process();
            return true;
          }
          return false;
        }
      });
    })(function() {
      if (typeof module !== 'undefined') {
        // Node
        return require('jquery');
      } else {
        return jQuery;
      }
    }());

    /* Custom code written for scroll control */
    $(function() {

      $('a.scroll-trigger').appear();

      $('a.scroll-trigger').on('appear', function(event, $all_appeared_elements) {
          // this element is now inside browser viewport

          // e.g. $('#page-scroller').scrollTo( $( "#page-2" ), {duration:30} );
          $('#page-scroller').scrollTo( $( "#page-"+$all_appeared_elements[0].rel ), {duration:300} );

          //alert('hi');
        });
      });
    </script>

<div id="primary">
	<div id="content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
      <!-- Page view pane -->
      <div class="pages pane" id="page-scroller">
        <article>
          <?php $document = get_field('document'); ?>
          <?php if( !empty($document) ): ?>
            <img class="page" src="<?php echo get_field('page_1', $document->ID)['url']; ?>" alt="Page 1" id="page-1" />
            <img class="page" src="<?php echo get_field('page_2', $document->ID)['url']; ?>" alt="Page 2" id="page-2" />
            <img class="page" src="<?php echo get_field('page_3', $document->ID)['url']; ?>" alt="Page 3" id="page-3" />
          <?php endif; ?>
        </article>
      </div>

      <!-- Content pane -->
      <div class="pane" id="narrative">
        <article>
			       <h1><?php the_title(); ?></h1>

			       <?php the_content(); ?>
        </article>
      </div>
		<?php endwhile; // end of the loop. ?>

	</div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>
