<?php
 
/*
 
Plugin Name: Blu Municipal Alerts
 
Plugin URI: https://blucreative.ca
 
Description: Create visually intuitive municipal alerts for your residents.
 
Version: 1.0
 
Author: Michael Homenok - Blu Creative
 
Author URI: https://blucreative.ca
 
License: GPLv2 or later
 
Text Domain: blu-alerts
 
*/





//Create admin settings page

class MunicipalAlerts {
	private $municipal_alerts_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'municipal_alerts_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'municipal_alerts_page_init' ) );
	}

	public function municipal_alerts_add_plugin_page() {
		add_menu_page(
			'Municipal Alerts', // page_title
			'Municipal Alerts', // menu_title
			'manage_options', // capability
			'municipal-alerts', // menu_slug
			array( $this, 'municipal_alerts_create_admin_page' ), // function
			'dashicons-info', // icon_url
			70 // position
		);
	}

	public function municipal_alerts_create_admin_page() {
		$this->municipal_alerts_options = get_option( 'municipal_alerts_option_name' ); ?>

		<div class="wrap">
			<h2>Municipal Alerts</h2>
			<p>Use this page to enable a site-wide municipal alert to be displayed at the top of every page. You can also customize the text and severity of the alert to be displayed.</p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'municipal_alerts_option_group' );
					do_settings_sections( 'municipal-alerts-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function municipal_alerts_page_init() {
		register_setting(
			'municipal_alerts_option_group', // option_group
			'municipal_alerts_option_name', // option_name
			array( $this, 'municipal_alerts_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'municipal_alerts_setting_section', // id
			'Settings', // title
			array( $this, 'municipal_alerts_section_info' ), // callback
			'municipal-alerts-admin' // page
		);

		add_settings_field(
			'enabled_0', // id
			'Enabled', // title
			array( $this, 'enabled_0_callback' ), // callback
			'municipal-alerts-admin', // page
			'municipal_alerts_setting_section' // section
		);

		add_settings_field(
			'alert_header_1', // id
			'Alert Header', // title
			array( $this, 'alert_header_1_callback' ), // callback
			'municipal-alerts-admin', // page
			'municipal_alerts_setting_section' // section
		);

		add_settings_field(
			'alert_message_2', // id
			'Alert Message', // title
			array( $this, 'alert_message_2_callback' ), // callback
			'municipal-alerts-admin', // page
			'municipal_alerts_setting_section' // section
		);
		add_settings_field(
			'alert_severity_level_3', // id
			'Alert Severity Level', // title
			array( $this, 'alert_severity_level_3_callback' ), // callback
			'municipal-alerts-admin', // page
			'municipal_alerts_setting_section' // section
		);
        add_settings_field(
			'alert_udpated_date', // id
			null, // title
			array( $this, 'alert_udpated_date_callback' ), // callback
			'municipal-alerts-admin', // page
			'municipal_alerts_setting_section' // section
		);
	}

	public function municipal_alerts_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['enabled_0'] ) ) {
			$sanitary_values['enabled_0'] = $input['enabled_0'];
		}

		if ( isset( $input['alert_header_1'] ) ) {
			$sanitary_values['alert_header_1'] = sanitize_text_field( $input['alert_header_1'] );
		}

		if ( isset( $input['alert_message_2'] ) ) {
			$sanitary_values['alert_message_2'] = esc_textarea( $input['alert_message_2'] );
		}
		if ( isset( $input['alert_severity_level_3'] ) ) {
			$sanitary_values['alert_severity_level_3'] = $input['alert_severity_level_3'];
		}
		if ( isset( $input['alert_udpated_date'] ) ) {
			$sanitary_values['alert_udpated_date'] = sanitize_text_field( $input['alert_udpated_date'] );
		}

		return $sanitary_values;
	}

	public function municipal_alerts_section_info() {
		
	}

	public function enabled_0_callback() {
		?> <fieldset><?php $checked = ( isset( $this->municipal_alerts_options['enabled_0'] ) && $this->municipal_alerts_options['enabled_0'] === 'On' ) ? 'checked' : '' ; ?>
		<label for="enabled_0-0"><input type="radio" name="municipal_alerts_option_name[enabled_0]" id="enabled_0-0" value="On" <?php echo $checked; ?>> On</label><br>
		<?php $checked = ( isset( $this->municipal_alerts_options['enabled_0'] ) && $this->municipal_alerts_options['enabled_0'] === 'Off' ) ? 'checked' : '' ; ?>
		<label for="enabled_0-1"><input type="radio" name="municipal_alerts_option_name[enabled_0]" id="enabled_0-1" value="Off" <?php echo $checked; ?>> Off</label></fieldset> <?php
	}

	public function alert_header_1_callback() {
		printf(
			'<input class="regular-text" type="text" name="municipal_alerts_option_name[alert_header_1]" id="alert_header_1" value="%s">',
			isset( $this->municipal_alerts_options['alert_header_1'] ) ? esc_attr( $this->municipal_alerts_options['alert_header_1']) : ''
		);
	}

	public function alert_message_2_callback() {
		printf(
			'<textarea class="large-text" rows="5" name="municipal_alerts_option_name[alert_message_2]" id="alert_message_2">%s</textarea>',
			isset( $this->municipal_alerts_options['alert_message_2'] ) ? esc_attr( $this->municipal_alerts_options['alert_message_2']) : ''
		);
	}

	public function alert_severity_level_3_callback() {
		?> <select name="municipal_alerts_option_name[alert_severity_level_3]" id="alert_severity_level_3">
			<?php $selected = (isset( $this->municipal_alerts_options['alert_severity_level_3'] ) && $this->municipal_alerts_options['alert_severity_level_3'] === 'Low') ? 'selected' : '' ; ?>
			<option <?php echo $selected; ?>>Low</option>
			<?php $selected = (isset( $this->municipal_alerts_options['alert_severity_level_3'] ) && $this->municipal_alerts_options['alert_severity_level_3'] === 'Medium') ? 'selected' : '' ; ?>
			<option <?php echo $selected; ?>>Medium</option>
			<?php $selected = (isset( $this->municipal_alerts_options['alert_severity_level_3'] ) && $this->municipal_alerts_options['alert_severity_level_3'] === 'High') ? 'selected' : '' ; ?>
			<option <?php echo $selected; ?>>High</option>
		</select> <?php
	}

    public function alert_udpated_date_callback() {
        $time = date('M d, Y - h:i A');
		printf(
			'<input type="hidden" name="municipal_alerts_option_name[alert_udpated_date]" id="alert_udpated_date" value="%s">',
			$time
		);
	}

}
if ( is_admin() )
	$municipal_alerts = new MunicipalAlerts();


//Include Alert Renderer
include( plugin_dir_path( __FILE__ ) . 'alert.php');


//Styles and script enqueue
function blu_alerts_enqueue(){
	wp_enqueue_style( 'styles', plugins_url('/css/styles.css', __FILE__), false, '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', "blu_alerts_enqueue");