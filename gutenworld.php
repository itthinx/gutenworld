<?php
/**
 * gutenworld.php
 * 
 * Copyright (c) 2018 "kento" Karim Rahimpur www.itthinx.com
 * 
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 * 
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * This header and all notices must be kept intact.
 * 
 * @author Karim Rahimpur
 * @package gutenworld
 * @since gutenworld 1.0.0
 *
 * Plugin Name: GutenWorld
 * Plugin URI: http://www.itthinx.com/
 * Description: Hello World! Hello Gutenberg! An example.
 * Version: 1.0.0
 * Author: itthinx
 * Author URI: http://www.itthinx.com
 * Donate-Link: http://www.itthinx.com/shop/
 * License: GPLv3
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

const GUTENWORLD_VERSION = '1.0.0';

/**
 * This main plugin class takes care of registering its script and its block type.
 */
class GutenWorld {

	/**
	 * Adds our init action.
	 */
	public static function boot() {
		add_action( 'init', array( __CLASS__,'init' ) );
	}

	/**
	 * Registers our script and our block type.
	 */
	public static function init() {

		add_shortcode( 'gutenworld', array( __CLASS__, 'shortcode' ) );

		// Only proceed if we have Gutenberg ...
		if ( function_exists( 'register_block_type' ) ) {

			// Our script used to edit and render the block.
			wp_register_script(
				'gutenworld',
				plugins_url( 'js/gutenworld.js', __FILE__ ),
				array( 'wp-blocks', 'wp-element' )
			);

			// String translations for the script.
			wp_localize_script(
				'gutenworld',
				'gutenworld',
				array(
					// gutenworld/hi
					'edit_content' => __( 'This is the GutenWorld example block.', 'gutenworld' ),
					'save_content' => __( 'Hello World! Hello Gutenberg!', 'gutenworld' ),
					// gutenworld/saywhat
					'say_label' => __( 'Say what?', 'gutenworld' ),
					'say_placeholder' => __( 'What can I say ... ?', 'gutenworld' ),
					// gutenworld/shortcode
					'header_tag_label' => __( 'Header Tag', 'gutenworld' ),
					'header_tag_placeholder' => __( 'Enter the header tag to use (h1 ... h6 or heading).', 'gutenworld' ),
					'content_tag_label' => __( 'Content Tag', 'gutenworld' ),
					'content_tag_placeholder' => __( 'Enter the content tag to use (p,span or div).', 'gutenworld' ),
					'editing_note' => __( 'Editing block settings &hellip;', 'gutenworld' ),
					// keywords / aliases to help find the blocks (using the same on all) - the handbook says you can only add three https://wordpress.org/gutenberg/handbook/block-api/
					'keyword_hello' => __( 'hello', 'gutenworld' ),
					'keyword_example' => __( 'example', 'gutenworld' ),
					'keyword_tutorial' => __( 'tutorial', 'gutenworld' ),
					'shortcode_content_placeholder' => __( 'Input optional content rendered below the heading here &hellip;', 'gutenworld' )
				)
			);

			// Our editor stylesheet.
			wp_register_style(
				'gutenworld-editor',
				plugins_url( 'css/editor.css', __FILE__ ),
				array( 'wp-edit-blocks' ),
				GUTENWORLD_VERSION
			);

			// Our front end stylesheet.
			wp_register_style(
				'gutenworld',
				plugins_url( 'css/gutenworld.css', __FILE__ ),
				array(),
				GUTENWORLD_VERSION
			);

			// Our block type named gutenworld/hi
			register_block_type(
				'gutenworld/hi',
				array(
					'editor_script' => 'gutenworld',
					'editor_style'  => 'gutenworld-editor',
					'style'         => 'gutenworld'
				)
			);

			// Our block type named gutenworld/hey
			register_block_type(
				'gutenworld/hey',
				array(
					'editor_script' => 'gutenworld',
					'editor_style'  => 'gutenworld-editor',
					'style'         => 'gutenworld'
				)
			);

			// Our block type named gutenworld/saywhat
			register_block_type(
				'gutenworld/saywhat',
				array(
					'editor_script' => 'gutenworld',
					'editor_style'  => 'gutenworld-editor',
					'style'         => 'gutenworld'
				)
			);

			// This block uses our shortcode
			register_block_type(
				'gutenworld/shortcode',
				array(
					'editor_script' => 'gutenworld',
					'editor_style'  => 'gutenworld-editor',
					'style'         => 'gutenworld',
					'attributes' => array(
						'header_tag' => array(
							'type' => 'string',
							'default' => 'h2'
						),
						'content_tag' => array(
							'type' => 'string',
							'default' => 'p'
						),
						'content' => array(
							'type' => 'string',
							'default' => ''
						)
					),
					'render_callback' => array( __CLASS__, 'shortcode' ),
				)
			);
		}
	}

	/**
	 * The [gutenworld] shortcode handler.
	 *
	 * @param array $atts shortcode attributes, allowed keys and values: header_tag: h1...h6 and heading, content_tag: p, span or div
	 * @param string $content enclosed content
	 *
	 * @return string output
	 */
	public static function shortcode( $atts, $content = '' ) {

		$defaults = array(
			'header_tag'  => 'h2',
			'content_tag' => 'p',
			'content'     => ''
		);

		$params = shortcode_atts(
			$defaults,
			$atts
		);

		// Take the content from the block if it isn't empty.
		if ( strlen( $params['content'] ) > 0 && strlen( $content ) === 0 ) {
			$content = $params['content'];
		}

		foreach ( $params as $key => $value ) {
			switch( $key ) {
				case 'header_tag' :
					switch ( $value ) {
						case 'h1' :
						case 'h2' :
						case 'h3' :
						case 'h4' :
						case 'h5' :
						case 'h6' :
						case 'heading' :
							break;
						default :
							$value = $defaults[$key];
					}
					break;
				case 'content_tag' :
					switch ( $value ) {
						case 'p' :
						case 'span' :
						case 'div' :
							break;
						default :
							$value = $defaults[$key];
					}
					break;
			}
			$params[$key] = $value;
		}

		$output = '<' . esc_attr( $params['header_tag'] ) . '>';
		$output .= esc_html__( 'Hello World! Hello Gutenberg!', 'gutenworld' );
		$output .= '</' . esc_attr( $params['header_tag'] ) . '>';
		$output .= '<' . esc_attr( $params['content_tag'] ) . '>';
		$output .= esc_html( $content );
		$output .= '</' . esc_attr( $params['content_tag'] ) . '>';

		return $output;
	}
}

// Start up
GutenWorld::boot();
