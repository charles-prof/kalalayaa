<?php
/**
 * Staff Login Branding & Experience
 *
 * Transforms wp-login.php with the authentic, vibrant, and energetic
 * essence of Kalalayaa Schools & Fine Arts. Replaces WordPress default
 * branding with the Kalalayaa emblem, photographic twilight backdrop,
 * Playfair Display typography, and campus pills.
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Kalalayaa_Login_Branding
 */
class Kalalayaa_Login_Branding {

	/**
	 * Constructor — registers login hooks.
	 */
	public function __construct() {
		add_action( 'login_enqueue_scripts', array( $this, 'enqueue_login_styles' ) );
		add_filter( 'login_headerurl',         array( $this, 'custom_login_header_url' ) );
		add_filter( 'login_headertext',        array( $this, 'custom_login_header_title' ) );
		add_filter( 'login_message',           array( $this, 'custom_login_banner' ) );
		add_action( 'login_footer',            array( $this, 'render_login_footer' ) );
	}

	/**
	 * Enqueue Google Fonts and the custom SMACSS login module stylesheet.
	 */
	public function enqueue_login_styles() {
		// Enqueue Google Fonts (Playfair Display + Inter) for the login screen.
		wp_enqueue_style(
			'kalalayaa-login-fonts',
			'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600;1,700&display=swap',
			array(),
			null
		);

		// Enqueue Kalalayaa login module stylesheet.
		wp_enqueue_style(
			'kalalayaa-login-branding',
			get_theme_file_uri( 'assets/css/modules/login.css' ),
			array( 'kalalayaa-login-fonts' ),
			'2.0.0'
		);

		// Dynamic asset URLs for background and logo.
		$bg_photo   = esc_url( get_theme_file_uri( 'assets/photos/annualdayfunctions.jpg' ) );
		$logo_image = esc_url( get_theme_file_uri( 'assets/images/logo.jpeg' ) );

		$custom_css = ":root { --kalalayaa-login-bg: url('{$bg_photo}'); --kalalayaa-login-logo: url('{$logo_image}'); }";
		wp_add_inline_style( 'kalalayaa-login-branding', $custom_css );
	}

	/**
	 * Link logo back to the Kalalayaa hub homepage.
	 *
	 * @return string
	 */
	public function custom_login_header_url() {
		return home_url( '/' );
	}

	/**
	 * Accessible title attribute for the login logo.
	 *
	 * @return string
	 */
	public function custom_login_header_title() {
		return __( 'Kalalayaa Schools & Fine Arts — Staff & Educator Portal', 'kalalayaa' );
	}

	/**
	 * Injects a simple, uncluttered guidance message above the login card.
	 *
	 * @param string $message Existing login message.
	 * @return string
	 */
	public function custom_login_banner( $message ) {
		$guidance = '<p class="kalalayaa-login-guidance">' . esc_html__( 'Log in to share events, milestones & moments from your campus with our parent community.', 'kalalayaa' ) . '</p>';

		return $guidance . $message;
	}

	/**
	 * Renders a clean, unobtrusive footer note below the login container.
	 */
	public function render_login_footer() {
		?>
		<div class="kalalayaa-login-footer-note" aria-hidden="true">
			Kalalayaa Schools &amp; Fine Arts &bull; Tiruchirappalli
		</div>
		<?php
	}
}
