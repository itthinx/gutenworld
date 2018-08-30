/*!
 * gutenworld.js
 *
 * Copyright (c) "kento" Karim Rahimpur www.itthinx.com
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
 * @author itthinx
 * @package gutenworld
 * @since 1.0.0
 */

if ( typeof wp !== 'undefined' ) {

	wp.blocks.registerBlockType(
		'gutenworld/hi',
		{
			title    : 'GutenWorld',
			icon     : 'universal-access-alt',
			category : 'layout',
			// renders the block in the editor
			edit     : function( props ) {
				return wp.element.createElement(
					'p',
					{
						style : {
							backgroundColor: '#990',
							color: '#fff',
							padding: '20px'
						},
						className : props.className
					},
					gutenworld.edit_content
				);
			},
			// renders the block on the front end
			save     : function( props ) {
				return wp.element.createElement(
					'p',
					{
						style : {
							backgroundColor: '#909',
							color: '#fff',
							padding: '20px'
						},
						className : props.className
					},
					gutenworld.save_content
				);
			}
		}
	);
}
