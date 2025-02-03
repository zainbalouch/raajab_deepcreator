<?php
/**
 * Customizer Control: Sorter.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2020, David Vongries
 * @license     https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Sortable control (uses checkboxes).
 */
class Kirki_Control_Sorter extends Kirki_Control_Base {

    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'kirki-sorter';

    /**
     * An Underscore (JS) template for this control's content (but not its container).
     *
     * Class variables for this control class are available in the `data` JS object;
     * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
     *
     * @see WP_Customize_Control::print_template()
     *
     * @access protected
     */
    protected function content_template() {
        ?>
        <label class='kirki-sorter'>
			<span class="customize-control-title">
				{{{ data.label }}}
			</span>
            <# if ( data.description ) { #>
            <span class="description customize-control-description">{{{ data.description }}}</span>
            <# } #>

            <ul class="sorter">
                <# _.each( data.value, function( choiceID ) { #>
                <li {{{ data.inputAttrs }}} class='kirki-sorter-item' data-value='{{ choiceID }}'>
                    <i class='dashicons dashicons-menu'></i>
                    <i class="dashicons dashicons-visibility visibility"></i>
                    {{{ data.choices[ choiceID ] }}}
                </li>
                <# }); #>
                <# _.each( data.choices, function( choiceLabel, choiceID ) { #>
                <# if ( -1 === data.value.indexOf( choiceID ) ) { #>
                <li {{{ data.inputAttrs }}} class='kirki-sorter-item invisible' data-value='{{ choiceID }}'>
                    <i class='dashicons dashicons-menu'></i>
                    <i class="dashicons dashicons-visibility visibility"></i>
                    {{{ data.choices[ choiceID ] }}}
                </li>
                <# } #>
                <# }); #>
            </ul>
        </label>
        <?php
    }
}
