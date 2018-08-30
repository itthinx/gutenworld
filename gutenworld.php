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
					'edit_content' => __( 'This is the GutenWorld example block.', 'gutenworld' ),
					'save_content' => __( 'Hello World! Hello Gutenberg!', 'gutenworld' )
				)
			);

			// Our block type.
			register_block_type( 'gutenworld/hi', array(
				'editor_script' => 'gutenworld',
			) );

		}
	}
}

// Start up
GutenWorld::boot();
