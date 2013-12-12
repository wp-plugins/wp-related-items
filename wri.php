<?php
/*
Plugin Name: WP Related Items (WRI) by WebshopLogic
Plugin URI: http://webshoplogic.com/product/wp-related-items-lite-wri-plugin/
Description: Would you like to offer some related products to your blog posts from your webshop? Do you have an event calendar plugin, end want to suggest some programs to an article? Do you have a custom movie catalog plugin and want to associate some articles to your movies? You need WordPress Related Items plugin, which supports cross post type relationships.
Version: 1.0.3
Author: WebshopLogic
Author URI: http://webshoplogic.com/
License: GPLv2 or later
Text Domain: wri
Requires at least: 3.7.1
Tested up to: 3.7.1
*/


if ( ! class_exists( 'WRI' ) ) {

class WRI {


	function __construct() {


		global $wri_is_premium, $wri_general_settings;

		$wri_is_premium = FALSE;



		include_once( 'wri-utils.php' );
		include_once( 'wri-admin-page.php' );

		add_action( 'init', array( $this, 'init' ), 0 );

		register_activation_hook( __FILE__, array( $this, 'wri_activation' ) );

		$wri_general_settings = get_option('wri_general_settings');

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); //is_plugin_active needs to include this
		if ( 1 == $wri_general_settings['enable_plugin'] && is_plugin_active('yet-another-related-posts-plugin/yarpp.php')) {  //if WRI plugin and yarpp is ENABLED

			include_once( 'wri-widget.php' );
			include_once( 'phpthumb/ThumbLibWRI.inc.php' );
			include_once( 'wri-woocommerce.php' );
			include_once( 'wri-woocommerce-product-archive-customiser.php' );

			define( 'ACF_LITE', true ); //remove all visual interfaces of ACF plugin
			include_once( 'advanced-custom-fields/acf.php' );
			include_once( 'wri-admin-manual_relations.php' );



			add_filter( 'the_content', array( $this, 'the_wri_content_page_bottom' ), 1200 );

			add_filter('wri_choose_template', array( $this, 'wri_choose_template'),10,6);
			//special templates can be inserted this filter (e.g. WooCommerce)

			do_action( 'wri_intagration_init' );





		}

	}

	public function init() {

		load_plugin_textdomain( 'wri', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		global $wri_admin_page;
		$wri_admin_page = new WRI_Admin_Page;

		$wri_general_settings = get_option('wri_general_settings');
		if ( 1 == $wri_general_settings['enable_plugin'] && is_plugin_active('yet-another-related-posts-plugin/yarpp.php')) {  //if WRI plugin and yarpp is ENABLED

			add_filter( 'body_class', array( $this, 'wri_item_columns_class' ) ); //column handling part

			global $wri_manual_relationships;
			$wri_manual_relationships = new WRI_manual_relationships;

			$this->template_url = apply_filters( 'wri_template_url', 'wri/' );

			do_action( 'wri_init' );

		}

	}

	public function wri_activation() {

		require_once(ABSPATH . 'wp-admin/includes/file.php');

		$url = wp_nonce_url('themes.php?page=example','example-theme-options');
		if (false === ($creds = request_filesystem_credentials($url, '', false, false, null) ) ) {
			return;
		}

		if ( ! WP_Filesystem($creds) ) {
			request_filesystem_credentials($url, '', true, false, null);
			return;
		}

		$stylesheet_dir = get_stylesheet_directory();

		$plugin_dir = $this->plugin_path();

		global $wp_filesystem;
		if ( !$wp_filesystem->mkdir($stylesheet_dir . '/wri_template', FS_CHMOD_DIR) )
			new WP_Error('mkdir_failed', __('Could not create directory.','wri'), $stylesheet_dir . '/wri_template');

		if ( ! copy_dir( $plugin_dir . '/wri_template', $stylesheet_dir . '/wri_template')
		 ) {
    		echo __('Error copying file!','wri');
		}
	}


	//public $css_dependency_array = array('woocommerce_frontend_styles-css'); //This plugin overrides some css styles of other plugins


	public $plugin_path;

	public $template_url;




	function the_wri_content_page_bottom($content) {
		if ( in_the_loop() ) {

			remove_filter( 'the_content', array( $this, 'the_wri_content_page_bottom' ), 1200 );
			$content =
				apply_filters('wri_content_clear_start','<div class="wri_content_clear_both">')
				. $content
				. apply_filters('wri_content_clear_end','</div>')
				. $this->wri_display_related('on_page', 'bottom', null, TRUE)
				. $this->promote_text();

			add_filter( 'the_content', array( $this, 'the_wri_content_page_bottom' ), 1200 );
		}
	return $content;
	}


	function promote_text() {

		global $wri_general_settings, $wri_no_result;

		$ret = null;

		if ( 1 == $wri_general_settings['promote'] and !$wri_no_result) {

			$ret = '<div class="wri_promote" >'
				. (__('Related items is presented by WebshopLogic Related Items Plugin.'))
				. '</div>';

		}
		return $ret;
	}

	function wri_display_related($placement, $position, $widget_instance, $enable_title) {


		ob_start();

		global $wpdb, $post;

		$reference_post_type_name = get_post_type();

		$wri_general_settings = get_option('wri_general_settings');

		if (is_array($wri_general_settings['wri_used_posttypes'])) {

			$wri_used_posttypes = array_keys( $wri_general_settings['wri_used_posttypes'] );

			if (in_array($reference_post_type_name, $wri_used_posttypes)) {  //reference post type is supported by WRI?

				unset($reference2related_option_array);    // This deletes the whole array

				//Collect the options into an array (for ordering)
				foreach ($wri_used_posttypes as $wri_used_posttype) {

					$reference2related_option_array[]=get_option( 'wri_reference2related_items__' . $reference_post_type_name . '--' . $wri_used_posttype );

				}

				if ( is_array($reference2related_option_array) ) {

					// Obtain a list of columns for sort field, then short the array by display order

					foreach ($reference2related_option_array as $key => $value) {
					    $tmp[$key]  = $value['display_order'];
					}

					array_multisort($tmp, SORT_ASC, $reference2related_option_array);

					$yarpp_option = get_option('yarpp');

					$singular = is_singular();

					foreach ($reference2related_option_array as $reference2related_option) {

						if (
								('on_page' == $placement && $singular && $reference2related_option['position'] == $position) //in case of on_page display, if position is fit
								||('on_page' == $placement && !$singular && $reference2related_option['position_in_archive'] == $position)
								||('on_widget' == $placement && $reference2related_option['related_posttype'] == $widget_instance['related_posttype'] //or in case of on_widget display and widget's related type is match
									&& ('just_on_widget' == $reference2related_option['position'] ||'1' != $widget_instance['hide_if_duplicate']) // and if the position setting is 'just on widget' or if not, but the hide_id_duplicate is turned off
								  )
							) {

							$related_option = get_option( 'wri_related_items___' . $reference2related_option['related_posttype'] );  //get related_item options

							$wri_template = '';
							$wri_template = apply_filters('wri_choose_template', '', $placement, $position, $widget_instance, $related_option, $reference2related_option);

							$option_array=array(
									// Pool options: these determine the "pool" of entities which are considered
									'post_type' => array( $reference2related_option['related_posttype'] ),
									//'show_pass_post' => false, // show password-protected posts
									//'past_only' => false, // show only posts which were published before the reference post
									//'exclude' => array(), // a list of term_taxonomy_ids. entities with any of these terms will be excluded from consideration.
									//'recent' => false, // to limit to entries published recently, set to something like '15 day', '20 week', or '12 month'.

									// Relatedness options: these determine how "relatedness" is computed
									// Weights are used to construct the "match score" between candidates and the reference post
									//'weight' => array(
									//	'body' => 1,
									//	'title' => 2, // larger weights mean this criteria will be weighted more heavily
									//	'tax' => array(
									//		'post_tag' => 1,
									//		'category' => 1
											//... put any taxonomies you want to consider here with their weights
									//	)
									//),
									// Specify taxonomies and a number here to require that a certain number be shared:
									//'require_tax' => array(
									//	'post_tag' => 1 // for example, this requires all results to have at least one 'post_tag' in common.
									//),
									// The threshold which must be met by the "match score"
									'threshold' => (int) nvl($widget_instance['match_threshold'], $reference2related_option['match_threshold']),
									// Display options:
									'template' => $wri_template, // either the name of a file in your active theme or the boolean false to use the builtin template
									'limit' => (int) nvl($widget_instance['display_limit'],nvl( $reference2related_option['display_limit'], $yarpp_option['limit'] )), // maximum number of results
									'order' => nvl($widget_instance['order'],nvl( $reference2related_option['order'], $yarpp_option['order'] )), // e.g. 'score DESC'
									'wri_title' => $enable_title ? $related_option['title'] : '',
									'wri_before_title_tags' => $related_option['before_title_tags'],
									'wri_after_title_tags' => $related_option['after_title_tags'],
									'wri_no_result_display_text' => nvl($related_option['no_result_display'], $yarpp_option['no_results']),

									'wri_thumbnail_width' => (int) $widget_instance['thumbnail_width'],
									'wri_thumbnail_height' => (int) $widget_instance['thumbnail_height'],
									'wri_maximum_excerpt_characters' => (int) $widget_instance['maximum_excerpt_characters']

							);

							$option_array = array_diff($option_array, array('')); //Remove empty (null) array elements. This is important because setup_active_cache function of yapp may baypass cache because of a null value

							$wri_yarpp_related_options = ($option_array
								//,$reference_ID // second argument: (optional) the post ID. If not included, it will use the current post.
								//,true // third argument: (optional) true to echo the HTML block; false to return it
							);


							$wri_yarpp_related_options = apply_filters('wri_yarpp_related_options', $wri_yarpp_related_options); //you can change related options array using this filter

							yarpp_related($wri_yarpp_related_options);

						}

					wp_reset_postdata();

					} //end for

				} //end if

			} //end if

		} //end_if

		$content = ob_get_clean();

		return $content;

	}

	public function wri_choose_template($val, $placement, $position, $widget_instance, $related_option, $reference2related_option) {

		if ('on_page' == $placement) {

			if ( !empty($reference2related_option['custom_template']) )
				$wri_template = $reference2related_option['custom_template'];
			elseif ('list' == $reference2related_option['list_thumbnail'])
				$wri_template = 'wri_template/template-wri-list.php';
			elseif ('thumbnail' == $reference2related_option['list_thumbnail'])
				$wri_template = 'wri_template/template-wri-thumbnails.php';
			elseif ('yarpp_thumbnail' == $widget_instance['list_thumbnail'])
				$wri_template = 'thumbnails';  //use yarpp own default thumbnail templat

		}

		elseif ('on_widget' == $placement) {

			if ( !empty($widget_instance['custom_template']) )
				$wri_template = $reference2related_option['custom_template'];
			elseif ('list' == $widget_instance['list_thumbnail'])
				$wri_template = 'wri_template/template-wri-list-widget.php';
			elseif ('thumbnail' == $widget_instance['list_thumbnail'])
				$wri_template = 'wri_template/template-wri-thumbnails-widget.php';
			elseif ('yarpp_thumbnail' == $widget_instance['list_thumbnail'])
				$wri_template = 'thumbnails';  //use yarpp own default thumbnail templat

		}

		return nvl($wri_template, $val);

	}


	public function plugin_path() {
		if ( $this->plugin_path ) return $this->plugin_path;

		return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

	public function plugin_url() {
		if ( $this->plugin_url ) return $this->plugin_url;
		return $this->plugin_url = untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	public function wri_supported_post_types($output) { // 'names' or 'objects'
		//all post type that supported in WRI

		$ret = get_post_types(array('public'=>true, 'publicly_queryable'=>true, 'show_ui'=>true), $output);
		$ret = array_merge( $ret, get_post_types(array('name'=>'page'), $output));

		$ret = apply_filters('wri_supported_post_types', $ret);

		return $ret;

	}

	public function wri_used_post_types($output) { // 'names' or 'objects'
		//a subset of WRI supported post types, according to user choice

		$ret=array();
		$wri_general_settings = get_option('wri_general_settings');



		if ( is_array( $wri_general_settings['wri_used_posttypes'] ) ) {
			foreach ( array_keys( $wri_general_settings['wri_used_posttypes'] ) as $act_wri_used_posttype_name ) {

				$ret = array_merge($ret, get_post_types(array('name'=>$act_wri_used_posttype_name), $output) );
				//$ret[] = get_post_types(array('name'=>$act_wri_used_posttype_name), $output);

			}
		}

		$ret = apply_filters('wri_used_post_types' ,$ret);

		return $ret;

	}

	public function get_featured_image_path() {

		$post_id = get_the_ID();
		$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );
		$image_url_parts = parse_url($image_url[0]);
		$image_path = $image_url_parts['path'];
		return $image_path;

	}

	public function get_thumb_url($thumbnail_path, $thumbnail_width, $thumbnail_height) {

		$thumb_store_dir = 'thumb_store';  //under plugin path

		$server_base_path = $_SERVER["DOCUMENT_ROOT"];

		$thumbnail_path = $server_base_path . $thumbnail_path;

		$thumbnail_path_components = pathinfo( $thumbnail_path );

		$thumb_store_filename = urlencode( $thumbnail_path_components['filename']
												. '-wri-' . $thumbnail_width . 'x' . $thumbnail_height
												. '.' . $thumbnail_path_components['extension'] );

		$thumb_store = $thumb_store_dir . '/' . $thumb_store_filename;


		if ( file_exists( $this->plugin_path . $thumb_store ) ) { //if already exists, use it, else make new one

			$ret =  $this->plugin_url() . '/' . $thumb_store;

		} else {


				$thumb = PhpThumbFactoryWRI::create( $thumbnail_path );

				$thumb->adaptiveResize( $thumbnail_width, $thumbnail_height );

				$thumb->save( $this->plugin_path() . '/' . $thumb_store );

				$ret = $this->plugin_url() . '/' . $thumb_store;

		}

		return $ret;

	}




	function wri_item_columns_class( $classes ) {

		$post_type = get_post_type();

		$options = get_option( 'wri_related_items___' . $post_type );
		$column_option = $options['thumbnail_columns_number'];

		if ( isset( $column_option ) and $column_option != 0 and $column_option != null and in_array($column_option, array(2, 3, 5)) ) {//if column number is set for the actual post type, let's use it, else use the original
			$columns = $column_option;
			$classes[] = 'wri-item-columns-' . $columns;
		}

		return $classes;
	}



}

//Init wri class
$GLOBALS['wri'] = new WRI();

}
