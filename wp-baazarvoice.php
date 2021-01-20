<?php
/**
 * Plugin Name:     BaazarVoice Integration
 * Plugin URI:      https://knowledge.bazaarvoice.com/
 * Description:     An integration for Baazarvoice that ties into ACF, so that reviews may be displayed on a page.
 * Author:          Kanopi Studios
 * Author URI:      https://kanopi.com/
 * Text Domain:     baazarvoice-intergration
 * Domain Path:     /languages
 * Version:         1.0.2
 *
 * @package         Wp_Baazarvoice
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BAZAARVOICE_PLUGIN_VERSION', '1.0' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and API hooks.
 */
require plugin_dir_path( __FILE__ ) . 'inc/classes/class-wp-baazarvoice.php';

/**
 * The Baazarvoice DSK that we need for this to work.
 */
require plugin_dir_path( __FILE__ ) . 'inc/seo_sdk_php-master/bvseosdk.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_baazarvoice_integrate() {

	$plugin = new Wp_Baazarvoice();
	$plugin->run();

}
run_baazarvoice_integrate();

/**
 * Enqueue BazaarVoice-related scripts.
 *
 * @return void
 */
function bazaarvoice_enqueue_scripts() {
	$plugin_options = get_option( 'Wp_Baazarvoice_options' );
	if ( ! empty( $plugin_options['bv_site'] ) ) :
		if ( is_product() ) :
			wp_register_script( 'bv-ratings', plugin_dir_url( __FILE__ ) . 'inc/js/reviews.js', array( 'jquery' ), time(), true );
		endif;
		wp_localize_script( 'bv-ratings', 'bvSettings', $plugin_options );
		wp_enqueue_script( 'bv-ratings' );
	endif;
}
add_action( 'wp_enqueue_scripts', 'bazaarvoice_enqueue_scripts' );

/**
 * Create shortcode to display the Bazaarvoice Reviews container.
 *
 * @return string $html The shortcode content.
 */
function bazaarvoice_reviews_container() {

	$html = '<div id="BVRRContainer"></div>';

	return $html;
}
add_shortcode( 'bazaarvoice_reviews', 'bazaarvoice_reviews_container' );

/**
 * Create shortcode to display the Bazaarvoice average star rating per product.
 *
 * @return string $html The shortcode content.
 */
function bazaarvoice_star_ratings() {

	$html = '<div id="underTitleReviews"><div id="BVRRSummaryContainer"></div></div>';

	return $html;
}
add_shortcode( 'bazaarvoice_star_ratings', 'bazaarvoice_star_ratings' );





