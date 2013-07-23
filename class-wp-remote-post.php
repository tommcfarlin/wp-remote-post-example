<?php
/**
 * WP Remote Post Example
 *
 * An example plugin demonstrating how to use `wp_remote_post`.
 *
 * @package   WP_Remote_Post
 * @author    Tom McFarlin <tom@tommcfarlin.com>
 * @license   GPL-2.0+
 * @link      http://tommcfarlin.com
 * @copyright 2013 Tom McFarlin
 */

/**
 * WP Remote Post Example
 *
 * An example plugin demonstrating how to use `wp_remote_post`.
 *
 * @package   WP_Remote_Post
 * @author    Tom McFarlin <tom@tommcfarlin.com>
 */
class WP_Remote_Post_Example {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_style_sheet' ) );
		add_action( 'the_content', array( $this, 'get_post_response' ) );

	} // end __construct

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;

	} // end get_instance

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'wprp-example', FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	} // end load_plugin_textdomain

	/**
	 * Add adds the plugin style sheet to the single post page.
	 *
	 * @since     1.0.0
	 */
	public function add_style_sheet() {

		if( is_single() ) {
			wp_enqueue_style( 'wp-remote-post-example-style', plugins_url( 'wp-remote-post-example/css/display.css' ) );
		} // end if

	} // end add_style_seet

	/**
	 * Appends the post response after making a request to the receiver to the content.
	 *
	 * @param     string    $content    The post content.
	 * @return    string    $content    The modified content included the post information.
	 * @since     1.0.0
	 */
	public function get_post_response( $content ) {

		// If we're on a single page...
		if( is_single() ) {

			// Go ahead and set the ID, site URL, and permalink for this page to variables
			$unique_id = $_SERVER['REMOTE_ADDR'];
			$site_url = site_url();
			$page_url = get_permalink();

			// Grab the URL to the remote receiver file
			$url = plugins_url('wp-remote-post-example/wp-remote-receiver.php');

			// Make the remote request and retrieve ther esponse
			$response = wp_remote_post(
			    $url,
			    array(
					'body'    => array(
					    'unique-id'   => $unique_id,
					    'address'     => $site_url,
					    'page-viewed' => $page_url
					)
				)
			);

			// If there's an error, display a message
			if ( is_wp_error( $response ) ) {

				$html = '<div id="post-error">';
					$html .= __( 'There was a problem retrieving the response from the server.', 'wprp-example' );
				$html .= '</div><!-- /#post-error -->';

			// Otherwise, display the data and save the post meta data
			} else {

				$html = '<div id="post-success">';
					$html .= '<p>' . __( 'Your message posted with success! The response was as follows:', 'wprp-example' ) . '</p>';
					$html .= '<p id="response-data">' . $response['body'] . '</p>';
				$html .= '</div><!-- /#post-error -->';

				$this->save_post_data( $unique_id, $site_url, $page_url );

			} // end if/else

			$content .= $html;

		} // end if

		return $content;

	} // end get_post_response

	/**
	 * Appends the post response after making a request to the receiver to the content.
	 *
	 * @param     string    $unique_id  The post content.
	 * @param     string    $site_url   The post content.
	 * @param     string    $page_url   The post content.
	 * @since     1.0.0
	 */
	private function save_post_data( $unique_id, $site_url, $page_url ) {

		if ( '' == get_post_meta( get_the_ID(), 'unique_id', true ) ) {

			add_post_meta( get_the_ID(), 'unique_id', $unique_id );
			add_post_meta( get_the_ID(), 'site_url', $site_url );
			add_post_meta( get_the_ID(), 'page_url', $page_url );

		} // end if

	} // end save_post_data

} // end class