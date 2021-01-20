<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.kanopistudios.com
 * @since      1.0.0
 *
 * @package    Wp_Baazarvoice
 * @subpackage Wp_Baazarvoice/inc
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Baazarvoice
 * @subpackage Wp_Baazarvoice/admin
 * @author     Katherine White <katherine@kanopistudios.com>
 */
class Wp_Baazarvoice_Admin {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-wp-baazarvoice-wrapper.php';
		$this->baazarvoice = new Wp_Baazarvoice_Wrapper( $this->plugin_name, $this->version );

	}

	/**
	 * Register settings page
	 * Create an admin page for managing API options.
	 *
	 * @return void
	 */
	public function wp_baazarvoice_settings_init() {
		// register a new setting for the workable list api configuration.
		register_setting( 'Wp_Baazarvoice', 'Wp_Baazarvoice_options' );

		// register a new section in the page.
		add_settings_section(
			'Wp_Baazarvoice_section_creds',
			__( 'Baazarvoice Settings', 'baazarvoice-intergration' ),
			array( $this, 'wp_baazarvoice_section_creds_cb' ),
			'Wp_Baazarvoice'
		);

		add_settings_field(
			'field_external_id',
			__( 'External ID', 'baazarvoice-intergration' ),
			array( $this, 'bv_external_id' ),
			'Wp_Baazarvoice',
			'Wp_Baazarvoice_section_creds',
			array(
				'label_for' => 'field_external_id',
			)
		);

		add_settings_field(
			'field_cloud_key',
			__( 'Cloud Key', 'baazarvoice-intergration' ),
			array( $this, 'bv_cloud_key' ),
			'Wp_Baazarvoice',
			'Wp_Baazarvoice_section_creds',
			array(
				'label_for' => 'field_cloud_key',
			)
		);

		add_settings_field(
			'bv_environment',
			__( 'Environment', 'baazarvoice-intergration' ),
			array( $this, 'bv_environment' ),
			'Wp_Baazarvoice',
			'Wp_Baazarvoice_section_creds',
			array(
				'label_for' => 'bv_environment',
			)
		);

		add_settings_field(
			'field_bv_sitename',
			__( 'Site Name', 'baazarvoice-intergration' ),
			array( $this, 'bv_sitename' ),
			'Wp_Baazarvoice',
			'Wp_Baazarvoice_section_creds',
			array(
				'label_for' => 'bv_site',
			)
		);

		add_settings_field(
			'bv_locale',
			__( 'Locale', 'baazarvoice-intergration' ),
			array( $this, 'bv_locale' ),
			'Wp_Baazarvoice',
			'Wp_Baazarvoice_section_creds',
			array(
				'label_for' => 'bv_locale',
			)
		);
	}


	/**
	 * Callback function: credentials section
	 *
	 * Adding introductory content to the credentials management section of
	 * the settings page.
	 *
	 * @param object $args The arguments object to print out on the admin side.
	 *
	 * @return void
	 */
	public function wp_baazarvoice_section_creds_cb( $args ) {
		?>

		<div id="<?php echo esc_attr( $args['id'] ); ?>">
			<p>Please enter your Baazarvoice Credentials below.</p>
			<p>Obtain your cloud key from the config hub. On the left panel, click "Technical Setup" > "SEO Configuration." The value will be in the "Cloud Key" field.
		</div>
		<?php
	}

	/**
	 * Callback function: Cloud Key field
	 *
	 * HTML output for the Cloud Key field.
	 *
	 * @param object $args object The arguments object to print out on the admin side.
	 *
	 * @return void
	 */
	public function bv_cloud_key( $args ) {
		// get the value of the setting we've registered with register_setting().
		$options = get_option( 'Wp_Baazarvoice_options' );
		// output the field.
		if ( ! empty( $options[ $args['label_for'] ] ) ) :
			$value = $options[ $args['label_for'] ];
		endif;

		?>
		<input type="text" size="80" id="<?php echo esc_attr( $args['label_for'] ); ?>"
		name="Wp_Baazarvoice_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo esc_attr( $value ); ?>"
		>
		<?php
	}

	/**
	 * Callback function: Baazarvoice external ID.
	 * HTML output for the external id field.
	 *
	 * @param object $args The arguments object to print out.
	 *
	 * @return void
	 */
	public function bv_external_id( $args ) {
		// get the value of the setting we've registered with register_setting().
		$options = get_option( 'Wp_Baazarvoice_options' );
		$value   = '';

		if ( ! empty( $options[ $args['label_for'] ] ) ) :
			$value = $options[ $args['label_for'] ];
		endif;
		// output the field.
		?>
		<input type="text" size="20" id="<?php echo esc_attr( $args['label_for'] ); ?>"
		name="Wp_Baazarvoice_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo esc_attr( $value ); ?>"
		>
		<?php
	}

	/**
	 * Callback function: Site Name ID.
	 * HTML output for the Site Name field - used to get the proper.
	 *
	 * @param object $args The arguments object to print out.
	 *
	 * @return void
	 */
	public function bv_sitename( $args ) {
		// get the value of the setting we've registered with register_setting().
		$options = get_option( 'Wp_Baazarvoice_options' );
		$value   = '';

		if ( ! empty( $options[ $args['label_for'] ] ) ) :
			$value = $options[ $args['label_for'] ];
		endif;
		// output the field.
		?>
		<input type="text" size="20" id="<?php echo esc_attr( $args['label_for'] ); ?>"
		name="Wp_Baazarvoice_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo esc_attr( $value ); ?>"
		>
		<?php
	}


	/**
	 * Callback function: Locale.
	 * HTML output for the Language Locale.
	 *
	 * @param object $args The arguments object to print out.
	 *
	 * @return void
	 */
	public function bv_locale( $args ) {
		// get the value of the setting we've registered with register_setting().
		$options = get_option( 'Wp_Baazarvoice_options' );
		$value   = '';

		if ( ! empty( $options[ $args['label_for'] ] ) ) :
			$value = $options[ $args['label_for'] ];
		endif;
		// output the field.
		?>
		<input type="text" size="20" id="<?php echo esc_attr( $args['label_for'] ); ?>"
		name="Wp_Baazarvoice_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo esc_attr( $value ); ?>"
		>
		<?php
	}

	/**
	 * Callback function: Environment.
	 * Determine if we will use the staging or production environment.
	 *
	 * @param object $args The arguments object to print out.
	 *
	 * @return void
	 */
	public function bv_environment( $args ) {
		// get the value of the setting we've registered with register_setting().
		$options = get_option( 'Wp_Baazarvoice_options' );
		$value   = '';

		if ( ! empty( $options[ $args['label_for'] ] ) ) :
			$value = $options[ $args['label_for'] ];
		endif;

		?>
	<select name="Wp_Baazarvoice_options[<?php echo esc_attr( $args['label_for'] ); ?>]" id="<?php echo esc_attr( $args['label_for'] ); ?>">
		<option>Please select...</option>
		<option value="staging" 
		<?php
		if ( 'staging' === $value ) {
			echo esc_attr( 'selected' ); }
		?>
		>Staging</option>
		<option value="production" 
		<?php
		if ( 'production' === $value ) {
			echo esc_attr( 'selected' ); }
		?>
		>Production</option>
	</select>
		<?php
	}



	/**
	 * Menu item for settings page
	 * Add a menu item under the default Settings area to access the
	 * settings page.
	 *
	 * @return void
	 */
	public function wp_baazarvoice_options_page() {
		// add top level menu page.
		add_options_page(
			'Baazarvoice Integration Settings',
			'WordPress Baazarvoice Integration',
			'manage_options',
			'Wp_Baazarvoice',
			array( $this, 'wp_baazarvoice_page_html' )
		);
	}


	/**
	 * Callback: Admin Page HTML
	 * Output the HTML wrapper for the API settings page.
	 *
	 * @return null
	 */
	public function wp_baazarvoice_page_html() {
		// check user capabilities.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// show error/update messages.
		settings_errors( 'Wp_Baazarvoice_messages' );
		?>

		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

			<form action="options.php" method="post" id="save_workable_options" >
				<?php
				// output security fields for the registered setting.
				settings_fields( 'Wp_Baazarvoice' );

				// output setting sections and their fields.
				do_settings_sections( 'Wp_Baazarvoice' );
				// output save settings button.
				submit_button( 'Save Settings' );
				?>
			</form>

			<h2>Instructions</h2>
			<p><strong>IMPORTANT: </strong> All the settings above must be selected for the ratings and reviews to render on the front end. </p>

			<p>For each product, you must associate the BazaarVoice Product ID to it. A suggestion is to utilize Advanced Custom Fields. This plugin is built so that it reads the BazaarVoice Product ID from <code>data-product-sku</code> placed on the <code>article</code> DOM element for each individual product.</p>

			<p>To display product reviews, use the shortcode <code>[bazaarvoice_reviews]</code> in the page or template you'd like it to render.</p>

<p>To display the star ratings, use the shortcode <code>[bazaarvoice_star_ratings]</code> in the page or template where you'd like it to render.</p>

		</div>	
		<?php
	}
}

/**
 * Function to add admin specific things.
 *
 * @return void
 */
function wp_baazarvoice_admin_scripts() {
	if ( is_admin() ) { // for Admin Dashboard Only.
		// Embed the Script on our Plugin's Option Page Only.
		if ( isset( $_GET['page'] ) && 'Wp_Baazarvoice' === $_GET['page'] ) {
			wp_enqueue_script( 'jquery-form' );
		}
	}
}
add_action( 'admin_init', 'wp_baazarvoice_admin_scripts' );


