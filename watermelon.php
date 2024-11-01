<?php
/**
 * Plugin Name: Watermelon
 * Plugin URI: https://watermelon.co
 * Description: Create the ultimate customer experience or generate leads with Livechat and a code-free Chatbot.
 * Version: 1.0.2
 * Author: Watermelon
 * Author URI: https://watermelon.co
 */

// create custom plugin settings menu.

add_action( 'admin_menu', 'watermelon_menu' );


/**
 * Register the Watermelon menu item
 */
function watermelon_menu() {

	add_menu_page(
		'Watermelon',
		'Watermelon',
		'administrator',
		'watermelon',
		'watermelon_settings_page',
		plugins_url( '/watermelon/assets/img/watermelon.png' )
	);

	add_action( 'admin_init', 'register_watermelon_settings' );
}

/**
 * Register the watermelon settings group with the option name
 */
function register_watermelon_settings() {
	register_setting( 'watermelon-settings-group', 'watermelon_api_key' );
}

/**
 * Generate the Settings page content
 */
function watermelon_settings_page() {

	?>
	<div class="wrap">
		<h1>Watermelon Key</h1>

        <?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'watermelon-settings-group' ); ?>
			<?php do_settings_sections( 'watermelon-settings-group' ); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Key</th>
					<td>
						<input type="text" name="watermelon_api_key" value="<?php echo esc_attr( get_option( 'watermelon_api_key' ) ); ?>" />
					</td>
				</tr>
			</table>

			<?php submit_button(); ?>

		</form>
	</div>
	<?php
}

add_action( 'wp_head', 'watermelon_script' );
/**
 * Add the Watermelon script to the head of the DOM when a api_key is set.
 */
function watermelon_script() {
	if ( get_option( 'watermelon_api_key' ) ) :
		?>
		<script type="text/javascript">
			window.Watermelon = window.Watermelon || {};
			window.Watermelon.key = "<?php echo esc_attr( get_option( 'watermelon_api_key' ) ); ?>";
			window.Watermelon.toggled = false;
			(function(d,s) {
				s = d.createElement('script');
				s.type = 'text/javascript';
				s.async = true;
				s.src = "https://wm-livechat-2-prod-dot-watermelonmessenger.appspot.com/assets/js/wm_plugin.js";
				d.getElementsByTagName('script')[0].appendChild(s);
			}(document));
</script>
		<?php
endif;
}

add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'watermelon_action_link' );
/**
 * Add the Watermelon settings page as a quick link on the plugin page
 *
 * @param $links $links Retrieve the links when calling the function.
 * @return array
 */
function watermelon_action_link( $links ) {
	$links = array_merge(
		array(
			'<a href="' . esc_url( admin_url( '/admin.php?page=watermelon' ) ) . '">' . __( 'Settings' ) . '</a>',
		),
		$links
	);

	return $links;
}

