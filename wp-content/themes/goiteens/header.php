<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GoITeens
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/header-navigation.css" />
	<!-- Google Tag Manager -->
    <script>
      (function (w, d, s, l) {
        w[l] = w[l] || [];
        w[l].push({
          'gtm.start': new Date().getTime(),
          event: 'gtm.js',
        });
        var f = d.getElementsByTagName(s)[0],
          j = d.createElement(s),
          dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src = "https://www.googletagmanager.com/gtm.js?id=<?php the_field('gtm', 'option'); ?>" + dl;
        f.parentNode.insertBefore(j, f);
      })(window, document, 'script', 'dataLayer');
    </script>
    <!-- End Google Tag Manager -->

    <?php
    if( get_locale() == 'pl_PL' && (7584 === get_the_ID() || 4008 === get_the_ID()) ) {
        ?>
        <!-- Google Tag Manager Poland -->
        <script>
            (function (w, d, s, l) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js',
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src = "https://www.googletagmanager.com/gtm.js?id=GTM-TQF6X5Z" + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer');
        </script>
        <!-- End Google Tag Manager Poland -->
        <?php
    }
    ?>

    <script>
	<?php if(is_page_template('templates/tmpl-referral-page.php') || is_page_template('templates/tmpl-courses-all-page.php')) :?>
 		<?php $marketingList = get_field('all_marketing_data');
		if( $marketingList ): ?>
        	<?php foreach($marketingList as $item ): ?>
				window.product<?php echo ucfirst("{$item['product_title']}"); ?> = '<?php echo "{$item['product_name']}"; ?>';
				window.product<?php echo ucfirst("{$item['product_title']}"); ?>Id = '<?php echo "{$item['product_id']}"; ?>';
		 	<?php endforeach; ?>
		 <?php endif; ?>
// 		сторінка блогу
  <?php elseif(get_the_ID() == 6429) :?>
			window.productName = 'GoITeens_ Subscription';
		window.productId = '1819773000310041375';
		<?php else :?>
		window.productName = '<?php echo get_field('product_name'); ?>';
		window.productId = '<?php echo get_field('product_id'); ?>';
  <?php endif; ?>

      window.leelooHash = '<?php echo get_field('leeloo_hash'); ?>';
		<?php if(get_the_ID() == 4862): ?>
		window.leelooHashKid = '<?php echo get_field('leeloo_hash_kid'); ?>';
		<?php endif; ?>
	  window.leadFormat = '<?php echo get_field('lead_format'); ?>';
        window.leadapi = 'MarLeadAPI';
    </script>
</head>

<body <?php body_class(); ?>>
<noscript>
    <iframe
        src="https://www.googletagmanager.com/ns.html?id=<?php the_field('gtm', 'option'); ?>"
        height="0"
        width="0"
        style="display: none; visibility: hidden"
      >
    </iframe>
    </noscript>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'goiteens' ); ?></a>

