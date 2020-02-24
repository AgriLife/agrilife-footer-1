<?php
/**
 * Master Naturalist - AgriFlex4
 *
 * @package      agrilife-footer-1
 * @author       Zachary Watkins
 * @copyright    2019 Texas A&M AgriLife Communications
 * @license      GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name:  AgriLife Footer 1
 * Plugin URI:   https://github.com/AgriLife/agrilife-footer-1
 * Description:  A plugin for footer design #1 for AgriLife affiliated WordPress websites.
 * Version:      0.1.0
 * Author:       Zachary Watkins
 * Author URI:   https://github.com/ZachWatkins
 * Author Email: zachary.watkins@ag.tamu.edu
 * Text Domain:  agrilife-footer-1
 * License:      GPL-2.0+
 * License URI:  http://www.gnu.org/licenses/gpl-2.0.txt
 */

/* Define some useful constants */
define( 'AF1_DIRNAME', 'agrilifefooter1' );
define( 'AF1_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'AF1_DIR_FILE', __FILE__ );
define( 'AF1_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'AF1_TEXTDOMAIN', 'agrilifefooter1' );
define( 'AF1_TEMPLATE_PATH', AF1_DIR_PATH . 'templates' );

/**
 * The core plugin class that is used to initialize the plugin
 */
require AF1_DIR_PATH . 'src/class-agrilifefooter1.php';
spl_autoload_register( 'AgrilifeFooter1::autoload' );
AgrilifeFooter1::get_instance();

/* Activation hooks */
register_activation_hook( __FILE__, 'agrilifefooter1_activation' );

/**
 * Helper option flag to indicate rewrite rules need flushing
 *
 * @since 0.1.0
 * @return void
 */
function agrilifefooter1_activation() {

	// Check for missing dependencies.
	$theme = wp_get_theme();
	if ( 'AgriFlex4' !== $theme->name ) {
		$error = sprintf(
			/* translators: %s: URL for plugins dashboard page */
			__(
				'Plugin NOT activated: The <strong>AgrilifeFooter1 - AgriFlex4</strong> plugin needs the <strong>AgriFlex4</strong> theme to be installed and activated first. <a href="%s">Back to plugins page</a>',
				'agrilife-footer-1'
			),
			get_admin_url( null, '/plugins.php' )
		);
		wp_die( wp_kses_post( $error ) );
	}

}
