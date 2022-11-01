/* global jQuery */
(function ($) {
  var $body = $('body'),
    $allAdminNotices = $('#wpbody-content>div.error:visible,' +
      '#wpbody-content>div.updated:not(.notice):visible,' +
      '#wpbody-content>div.notice:not(.updated):visible,' +
      '#wpbody-content>div.update-nag:visible,' +
      '#wpbody-content>div#message:not(.notice):not(.updated):visible,' +
      '#wpbody-content>div#wpse1_2023_complete,' + // WP Clone
      '#wpbody-content>div.ctf_notice,' + // Custom Twitter Feeds
      '#wpbody-content>div.wpstg_fivestar' // WP Stage
    ), $hanPanel = $('#hidden-admin-notices-panel'),
    $hanToggleButton = $('#hidden-admin-notices-link'),
    $hanToggleButtonWrap = $('#hidden-admin-notices-link-wrap'),
    $screenMetaLinks = $('#screen-meta-links');

  // Always run for WooCommerce pages
  // Or do not run if no applicable notices
  if (!$body.hasClass('woocommerce-embed-page') &&
    !$allAdminNotices.length) {
    return;
  }

  // Immediately add active mode class
  $body.addClass('hidden-admin-notices-active');

  // Start by moving standard notices
  $allAdminNotices.detach().appendTo($hanPanel).show();

  // Copy WP default screen meta links to conserve toggle button placement when expanded
  $screenMetaLinks.clone().appendTo($hanToggleButtonWrap);

  $hanToggleButton.on('click', function () {
    if ($hanPanel.is(':visible')) {
      $hanPanel.slideUp('fast', function () {
        $body.removeClass('hidden-admin-notices-panel-active');
        $hanToggleButton.removeClass('hidden-admin-notices-panel-active')
          .attr('aria-expanded', false);
      });
    } else {
      $body.addClass('hidden-admin-notices-panel-active');
      $hanPanel.slideDown('fast', function () {
        this.focus();
        $hanToggleButton.addClass('hidden-admin-notices-panel-active')
          .attr('aria-expanded', true);
      });
    }
  });

  // On document ready
  $(function () {
    // Monitor notices which get moved to .wrap
    var startTime = new Date().getTime(),
      interval = setInterval(function () {
        // Stop monitoring after 5 seconds
        if (new Date().getTime() - startTime > 5000) {
          clearInterval(interval);
          return;
        }
        $('#wpbody-content>.wrap>div.error,' +
          '#wpbody-content>.wrap>div.updated:not(.notice),' +
          '#wpbody-content>.wrap>div.notice:not(.updated),' +
          '#wpbody-content>.wrap>div#message:not(.notice):not(.updated)' +
          '#wpbody-content>.wrap>form>div.error,' +
          '#wpbody-content>.wrap>form>div.updated:not(.notice),' +
          '#wpbody-content>.wrap>form>div.notice:not(.updated),' +
          '#wpbody-content>.wrap>form>div#message:not(.notice):not(.updated)')
          .detach()
          .appendTo($hanPanel)
          .show();
      }, 250);
  })
})(jQuery);
