<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/AgriLife/agrilife-footer-1/blob/master/src/class-genesis.php
 * @since      0.1.0
 * @package    agrilife-footer-1
 * @subpackage agrilife-footer-1/src
 */

namespace AgrilifeFooter1;

/**
 * The core plugin class
 *
 * @since 0.1.0
 * @return void
 */
class Genesis {

	/**
	 * Initialize the class
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'init' ) );

		// Modify footer.
		add_filter( 'genesis_structural_wrap-footer', array( $this, 'class_footer_wrap' ), 12 );
		add_action( 'genesis_footer', array( $this, 'genesis_footer_widget_area' ), 7 );
		add_filter( 'dynamic_sidebar_params', array( $this, 'add_widget_class' ) );
		add_action( 'genesis_footer', array( $this, 'add_copyright' ), 9 );

	}

	/**
	 * Initialize the various classes
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function init() {

		global $af_required;

		// Custom footer.
		remove_action( 'genesis_footer', array( $af_required, 'render_tamus_logo' ), 10 );

		// Add new widget areas.
		$this->add_widget_areas();

	}

	/**
	 * Adds sidebars
	 *
	 * @since 0.1.0
	 * @return void
	 */
	private function add_widget_areas() {

		// Footer.
		if ( function_exists( 'genesis_register_sidebar' ) ) {

			genesis_register_sidebar(
				array(
					'name'        => __( 'Footer - Contact and Social', 'af4-college' ),
					'id'          => 'footer-left',
					'description' => __( 'This is the first widget area for the site footer.', 'af4-college' ),
				)
			);

			genesis_register_sidebar(
				array(
					'name'        => __( 'Footer - Menu', 'af4-college' ),
					'id'          => 'footer-right',
					'description' => __( 'This is the second widget area for the site footer.', 'af4-college' ),
				)
			);

		}

	}

	/**
	 * Add class name to widget elements
	 *
	 * @since 0.1.0
	 * @param array $params Widget parameters.
	 * @return array
	 */
	public function add_widget_class( $params ) {

		// Add class to outer widget container.
		$str = $params[0]['before_widget'];
		preg_match( '/class="([^"]+)"/', $str, $match );
		$classes = explode( ' ', $match[1] );

		if ( in_array( 'widget', $classes, true ) ) {

			// Add class to all footer widgets.
			if ( in_array( $params[0]['id'], array( 'footer-left', 'footer-right' ), true ) ) {
				$classes[] = 'cell';

				// Add order classes to widgets.
				if ( 'footer-right' === $params[0]['id'] ) {
					$classes[] = 'medium-6 small-12 medium-order-2';
				} elseif ( false !== strpos( $params[0]['widget_id'], 'agrilife_contact' ) ) {
					$classes[] = 'medium-order-2';
				} elseif ( in_array( $params[0]['widget_name'], array( 'AddToAny Share', 'AddToAny Follow' ), true ) ) {
					$classes[] = 'medium-order-3';
				}

				$class_output               = implode( ' ', $classes );
				$params[0]['before_widget'] = str_replace( $match[0], "class=\"{$class_output}\"", $params[0]['before_widget'] );

			}
		}

		return $params;

	}

	/**
	 * Change footer wrap class names
	 *
	 * @since 0.1.0
	 * @param string $output The wrap HTML.
	 * @return string
	 */
	public function class_footer_wrap( $output ) {

		$output = preg_replace( '/\s?grid-container\s?/', ' ', $output );
		$output = preg_replace( '/\s?grid-x\s?/', ' ', $output );
		$output = preg_replace( '/\s?grid-padding-x\s?/', ' ', $output );
		$output = preg_replace( '/class=" /', 'class="', $output );

		return $output;
	}

	/**
	 * Add footer widget areas
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function genesis_footer_widget_area() {

		echo '<div class="footer-info grid-container"><div class="grid-x grid-padding-x">';

		genesis_widget_area(
			'footer-right',
			array(
				'before' => '',
				'after'  => '',
			)
		);

		echo '<div class="cell medium-order-1 medium-6 small-12"><div class="grid-x">';

		genesis_widget_area(
			'footer-left',
			array(
				'before' => '',
				'after'  => '',
			)
		);

		$logo_choices = array(
			'white' => AF1_DIR_URL . 'images/TAMAgVCwhite.png',
			'black' => AF1_DIR_URL . 'images/TAMAgVCblack.png',
			'gray'  => AF1_DIR_URL . 'images/TAMAgVCgray.png',
			'color' => AF1_DIR_URL . 'images/TAMAgVCm&g.png',
		);

		$logo = sprintf(
			'<div class="logo cell medium-order-1"><a href="%s" title="Texas A&M AgriLife"><img src="%s" alt="Texas A&M AgriLife" /></a></div>',
			trailingslashit( home_url() ),
			$logo_choices['white']
		);

		$logo = apply_filters( 'agrilife_footer_1_logo', $logo, $logo_choices['white'], $logo_choices );

		echo wp_kses_post( $logo );

		echo '</div></div></div></div>';

	}

	/**
	 * Add copyright notice
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function add_copyright() {

		echo wp_kses_post( '<p class="center">&copy; ' . date( 'Y' ) . ' Texas A&amp;M University. All rights reserved.</p>' );

	}
}
