<?php
/**
 * The file that defines css and js files loaded for the plugin
 *
 * A class definition that includes css and js files used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/AgriLife/agrilife-footer-1/blob/master/src/class-assets.php
 * @since      0.1.0
 * @package    agrilife-footer-1
 * @subpackage agrilife-footer-1/src
 */

namespace AgrilifeFooter1;

/**
 * Add assets
 *
 * @since 0.1.0
 */
class Assets {

	/**
	 * Initialize the class
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function __construct() {

		// Register global styles used in the theme.
		add_action( 'wp_enqueue_scripts', array( $this, 'register_styles' ), 1 );

		// Enqueue extension styles.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 1 );

	}

	/**
	 * Registers all styles used within the plugin
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function register_styles() {

		wp_register_style(
			'agrilifefooter1-styles',
			AF1_DIR_URL . 'css/style.css',
			false,
			filemtime( AF1_DIR_PATH . 'css/style.css' ),
			'screen'
		);

	}

	/**
	 * Enqueues extension styles
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'agrilifefooter1-styles' );

	}

}
