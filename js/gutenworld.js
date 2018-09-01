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

	//
	// A fixed block.
	//
	wp.blocks.registerBlockType(
		'gutenworld/hi',
		{
			title    : 'GutenWorld',
			icon     : 'universal-access-alt',
			category : 'layout',
			keywords    : [ gutenworld.keyword_example, gutenworld.keyword_tutorial, gutenworld.keyword_hello ],
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

	//
	// A block where you can input some text.
	//
	wp.blocks.registerBlockType(
		'gutenworld/hey',
		{
			title      : 'GutenWorld Hey',
			icon       : 'universal-access-alt',
			category   : 'layout',
			attributes : {
				content : {
					type     : 'array',
					source   : 'children',
					selector : 'p'
				}
			},
			// renders the block in the editor
			edit : function( props ) {
				function onChangeContent( newContent ) {
					props.setAttributes( { content : newContent } );
				}
				return wp.element.createElement(
					wp.editor.RichText,
					{
						tagName   : 'p',
						className : props.className,
						onChange  : onChangeContent,
						value     : props.attributes.content
					}
				);
			},
			// renders the block on the front end
			save : function( props ) {
				return wp.element.createElement(
					wp.editor.RichText.Content,
					{
						tagName   : 'p',
						className : props.className,
						value     : props.attributes.content
					}
				);
			}
		}
	);

	//
	// A block with a text input field.
	//
	wp.blocks.registerBlockType(
		'gutenworld/saywhat',
		{
			title       : 'GutenWorld Say What?',
			description : 'A block with a text input field.',
			icon        : 'universal-access-alt',
			category    : 'widgets',
			keywords    : [ gutenworld.keyword_example, gutenworld.keyword_tutorial, gutenworld.keyword_hello ],
			supports    : { html : true },
			attributes  : {
				say : {
					type : 'string'
				}
			},
			edit : function( props ) {
				var say = props.attributes.say || '',
					fields = [];
				// A text input field.
				fields.push(
					wp.element.createElement(
						wp.components.TextControl,
						{
							label : gutenworld.say,
							value : say,
							onChange : function( value ) {
								props.setAttributes( {
									say : value
								} );
							},
							placeholder : gutenworld.say_placeholder
						}
					)
				);
				return fields;
			},
			// renders the block on the front end
			save : function( props ) {
				return wp.element.createElement(
					'quote',
					{
						style : {
							backgroundColor: '#ccc',
							color: '#333',
							padding: '20px'
						},
						className : props.className
					},
					props.attributes.say
				);
			}
		}
	);

	//
	// A block that renders via a PHP callback.
	// It also uses the ServerSideRender to preview the block in the editor.
	//
	wp.blocks.registerBlockType(
		'gutenworld/shortcode',
		{
			title       : 'GutenWorld Shortcode',
			description : 'Testing rendering by PHP',
			icon        : 'universal-access-alt',
			category    : 'widgets',
			keywords    : [ gutenworld.keyword_example, gutenworld.keyword_tutorial, gutenworld.keyword_hello ],
			supports    : { html : false },
			attributes  : {
				header_tag : {
					type : 'string'
				},
				content_tag : {
					type : 'string'
				},
				content : {
					type : 'string'
				}
			},
			// Add some inspector controls, use ServerSideRender to preview the block.
			edit : function( props ) {
				var header_tag = props.attributes.header_tag || 'h2',
					content_tag = props.attributes.content_tag || 'p',
					fields = [];

					fields = [
						// render the content via our PHP callback
						wp.element.createElement(
							wp.components.ServerSideRender,
							{
								block : 'gutenworld/shortcode',
								attributes : props.attributes
							}
						),
						// add the two text input fields as inspector controls -> shown in the block's settings
						wp.element.createElement(
							wp.editor.InspectorControls,
							{ key : 'inspector' },
							wp.element.createElement(
								wp.components.TextControl,
								{
									label : gutenworld.header_tag_label,
									value : header_tag,
									onChange : function( value ) {
										props.setAttributes( {
											header_tag : value
										} );
									},
									placeholder : gutenworld.header_tag_placeholder
								}
							),
							wp.element.createElement(
								wp.components.TextControl,
								{
									label : gutenworld.content_tag_label,
									value : content_tag,
									onChange : function( value ) {
										props.setAttributes( {
											content_tag : value
										} );
									},
									placeholder : gutenworld.content_tag_placeholder
								}
							)
						),
						// Add the editable content as RichText field.
						// When text is entered, it will be rendered above the RichText, too,
						// so it will look strange in the editor but it serves our purpose
						// as an example of what you could do.
						wp.element.createElement(
							wp.editor.RichText,
							{
								format : 'string',
								className : props.className,
								onChange : function( value ) {
									props.setAttributes( { content : value } );
								},
								value : props.attributes.content,
								placeholder : gutenworld.shortcode_content_placeholder
							}
						)
					];
					// Example of acting when the block is selected in the editor, we'll just add a note to illustrate it.
					if ( props.isSelected ) {
						fields.push(
							wp.element.createElement(
								'div',
								{style : {
									backgroundColor: '#eee',
									color: '#999',
									padding: '2px',
									fontSize : '9px'
								}},
								gutenworld.editing_note
							)
						);
					}
				return fields;
			},
			// It's rendered via our PHP callback so this returns simply null.
			save : function( props ) {
				return null;
			}
		}
	);

}
