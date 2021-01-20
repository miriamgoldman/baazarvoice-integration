<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.kanopistudios.com
 * @since      1.0.0
 *
 * @package    Wp_Baazarvoice
 * @subpackage Wp_Baazarvoice/inc
 */

/**
 * The wrapper around the core Workable API.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Baazarvoice
 * @subpackage Wp_Baazarvoice/inc
 * @author     Miriam Goldman <miriam@kanopistudios.com>
 */
class Wp_Baazarvoice_Wrapper {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The Workable API key for the application.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $api_key    The current application API key.
	 */
	private $api_key;

	/**
	 * The Workable API path for the application.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var      string    $api_path   The current application API path.
	 */
	private $api_path;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$options = get_option( 'Wp_Baazarvoice_options' );

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->cloud_key   = $options['field_cloud_key'];
		$this->external_id = $options['field_external_id'];
		$this->site_name   = $options['field_bvsitename'];
	}

}
