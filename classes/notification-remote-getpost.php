<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Class for our redirect notification type.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Notifications
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.8
*/

class NF_Action_Remote_Get_Post extends NF_Notification_Base_Type
{

	/**
	 * Get things rolling
	 */
	function __construct() {
		parent::__construct();
		$this->name = __( 'Remote Get/Post', 'ninja-forms' );
	}

	/**
	 * Output our edit screen
	 *
	 * @access public
	 * @since 2.8
	 * @return void
	 */
	public function edit_screen( $id = '' ) {
		?>
		<tr>
			<th scope="row"><label for="settings-remote_url"><?php _e( 'Remote Url', 'ninja-forms' ); ?></label></th>
			<td><input type="text" name="settings[remote_url]" id="settings-remote_url" value="<?php echo esc_attr( nf_get_object_meta_value( $id, 'remote_url' ) ); ?>" class="regular-text"/></td>
		</tr>
		<tr>
			<th scope="row"><?php _e( 'Key - Field Pairs', 'ninja-forms-conditionals' ); ?></th>
			<td>
				<div id="nf_key_field_pairs" class="nf-key-field-pairs">
					<div class="nf-key-field-pairs-title">
						<a href="#" class="nf-key-field-pair-add button-secondary add"><div class="dashicons dashicons-plus-alt"></div> <?php _e( 'Add', 'ninja-forms-conditionals' ); ?></a> <?php _e( 'These key / field value sets will be sent to the remote URL', 'ninja-forms' ); ?> 
					</div>
				</div>
			</td>
		</tr>

		<script type="text/html" id="tmpl-nf-key-field-pairs">
			<div class="single-key-field nf-key-field-pair" id="">
				<a href="#" class="nf-key-field-pair-delete delete-cr" style=""><div class="dashicons dashicons-dismiss"></div></a>
				<input type="text" name="keyfieldpair[<#= object_id #>][key]" value="<#= pair.key #>" placeholder="key">
				-
				<input name="keyfieldpair[<#= object_id #>][field]" type="text" id="" value="<#= pair.field #>" class="nf-tokenize" placeholder="" data-type="all" />
				<span class="howto"><?php _e( 'Email will appear to be from this email address.', 'ninja-forms' ) ?></span>
			</div>
		</script>
		<?php
	}

	/**
	 * Add our custom JS
	 *
	 * @access public
	 * @since 2.8
	 * @return false
	 */
	public function add_js( $id = '' ) {
		// Get a list of our key field pairs and output them as a JSON string.
		$children = nf_get_object_children( 2, 'keyfieldpair' );
		wp_localize_script( 'nf-notifications', 'nf_keyfieldpairs', $children );
	}

	/**
	 * Save admin edit screen
	 *
	 * @access public
	 * @since 2.8
	 * @return void
	 */
	public function save_admin( $id = '', $data ) {
		if ( isset ( $data['keyfieldpair'] ) && is_array( $data['keyfieldpair'] ) ) {
			if ( isset ( $data['keyfieldpair']['new'] ) ) {
				unset ( $data['keyfieldpair']['new'] );
			}

			foreach ( $data['keyfieldpair'] as $object_id => $vars ) {
				nf_update_object_meta( $object_id, 'key', $vars['key'] );
				nf_update_object_meta( $object_id, 'field', $vars['field'] );
			}

			unset( $data['keyfieldpair'] );
		}

		return $data;
	}

	/**
	 * Process our Redirect notification
	 *
	 * @access public
	 * @since 2.8
	 * @return void
	 */
	public function process( $id ) {
		global $ninja_forms_processing;

		$redirect_url = Ninja_Forms()->notification( $id )->get_setting( 'redirect_url' );

		$ninja_forms_processing->update_form_setting( 'landing_page', $redirect_url );
	}

}

return new NF_Action_Remote_Get_Post();