<?php 
/**
 * @package  BloodDonPlugin
 */
namespace Inc\Api;

class AdminCallbacks
{
	public static function adminDashboard()
	{
		return require_once BD_PLUGIN_PATH . 'templates/admin.php';
	}

	public static function bloodDonorFirstName()
	{
		echo '<input type="text" class="regular-text" name="first_name" placeholder="First Name">';
	}

	public static function bloodDonorLastName()
	{
		echo '<input type="text" class="regular-text" name="last_name" placeholder="Last Name">';
	}

	public static function bloodDonorBloodGroup( $args )
	{
		?>
		<select id="<?php echo esc_attr( $args['label_for'] ); ?>"
				name="<?php echo esc_attr( $args['label_for'] ); ?>">
			<option value="" selected disabled>Select</option>
			<option value="A+">A+</option>
			<option value="A-">A-</option>
			<option value="B+">B+</option>
			<option value="B-">B-</option>
			<option value="AB+">AB+</option>
			<option value="AB-">AB-</option>
			<option value="O+">O+</option>
			<option value="O-">O-</option>
		</select>
		<?php
	}

	public static function bloodDonorPhoneNumber()
	{
		echo '<input type="text" class="regular-text" name="phone_number" placeholder="0XXX-XXX-XXXX">';
	}

	public static function bloodDonorEmail()
	{
		echo '<input type="text" class="regular-text" name="email" placeholder="someone@something.com">';
	}

	public static function bloodDonorAddress()
	{
		echo '<textarea class="regular-text" name="address" placeholder="Over there at that street"></textarea>';
	}
	
}