<?php
/**
 * WP Remote Post Receiver
 *
 * A file that retrieves values from a POST request and then renders
 * the markup for the request.
 *
 * @package   WP_Remote_Post
 * @author    Tom McFarlin <tom@tommcfarlin.com>
 * @license   GPL-2.0+
 * @link      http://tommcfarlin.com
 * @copyright 2013 Tom McFarlin
 */

// Build up the HTML display of of the data
$html = '<div id="wp-remote-post-example-container">';

	$html .= '<h4>The Post Data</h4>';

	$html .= '<ul>';

	foreach( $_POST as $key => $value ) {
		$html .= '<li>' . $key . ': ' . $value . '</li>';
	} // end foreach

	$html .= '</ul>';

$html .= '</div><!-- /#wp-remote-post-example-container -->';

// Finally, echo the HTML to the requester
echo $html;
