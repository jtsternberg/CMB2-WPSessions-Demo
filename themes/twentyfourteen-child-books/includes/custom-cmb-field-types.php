<?php
/**
 * Holds any custom CMB2 field types
 *
 * @category Twenty Fourteen -- BOOKS!
 * @package  Theme's custom field types
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2/wiki/Adding-your-own-field-types
 */

if ( ! function_exists( 'cmb2_get_state_options' ) ) :
/**
 * Returns options markup for a state select field.
 * @param  mixed $value Selected/saved state
 * @return string       html string containing all state options
 */
function cmb2_get_state_options( $value = false ) {
	$state_list = array( 'AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado','CT'=>'Connecticut','DE'=>'Delaware','DC'=>'District Of Columbia','FL'=>'Florida','GA'=>'Georgia','HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois','IN'=>'Indiana','IA'=>'Iowa','KS'=>'Kansas','KY'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland','MA'=>'Massachusetts','MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana','NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico','NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma','OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island','SC'=>'South Carolina','SD'=>'South Dakota','TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington','WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming' );

	$state_options = '';
	foreach ( $state_list as $abrev => $state ) {
		$state_options .= '<option value="'. $abrev .'" '. selected( $value, $abrev, false ) .'>'. $state .'</option>';
	}

	return $state_options;
}
endif;

if ( ! function_exists( 'cmb2_render_address_field_callback' ) ) :
/**
 * Render Address Field
 * @link https://github.com/WebDevStudios/CMB2/wiki/Adding-your-own-field-types#example-4-multiple-inputs-one-field-lets-create-an-address-field
 */
function cmb2_render_address_field_callback( $field, $value, $post_id, $object_type, $field_type ) {

	// make sure we setup the entire value array
	$value = wp_parse_args( $value, array(
		'address-1' => '',
		'address-2' => '',
		'city'      => '',
		'state'     => '',
		'zip'       => '',
	) );

	?>
	<div><p><label for="<?php echo $field_type->_id( '_address_1' ); ?>"><?php _e( 'Address 1', 'wpsessions' ); ?></label></p>
		<?php echo $field_type->input( array(
			'name'  => $field_type->_name( '[address-1]' ),
			'id'    => $field_type->_id( '_address_1' ),
			'value' => $value['address-1'],
			'desc'  => '',
		) ); ?>
	</div>
	<div><p><label for="<?php echo $field_type->_id( '_address_2' ); ?>'"><?php _e( 'Address 2', 'wpsessions' ); ?></label></p>
		<?php echo $field_type->input( array(
			'name'  => $field_type->_name( '[address-2]' ),
			'id'    => $field_type->_id( '_address_2' ),
			'value' => $value['address-2'],
			'desc'  => '',
		) ); ?>
	</div>
	<div class="alignleft"><p><label for="<?php echo $field_type->_id( '_city' ); ?>'"><?php _e( 'City', 'wpsessions' ); ?></label></p>
		<?php echo $field_type->input( array(
			'class' => 'cmb_text_small',
			'name'  => $field_type->_name( '[city]' ),
			'id'    => $field_type->_id( '_city' ),
			'value' => $value['city'],
			'desc'  => '',
		) ); ?>
	</div>
	<div class="alignleft"><p><label for="<?php echo $field_type->_id( '_state' ); ?>'"><?php _e( 'State', 'wpsessions' ); ?></label></p>
		<?php echo $field_type->select( array(
			'name'    => $field_type->_name( '[state]' ),
			'id'      => $field_type->_id( '_state' ),
			'options' => cmb2_get_state_options( $value['state'] ),
			'desc'  => '',
		) ); ?>
	</div>
	<div class="alignleft"><p><label for="<?php echo $field_type->_id( '_zip' ); ?>'"><?php _e( 'Zip', 'wpsessions' ); ?></label></p>
		<?php echo $field_type->input( array(
			'class' => 'cmb_text_small',
			'name'  => $field_type->_name( '[zip]' ),
			'id'    => $field_type->_id( '_zip' ),
			'value' => $value['zip'],
			'desc'  => '',
			'type'  => 'number',
		) ); ?>
	</div>
	<br class="clear">
	<?php
	echo $field_type->_desc( true );

}
endif;
add_filter( 'cmb2_render_address', 'cmb2_render_address_field_callback', 10, 5 );
