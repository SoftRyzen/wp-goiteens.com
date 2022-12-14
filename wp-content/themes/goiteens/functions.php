<?php

/**
 * GoITeens functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package GoITeens
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

if (!function_exists('goiteens_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function goiteens_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on GoITeens, use a find and replace
		 * to change 'goiteens' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('goiteens', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__('Primary', 'goiteens'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'goiteens_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action('after_setup_theme', 'goiteens_setup');

/**
 * Sales Page
 */
require get_template_directory() . '/inc/_sales-page.php';

/**
 * Blog
 */
require get_template_directory() . '/inc/_blog.php';

/**
 * Yoast
 */
require get_template_directory() . '/inc/_yoast.php';

/**
 * Quiz
 */
require get_template_directory() . '/inc/quiz/_admin.php';

/**
 * Esputnik
 */
require get_template_directory() . '/inc/_esputnik.php';

/**
 * Course
 */
require get_template_directory() . '/inc/course/_child.php';

/**
 * Minecraft Page
 */
require get_template_directory() . '/inc/_minecraft-landing-page.php';

/**
 * Telegram
 */
require get_template_directory() . '/inc/_telegram.php';

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function goiteens_content_width()
{
	$GLOBALS['content_width'] = apply_filters('goiteens_content_width', 640);
}
add_action('after_setup_theme', 'goiteens_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function goiteens_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'goiteens'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'goiteens'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'goiteens_widgets_init');

/**
 * It creates a global variable called themeVar that contains the site URL, the course URL, the theme
 * URL, the CRM URL, and the CRM directory URL
 */
function localize_script()
{ ?>
	<script type="text/javascript">
		const themeVar = {
			siteURL: <?php echo json_encode(site_url()); ?>,
			course: <?php echo json_encode(site_url('/course')); ?>,
			theme: <?php echo json_encode(get_template_directory_uri()); ?>,
			CRM: <?php echo json_encode(get_template_directory_uri() . '/assets/crm/lead.php'); ?>,
			CRM_dir: <?php echo json_encode(get_template_directory_uri() . '/assets/crm'); ?>
		};
	</script><?php
}
add_action('wp_head', 'localize_script');

/**
 * Enqueue scripts and styles.
 */
function goiteens_scripts()
{
	wp_enqueue_style('goiteens-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('goiteens-style', 'rtl', 'replace');
	// 	wp_enqueue_script('jquery');



	if (!is_page_template('templates/tmpl-itmarathon-page.php') &&  !is_page_template('templates/tmpl-minecraft-page.php') && !is_page_template('templates/tmpl-design-page.php') && !is_page_template('templates/tmpl-roblox-page.php') && !is_page_template('templates/tmpl-python-start-page.php') && !is_page_template('templates/tmpl-python-start-thx-page.php') && !is_page_template('templates/tmpl-courses-all-page.php') && !is_page_template('templates/tmpl-vacancies-page.php') && !is_page_template('templates/tmpl-referral-page.php') && !is_page_template('templates/tmpl-contract-page.php') && !is_page_template('templates/tmpl-blog-page.php') && !is_page_template('templates/tmpl-game-of-teens-page.php') && !is_page_template('templates/tmpl-pl-vacancies-pm-page.php') && !is_page_template('templates/tmpl-python-page.php') && !is_page_template('templates/tmpl-frontend-junior-page.php') && !is_page_template('templates/tmpl-frontend-page.php') && !is_page_template('templates/tmpl-programming4kids-page.php')) {
		wp_enqueue_script('goiteens-styles', get_template_directory_uri() . '/assets/js/form.js', array(), _S_VERSION, true);
	}
	// 	?????????? ???????????????? ???? ???????????????? ??????????

	if (is_page_template('templates/tmpl-blog-page.php')) {
		wp_enqueue_script('subscribe-form', get_template_directory_uri() . '/assets/js/subscribe-form.js', array(), _S_VERSION, true);
	}

	if (is_page_template('templates/tmpl-minecraft-page.php')) {
		if (get_locale() == 'pl_PL') {
			if (get_the_ID() == 7584 || get_the_ID() == 4008) {
				wp_enqueue_script('goiteens-styles', get_template_directory_uri() . '/assets/js/form.js', array(), _S_VERSION, true);
			}
			else {
				wp_enqueue_script('form', get_template_directory_uri() . '/assets/js/minecraft/form.js', array(), _S_VERSION, true);
			}
			wp_enqueue_script('minecraft-pl', get_template_directory_uri() . '/assets/js/minecraft-pl.js', array(), _S_VERSION, true);
		} else if(get_the_ID() == 7520){
			wp_enqueue_script('goiteens-styles', get_template_directory_uri() . '/assets/js/form.js', array(), _S_VERSION, true);
			wp_enqueue_script('minecraft-js',  get_template_directory_uri() . '/assets/js/minecraft-no-form.js', array(), _S_VERSION, true);
		} else {

			wp_enqueue_script('minecraft-js',  get_template_directory_uri() . '/assets/js/minecraft.js', array(), _S_VERSION, true);
		}
	} elseif (is_page_template('templates/tmpl-frontend-junior-page.php')) {
		wp_enqueue_script('form-leeloo',  get_template_directory_uri() . '/assets/js/form-leeloo-true.js', array(), _S_VERSION, true);
		wp_enqueue_script('frontend-junior',  get_template_directory_uri() . '/assets/js/frontend-junior.js', array(), _S_VERSION, true);
	} elseif (is_page_template('templates/tmpl-frontend-page.php')) {
		wp_enqueue_script('form-leeloo',  get_template_directory_uri() . '/assets/js/form-leeloo-true.js', array(), _S_VERSION, true);
		wp_enqueue_script('frontend',  get_template_directory_uri() . '/assets/js/frontend.js', array(), _S_VERSION, true);
	} elseif (is_page_template('templates/tmpl-programming4kids-page.php')) {
		wp_enqueue_script('form-leeloo',  get_template_directory_uri() . '/assets/js/form-leeloo-true.js', array(), _S_VERSION, true);
		wp_enqueue_script('programming4kids',  get_template_directory_uri() . '/assets/js/programming4kids.js', array(), _S_VERSION, true);
	} elseif (is_page_template('templates/tmpl-python-page.php')) {
		wp_enqueue_script('form-leeloo',  get_template_directory_uri() . '/assets/js/form-leeloo-true.js', array(), _S_VERSION, true);
		wp_enqueue_script('python',  get_template_directory_uri() . '/assets/js/python.js', array(), _S_VERSION, true);
	} elseif (is_page_template('templates/tmpl-design-page.php')) {
		wp_enqueue_script('form-leeloo',  get_template_directory_uri() . '/assets/js/form-leeloo-true.js', array(), _S_VERSION, true);
 		wp_enqueue_script('design',  get_template_directory_uri() . '/assets/js/design.js', array(), _S_VERSION, true);
	} elseif (is_page_template('templates/tmpl-roblox-page.php')) {
		wp_enqueue_script('form-leeloo',  get_template_directory_uri() . '/assets/js/form-leeloo-true.js', array(), _S_VERSION, true);
// 		wp_enqueue_script('form-js', get_template_directory_uri() . '/assets/js/form.js', array(), _S_VERSION, true);
		wp_enqueue_script('roblox',  get_template_directory_uri() . '/assets/js/roblox.js', array(), _S_VERSION, true);
	} elseif (is_page_template('templates/tmpl-vacancies-page.php')) {
		wp_enqueue_script('vacancies',  get_template_directory_uri() . '/assets/js/vacancies.js', array(), _S_VERSION, true);
	} elseif (is_page_template('templates/tmpl-python-start-page.php')) {
		if (get_the_ID() == 6489) {
			wp_enqueue_script('fe-start',  get_template_directory_uri() . '/assets/js/fe-start-autopay.js', array(), _S_VERSION, true);
		} elseif (get_the_ID() == 6850) {
			wp_enqueue_script('design-start',  get_template_directory_uri() . '/assets/js/design-start.js', array(), _S_VERSION, true);
		} else {
			wp_enqueue_script('python-start',  get_template_directory_uri() . '/assets/js/python-start-autopay.js', array(), _S_VERSION, true);
		}
	} elseif (is_page_template('templates/tmpl-itmarathon-page.php')) {
		wp_enqueue_script('itmarathon',  get_template_directory_uri() . '/assets/js/itmarathon.js', array(), _S_VERSION, true);
	} elseif (is_page_template('templates/tmpl-courses-all-page.php')) {
		wp_enqueue_script('courses-all',  get_template_directory_uri() . '/assets/js/courses-all.js', array(), _S_VERSION, true);
	} elseif (is_page_template('templates/tmpl-referral-page.php')) {
		wp_enqueue_script('referral',  get_template_directory_uri() . '/assets/js/referral.js', array(), _S_VERSION, true);
	} elseif (is_page_template('templates/tmpl-game-of-teens-page.php')) {
		wp_enqueue_script('game-of-teens',  get_template_directory_uri() . '/assets/js/game-of-teens.js', array(), _S_VERSION, true);
	} elseif (is_page_template('templates/tmpl-python-start-thx-page.php') && is_page_template('templates/tmpl-contract-page.php')) {
		wp_enqueue_script('goiteens-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
		// 			wp_enqueue_script( 'goiteens-app', get_template_directory_uri() . '/assets/js/app.js', array(), _S_VERSION, true );
	} elseif (is_page_template('templates/tmpl-pl-vacancies-pm-page.php')) {
		wp_enqueue_script('pl-vacancies-pm', get_template_directory_uri() . '/assets/js/pl-vacancies-pm.js', array(), _S_VERSION, true);
	} elseif (is_page_template('templates/tmpl-uk-vacancies-head-of-growth.php')) {
		wp_enqueue_script('head-og-growth', get_template_directory_uri() . '/assets/js/head-of-growth.js', array(), _S_VERSION, true);
	} else {
		wp_enqueue_script('goiteens-app', get_template_directory_uri() . '/assets/js/app.js', array(), _S_VERSION, true);
	}


    wp_enqueue_script('bundle', get_template_directory_uri() . '/assets/js/bundle.js', array(), _S_VERSION, true);


	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'goiteens_scripts');

function goiteens_theme_style()
{

	//   if(is_page_template('templates/tmpl-homepage.php')) {
	//     wp_enqueue_style( 'style', get_template_directory_uri() . '/assets/css/main.css' );
	//   }



	wp_enqueue_style('input-mask-style', get_template_directory_uri() . '/assets/css/intTelInput.css');
		  if(is_page_template('templates/tmpl-homepage.php') || is_page_template('templates/tmpl-course-page.php') || is_page_template('templates/tmpl-about-page.php') || is_page_template('templates/tmpl-testimonials-page.php') || is_page_template('templates/tmpl-contacts-page.php') ) {
	   wp_enqueue_style('banner-style', get_template_directory_uri() . '/assets/css/banner-zsu.css') ;
	  }

	if (get_locale() == 'pl_PL') {
       wp_enqueue_style('style-font', get_template_directory_uri() . '/style-fonts-pl.css');
	} else {
		wp_enqueue_style('style-font', get_template_directory_uri() . '/style-fonts.css');
	}

	if (is_page_template('templates/tmpl-course-page.php')) {
		if (get_locale() == 'pl_PL') {
           wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/program-page-pl.css');
	    } else {
		   wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/program-page.css');
	    }

	} else if (is_page_template('templates/tmpl-about-page.php')) {
	    if (get_locale() == 'pl_PL') {
           wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/about-page-pl.css');
	    } else {
		wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/about-page.css');
	    }

	} else if (is_page_template('templates/tmpl-testimonials-page.php')) {
	    if (get_locale() == 'pl_PL') {
          wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/testimonials-page-pl.css');
	    } else {
		wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/testimonials-page.css');
	    }

	} else if (is_page_template('templates/tmpl-contacts-page.php')) {
	    if (get_locale() == 'pl_PL') {
          wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/contact-page-pl.css');
	    } else {
		wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/contact-page.css');
	    }

	} else if (is_page_template('templates/tmpl-contract-page.php')) {
		  if (get_locale() == 'pl_PL') {
          wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/main-pl.css');
	    } else {
		wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/main.css');
	    }
	} else if (is_page_template('templates/tmpl-minecraft-page.php')) {
	    if (get_locale() == 'pl_PL') {
        wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/minecraft-pl.css');
	    } else {
		wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/minecraft.css');
	    }

	} else  if (is_page_template('templates/tmpl-frontend-junior-page.php')) {
		wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/frontend-junior.css');
		wp_enqueue_style('main-footer-style', get_template_directory_uri() . '/assets/css/main-footer.css');
	} else if (is_page_template('templates/tmpl-frontend-page.php')) {
	    if (get_locale() == 'pl_PL') {
        	wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/frontend-pl.css');
	    } else {
			wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/frontend.css');
	    }
		wp_enqueue_style('main-footer-style', get_template_directory_uri() . '/assets/css/main-footer.css');
	} else if (is_page_template('templates/tmpl-python-page.php')) {
	    if (get_locale() == 'pl_PL') {
        	wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/python-pl.css');
	    } else {
			wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/python.css');
	    }

		wp_enqueue_style('main-footer-style', get_template_directory_uri() . '/assets/css/main-footer.css');
	} else	if (is_page_template('templates/tmpl-programming4kids-page.php')) {
	    if (get_locale() == 'pl_PL') {
        	wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/programming4kids-pl.css');
	    } else {
			wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/programming4kids.css');
	    }

	} else	if (is_page_template('templates/tmpl-design-page.php')) {
	    if (get_locale() == 'pl_PL') {
        	wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/design-pl.css');
	    } else {
			wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/design.css');
	    }

	} else	if (is_page_template('templates/tmpl-roblox-page.php')) {
	    if (get_locale() == 'pl_PL') {
        	wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/roblox-pl.css');
	    } else {
			wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/roblox.css');
	    }

	} else	if (is_page_template('templates/tmpl-vacancies-page.php')) {
		wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/main.css');
		wp_enqueue_style('style-vac', get_template_directory_uri() . '/assets/css/vacancies.css');
	} else	if (is_page_template('templates/tmpl-python-start-page.php')) {

		if (get_the_ID() == 6489) {
			wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/fe-start.css');
		} elseif (get_the_ID() == 6850) {
			wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/design-start.css');
		} else {

			wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/python-start.css');
		}


		wp_enqueue_style('main-footer-style', get_template_directory_uri() . '/assets/css/main-footer.css');
	} else	if (is_page_template('templates/tmpl-itmarathon-page.php')) {
		wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/itmarathon.css');
		wp_enqueue_style('main-footer-style', get_template_directory_uri() . '/assets/css/main-footer.css');
	} else if (is_page_template('templates/tmpl-courses-all-page.php')) {
		wp_enqueue_style('main-footer-style', get_template_directory_uri() . '/assets/css/main-footer.css');
		wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/courses-all.css');
	} else if (is_page_template('templates/tmpl-privacy-policy-page.php')) {
	    if (get_locale() == 'pl_PL') {
        	wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/main-pl.css');
	    } else {
			wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/main.css');
	    }
		wp_enqueue_style('policy-style', get_template_directory_uri() . '/assets/css/privacy-policy.css');
	} else if (is_page_template('templates/tmpl-python-start-thx-page.php')) {
		if (get_the_ID() == 6547) {
			wp_enqueue_style('python-start-thx-style', get_template_directory_uri() . '/assets/css/fe-start-thx.css');
		} elseif (get_the_ID() == 6917) {
			wp_enqueue_style('python-start-thx-style', get_template_directory_uri() . '/assets/css/design-start-thx.css');
		} else {
			wp_enqueue_style('python-start-thx-style', get_template_directory_uri() . '/assets/css/python-start-thx.css');
		}
	} else if (is_page_template('templates/tmpl-referral-page.php')) {

		wp_enqueue_style('main-footer-style', get_template_directory_uri() . '/assets/css/main-footer.css');
		wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/referral.css');
	} else if (is_page_template('templates/tmpl-game-of-teens-page.php')) {

		wp_enqueue_style('main-footer-style', get_template_directory_uri() . '/assets/css/main-footer.css');
		wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/game-of-teens.css');
	} else if(is_page_template('templates/tmpl-pl-vacancies-pm-page.php')){
wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/pl-vacancies-pm.css');
	} else if(is_page_template('templates/tmpl-uk-vacancies-head-of-growth.php')){
wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/head-of-growth.css');
	} else {
	    if (get_locale() == 'pl_PL') {
        	wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/main-pl.css');
	    } else {
			wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/main.css');
	    }
	}
    wp_enqueue_style('bundle', get_template_directory_uri() . '/assets/css/bundle.css');
}
add_action('wp_enqueue_scripts', 'goiteens_theme_style');


add_action('init', 'register_post_type_student_projects');
function register_post_type_student_projects()
{
	register_post_type('student_projects', [
		'label'  => null,
		'labels' => [
			'name'               => '?????????????? ??????????',
			'singular_name'      => '????????????',
			'add_new'            => '???????????? ????????????',
			'add_new_item'       => '???????????? ?????????? ????????????',
			'edit_item'          => '?????????????????????? ????????????',
			'new_item'           => '?????????? ????????????',
			'view_item'          => '???????????????? ????????????',
			'search_items'       => '???????????? ????????????',
			'not_found'          => '???? ????????????????',
			'not_found_in_trash' => '???? ???????????????? ?? ????????????',

		],
		'description'         => '',
		'public'              => true,
		'show_in_menu'        => null,
		'show_in_rest'        => null,
		'rest_base'           => null,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-embed-photo',
		'hierarchical'        => false,
		'supports'            => ['title', 'editor', 'custom-fields', 'excerpt'],
		'taxonomies'          => ['category'],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	]);
}

add_action('init', 'register_post_type_testemonials');
function register_post_type_testemonials()
{
	register_post_type('testemonials', [
		'label'  => null,
		'labels' => [
			'name'               => '?????????????? ??????????',
			'singular_name'      => '????????????',
			'add_new'            => '???????????? ????????????',
			'add_new_item'       => '???????????? ????????????',
			'edit_item'          => '?????????????????????? ????????????',
			'new_item'           => '?????????? ????????????',
			'view_item'          => '???????????????? ????????????',
			'search_items'       => '???????????? ????????????',
			'not_found'          => '???? ????????????????',
			'not_found_in_trash' => '???? ???????????????? ?? ????????????',

		],
		'description'         => '',
		'public'              => true,
		'show_in_menu'        => null,
		'show_in_rest'        => null,
		'rest_base'           => null,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-admin-comments',
		'hierarchical'        => false,
		'supports'            => ['title', 'editor', 'custom-fields', 'excerpt'],
		'taxonomies'          => ['category'],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	]);
}

add_action('init', 'register_post_type_parent_review');
function register_post_type_parent_review()
{
	register_post_type('parent_review', [
		'label'  => null,
		'labels' => [
			'name'               => '?????????????? ??????????????',
			'singular_name'      => '????????????',
			'add_new'            => '???????????? ????????????',
			'add_new_item'       => '???????????? ?????????? ????????????',
			'edit_item'          => '?????????????????????? ????????????',
			'new_item'           => '?????????? ????????????',
			'view_item'          => '???????????????? ????????????',
			'search_items'       => '???????????? ????????????',
			'not_found'          => '???? ????????????????',
			'not_found_in_trash' => '???? ???????????????? ?? ????????????',

		],
		'description'         => '',
		'public'              => true,
		'show_in_menu'        => null,
		'show_in_rest'        => null,
		'rest_base'           => null,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-money',
		'hierarchical'        => false,
		'supports'            => ['title', 'editor', 'custom-fields', 'excerpt'],
		'taxonomies'          => ['category'],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	]);
}

add_action('init', 'register_post_type_courses');
function register_post_type_courses()
{
	register_post_type('courses', [
		'label'  => null,
		'labels' => [
			'name'               => '???????? ??????????',
			'singular_name'      => '????????',
			'add_new'            => '???????????? ????????',
			'add_new_item'       => '???????????? ?????????? ????????',
			'edit_item'          => '?????????????????????? ????????',
			'new_item'           => '?????????? ????????',
			'view_item'          => '???????????????? ????????',
			'search_items'       => '???????????? ????????',
			'not_found'          => '???? ????????????????',
			'not_found_in_trash' => '???? ???????????????? ?? ????????????',

		],
		'description'         => '',
		'public'              => true,
		'show_in_menu'        => null,
		'show_in_rest'        => null,
		'rest_base'           => null,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-welcome-learn-more',
		'hierarchical'        => false,
		'supports'            => ['title', 'custom-fields', 'page-attributes'],
		'taxonomies'          => [],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	]);
}

add_action('init', 'register_post_type_teachers');
function register_post_type_teachers()
{
	register_post_type('teachers', [
		'label'  => null,
		'labels' => [
			'name'               => '??????????????????',
			'singular_name'      => '????????????????',
			'add_new'            => '???????????? ??????????????????',
			'add_new_item'       => '???????????? ???????????? ??????????????????',
			'edit_item'          => '?????????????????????? ??????????????????',
			'new_item'           => '?????????? ????????????????',
			'view_item'          => '???????????????? ??????????????????',
			'search_items'       => '???????????? ??????????????????',
			'not_found'          => '???? ????????????????',
			'not_found_in_trash' => '???? ???????????????? ?? ????????????',

		],
		'description'         => '',
		'public'              => true,
		'show_in_menu'        => null,
		'show_in_rest'        => null,
		'rest_base'           => null,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-groups',
		'hierarchical'        => false,
		'supports'            => ['title', 'editor', 'custom-fields', 'excerpt'],
		'taxonomies'          => ['category'],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	]);
}

add_action('init', 'register_post_type_speakers');
function register_post_type_speakers()
{
	register_post_type('speakers', [
		'label'  => null,
		'labels' => [
			'name'               => '??????????????',
			'singular_name'      => '????????????',
			'add_new'            => '???????????? ??????????????',
			'add_new_item'       => '???????????? ???????????? ??????????????',
			'edit_item'          => '?????????????????????? ??????????????',
			'new_item'           => '?????????? ????????????',
			'view_item'          => '???????????????? ??????????????',
			'search_items'       => '???????????? ??????????????',
			'not_found'          => '???? ????????????????',
			'not_found_in_trash' => '???? ???????????????? ?? ????????????',

		],
		'description'         => '',
		'public'              => true,
		'show_in_menu'        => null,
		'show_in_rest'        => null,
		'rest_base'           => null,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-megaphone',
		'hierarchical'        => false,
		'supports'            => ['title', 'editor', 'custom-fields', 'excerpt'],
		'taxonomies'          => [],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	]);
}

add_action('init', 'register_post_type_game_speakers');
function register_post_type_game_speakers()
{
	register_post_type('game_speakers', [
		'label'  => null,
		'labels' => [
			'name'               => 'GAME ??????????????',
			'singular_name'      => 'GAME ????i??????',
			'add_new'            => '???????????? ??????????????',
			'add_new_item'       => '???????????? ???????????? ??????????????',
			'edit_item'          => '?????????????????????? ??????????????',
			'new_item'           => '?????????? ????????????',
			'view_item'          => '???????????????? ??????????????',
			'search_items'       => '???????????? ??????????????',
			'not_found'          => '???? ????????????????',
			'not_found_in_trash' => '???? ???????????????? ?? ????????????',

		],
		'description'         => '',
		'public'              => true,
		'show_in_menu'        => null,
		'show_in_rest'        => null,
		'rest_base'           => null,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-megaphone',
		'hierarchical'        => false,
		'supports'            => ['title', 'editor', 'custom-fields', 'excerpt'],
		'taxonomies'          => ['category'],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	]);
}

add_action('init', 'register_post_type_partners');
function register_post_type_partners()
{
	register_post_type('partners', [
		'label'  => null,
		'labels' => [
			'name'               => '????????????????',
			'singular_name'      => '??????????????',
			'add_new'            => '???????????? ????????????????',
			'add_new_item'       => '???????????? ???????????? ????????????????',
			'edit_item'          => '?????????????????????? ????????????????',
			'new_item'           => '?????????? ??????????????',
			'view_item'          => '???????????????? ????????????????',
			'search_items'       => '???????????? ????????????????',
			'not_found'          => '???? ????????????????',
			'not_found_in_trash' => '???? ???????????????? ?? ????????????',

		],
		'description'         => '',
		'public'              => true,
		'show_in_menu'        => null,
		'show_in_rest'        => null,
		'rest_base'           => null,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-megaphone',
		'hierarchical'        => false,
		'supports'            => ['title', 'editor', 'custom-fields', 'excerpt'],
		'taxonomies'          => ['category'],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	]);
}

add_action('init', 'register_post_type_awards');
function register_post_type_awards()
{
	register_post_type('awards', [
		'label'  => null,
		'labels' => [
			'name'               => '????????????????',
			'singular_name'      => '????????????????',
			'add_new'            => '???????????? ????????????????',
			'add_new_item'       => '???????????? ???????????? ????????????????',
			'edit_item'          => '?????????????????????? ????????????????',
			'new_item'           => '???????? ????????????????',
			'view_item'          => '???????????????? ????????????????',
			'search_items'       => '???????????? ????????????????',
			'not_found'          => '???? ????????????????',
			'not_found_in_trash' => '???? ???????????????? ?? ????????????',

		],
		'description'         => '',
		'public'              => true,
		'show_in_menu'        => null,
		'show_in_rest'        => null,
		'rest_base'           => null,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-star-filled',
		'hierarchical'        => false,
		'supports'            => ['title', 'editor', 'custom-fields', 'excerpt'],
		'taxonomies'          => ['category'],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	]);
}

add_action('init', 'register_post_type_vacancies');
function register_post_type_vacancies()
{
	register_post_type('vacancies', [
		'label'  => null,
		'labels' => [
			'name'               => '????????????????',
			'singular_name'      => '????????????????',
			'add_new'            => '???????????? ????????????????',
			'add_new_item'       => '???????????? ???????????? ????????????????',
			'edit_item'          => '?????????????????????? ????????????????',
			'new_item'           => '???????? ????????????????',
			'view_item'          => '???????????????? ????????????????',
			'search_items'       => '???????????? ????????????????',
			'not_found'          => '???? ????????????????',
			'not_found_in_trash' => '???? ???????????????? ?? ????????????',

		],
		'description'         => '',
		'public'              => true,
		'show_in_menu'        => null,
		'show_in_rest'        => null,
		'rest_base'           => null,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-star-filled',
		'hierarchical'        => false,
		'supports'            => ['title', 'editor', 'custom-fields', 'excerpt'],
		'taxonomies'          => ['category'],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	]);
}
add_action('init', 'register_post_type_contract');
function register_post_type_contract()
{
	register_post_type('contract', [
		'label'  => null,
		'labels' => [
			'name'               => '????????????????',
			'singular_name'      => '??????????????',
			'add_new'            => '???????????? ??????????????',
			'add_new_item'       => '???????????? ?????????? ??????????????',
			'edit_item'          => '?????????????????????? ??????????????',
			'new_item'           => '?????????? ??????????????',
			'view_item'          => '???????????????? ??????????????',
			'search_items'       => '???????????? ??????????????',
			'not_found'          => '???? ????????????????',
			'not_found_in_trash' => '???? ???????????????? ?? ????????????',

		],
		'description'         => '',
		'public'              => true,
		'show_in_menu'        => null,
		'show_in_rest'        => null,
		'rest_base'           => null,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-star-filled',
		'hierarchical'        => false,
		'supports'            => ['title', 'editor', 'custom-fields', 'excerpt'],
		'taxonomies'          => ['category'],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	]);
}

if (function_exists('acf_add_options_page')) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

	acf_add_options_page(array(
		'page_title' 	=> 'Marketing Settings',
		'menu_title'	=> 'Marketing Settings',
		'parent_slug' 	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Modal Settings',
		'menu_title'	=> 'Modal',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Single Vacancies Settings',
		'menu_title'	=> 'Single Vacancies',
		'parent_slug'	=> 'theme-general-settings',
	));
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

require get_template_directory() . '/inc/acf-option-page.php';





// ???????????????????? ???????????? ????????????

function gp_read_time()
{
	$totalChars = wp_strip_all_tags(get_the_content());
	$totalChars = mb_strlen($totalChars, 'utf-8');
	$totalChars = round($totalChars / 1200);
	if ($totalChars <= 0) {
		$totalChars = 1;
	}
	return $totalChars;
}


add_action( 'wp_enqueue_scripts', 'mx_script' );
function mx_script(){
	//wp_enqueue_script("jquery"); //connect jQuery(if not)
	wp_enqueue_style( 'mx-css', get_template_directory_uri() . '/assets/css/mx.css', array(), rand(99,999));
}

/** if post in parent category */
if ( ! function_exists( 'post_is_in_descendant_category' ) ) {
    function post_is_in_descendant_category( $cats, $_post = null ) {
        foreach ( (array) $cats as $cat ) {
            // get_term_children() accepts integer ID only
            $descendants = get_term_children( (int) $cat, 'category' );
            if ( $descendants && in_category( $descendants, $_post ) )
                return true;
        }
        return false;
    }
}
/** end */

/**
 * Remove css js Version
 */
add_filter( 'style_loader_src', 'goiteens_remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'goiteens_remove_cssjs_ver', 10, 2 );
function goiteens_remove_cssjs_ver( $src )
{

    if( strpos( $src, '?ver=' ) )
        $src = remove_query_arg( 'ver', $src );

    return $src;

}
