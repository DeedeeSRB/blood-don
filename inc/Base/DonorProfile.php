<?php
/**
 * @package  BloodDonPlugin
 */
namespace Inc\Base;

class DonorProfile
{
	public static function register() 
	{
		add_action( 'show_user_profile', array( 'Inc\Base\DonorProfile' , 'bd_donor_usermeta_form' ) );
		add_action( 'edit_user_profile', array( 'Inc\Base\DonorProfile' , 'bd_donor_usermeta_form' ) );
		  
		add_action( 'personal_options_update', array( 'Inc\Base\DonorProfile' , 'bd_usermeta_form_field_update' ) );
		add_action( 'edit_user_profile_update', array( 'Inc\Base\DonorProfile' , 'bd_usermeta_form_field_update' ) );
	}

	public static function bd_donor_usermeta_form( $user )
	{
		?>
		<h3>Your Donor Profile</h3>
		<table class="form-table">
			<tr>
				<th>
					<label for="birthday">Blood Group</label>
				</th>
				<td>
					<select id="bd_donor_usermeta_blood_group" value="<?= esc_attr( get_user_meta( $user->ID, 'blood_group', true ) ) ?>"
							name="bd_donor_usermeta_blood_group" class="regular-text ltr"> <?php
							$options = array( 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-' );
							foreach( $options as $option ) {
								if ( $option == get_user_meta( $user->ID, 'blood_group', true ) ) {
									echo '<option value="' . $option . '" selected>' . $option . '</option>';
								} else {
									echo '<option value="' . $option . '">' . $option . '</option>';
								}
							}
						?>
					</select>
					<p class="description">
						Please choose a blood group.
					</p>
				</td>
			</tr>
			<tr>
				<th>
					<label for="birthday">Phone Number</label>
				</th>
				<td>
					<input class="regular-text ltr" type="tel" name="bd_donor_usermeta_phone_number" pattern="/^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/"
						id="bd_donor_usermeta_phone_number" value="<?= esc_attr( get_user_meta( $user->ID, 'phone_number', true ) ) ?>">
					<p class="description">
						Please enter a phone number.
					</p>
				</td>
			</tr>
			<tr>
				<th>
					<label for="birthday">Address</label>
				</th>
				<td>
					<textarea class="regular-text ltr" name="bd_donor_usermeta_address" 
						id="bd_donor_usermeta_address" value="<?= esc_attr( get_user_meta( $user->ID, 'address', true ) ) ?>"></textarea>
					<p class="description">
						Please enter an address.
					</p>
				</td>
			</tr>
		</table>
		<?php
	}
  
	public static function bd_usermeta_form_field_update( $user_id )
	{
		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return false;
		}
	
		return update_user_meta( $user_id, 'blood_group', $_POST['bd_donor_usermeta_blood_group'] )
		 	&& update_user_meta( $user_id, 'phone_number', $_POST['bd_donor_usermeta_phone_number'] ) 
		 	&& update_user_meta( $user_id, 'address', $_POST['bd_donor_usermeta_address'] );
	}
}